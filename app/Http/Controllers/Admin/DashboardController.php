<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\traits\DashboardTrait;
use App\Http\Controllers\Controller;
use App\Models\FeatureWebinar;
use App\Models\Role;
use App\Models\Sale;
use App\Models\Ticket;
use App\Models\Webinar;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    use DashboardTrait;

    public function index()
    {
        $this->authorize('admin_general_dashboard_show');
        $query = Sale::whereNull('product_order_id');

        $totalSales = [
            'count' => deepClone($query)->count(),
            'amount' => deepClone($query)->sum('total_amount'),
            'webinar' => deepClone($query)->whereHas('webinar', function ($query) {
                $query->where('type', Webinar::$webinar);
            })->sum('total_amount'),
            'exam' => deepClone($query)->whereHas('webinar', function ($query) {
                $query->where('type', Webinar::$course);
            })->sum('total_amount'),
            'quizzes' => deepClone($query)->whereHas('webinar', function ($query) {
                $query->where('type', Webinar::$quizz);
            })->sum('total_amount'),
        ];

        if (Gate::allows('admin_general_dashboard_daily_sales_statistics')) {
            $dailySalesTypeStatistics = $this->dailySalesTypeStatistics();
        }

        if (Gate::allows('admin_general_dashboard_income_statistics')) {
            $getIncomeStatistics = $this->getIncomeStatistics();
        }

        if (Gate::allows('admin_general_dashboard_total_sales_statistics')) {
            $getTotalSalesStatistics = $this->getTotalSalesStatistics();
        }

        if (Gate::allows('admin_general_dashboard_new_sales')) {
            $getNewSalesCount = $this->getNewSalesCount();
        }

        if (Gate::allows('admin_general_dashboard_new_comments')) {
            $getNewCommentsCount = $this->getNewCommentsCount();
        }

        if (Gate::allows('admin_general_dashboard_new_tickets')) {
            $getNewTicketsCount = $this->getNewTicketsCount();
        }

        if (Gate::allows('admin_general_dashboard_new_reviews')) {
            $getPendingReviewCount = $this->getPendingReviewCount();
        }

        if (Gate::allows('admin_general_dashboard_sales_statistics_chart')) {
            $getMonthAndYearSalesChart = $this->getMonthAndYearSalesChart('month_of_year');
            $getMonthAndYearSalesChartStatistics = $this->getMonthAndYearSalesChartStatistics();
        }

        if (Gate::allows('admin_general_dashboard_recent_comments')) {
            $recentComments = $this->getRecentComments();
        }

        if (Gate::allows('admin_general_dashboard_recent_tickets')) {
            $recentTickets = $this->getRecentTickets();
        }

        if (Gate::allows('admin_general_dashboard_recent_webinars')) {
            $recentWebinars = $this->getRecentWebinars();
        }

        if (Gate::allows('admin_general_dashboard_recent_courses')) {
            $recentCourses = $this->getRecentCourses();
        }

        if (Gate::allows('admin_general_dashboard_users_statistics_chart')) {
            $usersStatisticsChart = $this->usersStatisticsChart();
        }
        $data = [
            'totalSales' => $totalSales,
            'pageTitle' => trans('admin/main.general_dashboard_title'),
            'dailySalesTypeStatistics' => $dailySalesTypeStatistics ?? null,
            'getIncomeStatistics' => $getIncomeStatistics ?? null,
            'getTotalSalesStatistics' => $getTotalSalesStatistics ?? null,
            'getNewSalesCount' => $getNewSalesCount ?? 0,
            'getNewCommentsCount' => $getNewCommentsCount ?? 0,
            'getNewTicketsCount' => $getNewTicketsCount ?? 0,
            'getPendingReviewCount' => $getPendingReviewCount ?? 0,
            'getMonthAndYearSalesChart' => $getMonthAndYearSalesChart ?? null,
            'getMonthAndYearSalesChartStatistics' => $getMonthAndYearSalesChartStatistics ?? null,
            'recentComments' => $recentComments ?? null,
            'recentTickets' => $recentTickets ?? null,
            'recentWebinars' => $recentWebinars ?? null,
            'recentCourses' => $recentCourses ?? null,
            'usersStatisticsChart' => $usersStatisticsChart ?? null,
        ];

        return view('admin.dashboard', $data);
    }

    public function marketing()
    {
        $this->authorize('admin_marketing_dashboard_show');

        $buyerIds = Sale::whereNull('refund_at')
            ->pluck('buyer_id')
            ->toArray();
        $teacherIdsHasClass = Webinar::where('status', Webinar::$active)
            ->pluck('creator_id', 'teacher_id')
            ->toArray();
        $teacherIdsHasClass = array_merge(array_keys($teacherIdsHasClass), $teacherIdsHasClass);


        $usersWithoutPurchases = User::whereNotIn('id', array_unique($buyerIds))->count();
        $teachersWithoutClass = User::where('role_name', Role::$teacher)
            ->whereNotIn('id', array_unique($teacherIdsHasClass))
            ->count();
        $featuredClasses = FeatureWebinar::where('status', 'publish')
            ->count();

        $now = time();
        $activeDiscounts = Ticket::where('start_date', '<', $now)
            ->where('end_date', '>', $now)
            ->count();

        $getClassesStatistics = $this->getClassesStatistics();

        $getNetProfitChart = $this->getNetProfitChart();

        $getNetProfitStatistics = $this->getNetProfitStatistics();

        $getTopSellingClasses = $this->getTopSellingClasses();

        $getTopSellingAppointments = $this->getTopSellingAppointments();

        $getTopSellingTeachers = $this->getTopSellingTeachersAndOrganizations('teachers');

        $getTopSellingOrganizations = $this->getTopSellingTeachersAndOrganizations('organizations');

        $getMostActiveStudents = $this->getMostActiveStudents();
        $getClassesStatistics['labels'] = array_map(function ($label) {
            switch ($label) {
                case 'webinar':
                    return 'Outline';
                case 'course':
                    return 'Curriculum';
                case 'text_lesson':
                    return 'Dissertation';
                default:
                    return $label;
            }
        }, $getClassesStatistics['labels']);

        $revenueByCategory = DB::table('categories')
            ->select('categories.slug', DB::raw('SUM(order_items.total_amount) as total_revenue'))
            ->join('webinars', 'categories.id', '=', 'webinars.category_id')
            ->join('order_items', 'webinars.id', '=', 'order_items.webinar_id')
            ->groupBy('categories.slug')
            ->get();
        $data = [
            'pageTitle' => trans('admin/main.marketing_dashboard_title'),
            'usersWithoutPurchases' => $usersWithoutPurchases,
            'teachersWithoutClass' => $teachersWithoutClass,
            'featuredClasses' => $featuredClasses,
            'activeDiscounts' => $activeDiscounts,
            'getClassesStatistics' => $getClassesStatistics,
            'getNetProfitChart' => $getNetProfitChart,
            'getNetProfitStatistics' => $getNetProfitStatistics,
            'getTopSellingClasses' => $getTopSellingClasses,
            'revenueByCategory' => $revenueByCategory,
            'getTopSellingAppointments' => $getTopSellingAppointments,
            'getTopSellingTeachers' => $getTopSellingTeachers,
            'getTopSellingOrganizations' => $getTopSellingOrganizations,
            'getMostActiveStudents' => $getMostActiveStudents,
        ];

        return view('admin.marketing_dashboard', $data);
    }

    public function getSaleStatisticsData(Request $request)
    {
        $this->authorize('admin_general_dashboard_sales_statistics_chart');

        $type = $request->get('type');

        $chart = $this->getMonthAndYearSalesChart($type);

        return response()->json([
            'code' => 200,
            'chart' => $chart
        ], 200);
    }

    public function getNetProfitChartAjax(Request $request)
    {

        $type = $request->get('type');

        $chart = $this->getNetProfitChart($type);

        return response()->json([
            'code' => 200,
            'chart' => $chart
        ], 200);
    }

    public function cacheClear()
    {
        $this->authorize('admin_clear_cache');

        Artisan::call('clear:all', [
            '--force' => true
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => 'Website cache successfully cleared.',
            'status' => 'success'
        ];
        return back()->with(['toast' => $toastData]);
    }
}
