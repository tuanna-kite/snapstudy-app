<?php

namespace App\Http\Controllers\Admin;

use App\Exports\WebinarsAcceptExport;
use App\Exports\WebinarsExport;
use App\Exports\WebinarsXbExport;
use App\Http\Controllers\Admin\traits\WebinarChangeCreator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\WebinarStatisticController;
use App\Mail\SendNotifications;
use App\Mixins\Cashback\CashbackRules;
use App\Mixins\Installment\InstallmentPlans;
use App\Models\Accounting;
use App\Models\AdvertisingBanner;
use App\Models\BundleWebinar;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Favorite;
use App\Models\File;
use App\Models\Gift;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\InstallmentOrder;
use App\Models\Notification;
use App\Models\Prerequisite;
use App\Models\Quiz;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Role;
use App\Models\Sale;
use App\Models\Session;
use App\Models\SpecialOffer;
use App\Models\Tag;
use App\Models\TextLesson;
use App\Models\Ticket;
use App\Models\Translation\WebinarTranslation;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use App\Models\WebinarExtraDescription;
use App\Models\WebinarFilterOption;
use App\Models\WebinarPartnerTeacher;
use App\Models\WebinarType;
use App\User;
use App\Models\Webinar;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use function Symfony\Component\String\u;

class WebinarManagerController extends Controller
{
    use WebinarChangeCreator;


    public function contentIndex(Request $request)
    {
        $this->authorize('admin_webinars_qlnd');

        removeContentLocale();

        $type = $request->get('type', 'webinar');
        $query = Webinar::query();

        $totalWebinars = $query->count();
        $totalPendingWebinars = deepClone($query)->where('webinars.status', 'pending')->count();
        $totalDurations = deepClone($query)->sum('duration');
        $totalSales = deepClone($query)->join('sales', 'webinars.id', '=', 'sales.webinar_id')
            ->select(DB::raw('count(sales.webinar_id) as sales_count'))
            ->where('sales.type', '<>', 'personalization')
            ->whereNotNull('sales.webinar_id')
            ->whereNull('sales.refund_at')
            ->first();

        $categories = Category::where('parent_id', null)
            ->get()
            ->sortBy(function ($category) {
                return $category->title;
            });

        $inProgressWebinars = $this->getInProgressWebinarsCount();

        $query = $this->filterWebinar($query, $request)
            ->with([
                'category',
                'teacher' => function ($qu) {
                    $qu->select('id', 'full_name');
                },
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                }
            ]);

        $webinars = $query->paginate(10);

        if ($request->get('status', null) == 'active_finished') {
            foreach ($webinars as $key => $webinar) {
                if ($webinar->last_date > time()) { // is in progress
                    unset($webinars[$key]);
                }
            }
        }

        foreach ($webinars as $webinar) {
            $giftsIds = Gift::query()->where('webinar_id', $webinar->id)
                ->where('status', 'active')
                ->where(function ($query) {
                    $query->whereNull('date');
                    $query->orWhere('date', '<', time());
                })
                ->whereHas('sale')
                ->pluck('id')
                ->toArray();

            $sales = Sale::query()
                ->where(function ($query) use ($webinar, $giftsIds) {
                    $query->where('webinar_id', $webinar->id);
                    $query->orWhereIn('gift_id', $giftsIds);
                })
                ->where('type', '<>', 'personalization')
                ->whereNull('refund_at')
                ->get();

            $webinar->sales = $sales;
        }



        $data = [
            'pageTitle' => trans('admin/pages/webinars.webinars_list_page_title'),
            'webinars' => $webinars,
            'totalWebinars' => $totalWebinars,
            'totalPendingWebinars' => $totalPendingWebinars,
            'totalDurations' => $totalDurations,
            'totalSales' => !empty($totalSales) ? $totalSales->sales_count : 0,
            'categories' => $categories,
            'inProgressWebinars' => $inProgressWebinars ?? 0,
            'classesType' => 'webinar',
        ];

        $teacher_ids = $request->get('teacher_ids', null);
        if (!empty($teacher_ids)) {
            $data['teachers'] = User::select('id', 'full_name')->whereIn('id', $teacher_ids)->get();
        }
        $creator_ids = $request->get('creator_ids', null);
        if (!empty($creator_ids)) {
            $data['creators'] = User::select('id', 'full_name')->whereIn('id', $creator_ids)->get();
        }

        return view('admin.webinar_qlnd.lists', $data);
    }

    private function filterWebinar($query, $request)
    {
        // Get data from request
        $from = $request->get('from', null);
        $to = $request->get('to', null);
        $title = $request->get('title', null);
        $teacher_ids = $request->get('teacher_ids', null);
        $school_id = $request->get('school_id', null);
        $campus_id = $request->get('campus_id', null);
        $subject_id = $request->get('subject_id', null);
        $status = $request->get('status', null);
        $sort = $request->get('sort', null);
        $assigned_id = $request->get('assigned_id', null);

        $query = fromAndToDateFilter($from, $to, $query, 'webinars.created_at');


        if (!empty($title)) {
            $query->whereTranslationLike('title', '%' . $title . '%');
        }

        if (!empty($title)) {
            $query->orWhere('id', $title);
        }

        if (!empty($teacher_ids) and count($teacher_ids)) {
            $query->whereIn('teacher_id', $teacher_ids);
        }

        if (!empty($assigned_id) and count($assigned_id)) {
            $query->whereIn('assigned_user', $assigned_id);
        }

        if (!empty($school_id) && empty($campus_id) && empty($subject_id)) {
            $campus_list = Category::where('parent_id', $school_id)
                ->pluck('id');
            $subject_list = Category::whereIn('parent_id', $campus_list)
                ->pluck('id');
            $query->whereIn('category_id', $subject_list);
        }

        if (!empty($campus_id) && empty($subject_id)) {
            $subject_list = Category::where('parent_id', $campus_id)
                ->pluck('id');
            $query->whereIn('category_id', $subject_list);
        }

        if (!empty($subject_id)) {
            $query->where('category_id', $subject_id);
        }

        if (!empty($status)) {
            $time = time();

            switch ($status) {
                case 'active_not_conducted':
                    $query->where('webinars.status', 'active')
                        ->where('start_date', '>', $time);
                    break;
                case 'active_in_progress':
                    $query->where('webinars.status', 'active')
                        ->where('start_date', '<=', $time)
                        ->join('sessions', 'webinars.id', '=', 'sessions.webinar_id')
                        ->select('webinars.*', 'sessions.date', DB::raw('max(`date`) as last_date'))
                        ->groupBy('sessions.webinar_id')
                        ->where('sessions.date', '>', $time);
                    break;
                case 'active_finished':
                    $query->where('webinars.status', 'active')
                        ->where('start_date', '<=', $time)
                        ->join('sessions', 'webinars.id', '=', 'sessions.webinar_id')
                        ->select('webinars.*', 'sessions.date', DB::raw('max(`date`) as last_date'))
                        ->groupBy('sessions.webinar_id');
                    break;
                default:
                    $query->where('webinars.status', $status);
                    break;
            }
        }

        if (!empty($sort)) {
            switch ($sort) {
                case 'has_discount':
                    $now = time();
                    $webinarIdsHasDiscount = [];

                    $tickets = Ticket::where('start_date', '<', $now)
                        ->where('end_date', '>', $now)
                        ->get();

                    foreach ($tickets as $ticket) {
                        if ($ticket->isValid()) {
                            $webinarIdsHasDiscount[] = $ticket->webinar_id;
                        }
                    }

                    $specialOffersWebinarIds = SpecialOffer::where('status', 'active')
                        ->where('from_date', '<', $now)
                        ->where('to_date', '>', $now)
                        ->pluck('webinar_id')
                        ->toArray();

                    $webinarIdsHasDiscount = array_merge($specialOffersWebinarIds, $webinarIdsHasDiscount);

                    $query->whereIn('id', $webinarIdsHasDiscount)
                        ->orderBy('webinars.created_at', 'desc');
                    break;
                case 'sales_asc':
                    $query->join('sales', 'webinars.id', '=', 'sales.webinar_id')
                        ->select(
                            'webinars.*',
                            'sales.webinar_id',
                            'sales.refund_at',
                            DB::raw('count(sales.webinar_id) as sales_count')
                        )
                        ->whereNotNull('sales.webinar_id')
                        ->whereNull('sales.refund_at')
                        ->groupBy('sales.webinar_id')
                        ->orderBy('sales_count', 'asc');
                    break;
                case 'sales_desc':
                    $query->join('sales', 'webinars.id', '=', 'sales.webinar_id')
                        ->select(
                            'webinars.*',
                            'sales.webinar_id',
                            'sales.refund_at',
                            DB::raw('count(sales.webinar_id) as sales_count')
                        )
                        ->whereNotNull('sales.webinar_id')
                        ->whereNull('sales.refund_at')
                        ->groupBy('sales.webinar_id')
                        ->orderBy('sales_count', 'desc');
                    break;

                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;

                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;

                case 'income_asc':
                    $query->join('sales', 'webinars.id', '=', 'sales.webinar_id')
                        ->select(
                            'webinars.*',
                            'sales.webinar_id',
                            'sales.total_amount',
                            'sales.refund_at',
                            DB::raw('(sum(sales.total_amount) - (sum(sales.tax) + sum(sales.commission))) as amounts')
                        )
                        ->whereNotNull('sales.webinar_id')
                        ->whereNull('sales.refund_at')
                        ->groupBy('sales.webinar_id')
                        ->orderBy('amounts', 'asc');
                    break;

                case 'income_desc':
                    $query->join('sales', 'webinars.id', '=', 'sales.webinar_id')
                        ->select(
                            'webinars.*',
                            'sales.webinar_id',
                            'sales.total_amount',
                            'sales.refund_at',
                            DB::raw('(sum(sales.total_amount) - (sum(sales.tax) + sum(sales.commission))) as amounts')
                        )
                        ->whereNotNull('sales.webinar_id')
                        ->whereNull('sales.refund_at')
                        ->groupBy('sales.webinar_id')
                        ->orderBy('amounts', 'desc');
                    break;

                case 'created_at_asc':
                    $query->orderBy('webinars.created_at', 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('webinars.created_at', 'desc');
                    break;

                case 'updated_at_asc':
                    $query->orderBy('webinars.updated_at', 'asc');
                    break;

                case 'updated_at_desc':
                    $query->orderBy('webinars.updated_at', 'desc');
                    break;

                case 'public_courses':
                    $query->where('private', false);
                    $query->orderBy('webinars.created_at', 'desc');
                    break;

                case 'courses_private':
                    $query->where('private', true);
                    $query->orderBy('webinars.created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('webinars.created_at', 'desc');
        }

        return $query;
    }

    private function getInProgressWebinarsCount()
    {
        $count = 0;
        $webinars = Webinar::
            where('status', 'active')
            ->where('start_date', '<=', time())
            ->whereHas('sessions')
            ->get();

        foreach ($webinars as $webinar) {
            if ($webinar->isProgressing()) {
                $count += 1;
            }
        }

        return $count;
    }

    public function contentCreate()
    {
        $this->authorize('admin_webinars_qlnd');

        removeContentLocale();

        $teachers = User::where('role_name', Role::$teacher)->get();
        $categories = Category::where('parent_id', null)
            ->get()
            ->sortBy(function ($category) {
                return $category->title;
            });
        $users = Accounting::join('users', 'users.id', '=', 'accounting.user_id')
            ->where('is_personalization', 1)
            ->groupBy('user_id')
            ->get();
        $staffsRoles = Role::where('is_admin', true)->get();
        $staffsRoleIds = $staffsRoles->pluck('id')->toArray();

        $ctv = User::where('status', 'active')
            ->where('role_id', 12)
            ->orderBy('full_name')
            ->get();

        $genres = WebinarType::where('status', 'active')
            ->get();

        $data = [
            'pageTitle' => trans('admin/main.webinar_new_page_title'),
            'teachers' => $teachers,
            'categories' => $categories,
            'users' => $users,
            'genres' => $genres,
            'ctv' => $ctv
        ];

        return view('admin.webinar_qlnd.create', $data);
    }

    public function contentStore(Request $request)
    {
        $this->authorize('admin_webinars_qlnd');
        $user = Auth::user()->id;
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'max:255|unique:webinars,slug',
            'teacher_id' => 'required|exists:users,id',
            'category_id' => 'required',
            'description' => 'required',
            'implementation_cost' => 'required',
            'assigned_user' => 'required',
            'genre' => 'required'
        ]);

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = Webinar::makeSlug($data['title']);
        }

        if (empty($data['video_demo'])) {
            $data['video_demo_source'] = null;
        }

        if (!empty($data['genre'])) {
            $data['price'] = WebinarType::find($data['genre'])->price;
        }

        if (
            !empty($data['video_demo_source']) and !in_array(
                $data['video_demo_source'],
                ['upload', 'youtube', 'vimeo', 'external_link']
            )
        ) {
            $data['video_demo_source'] = 'upload';
        }

        $data['price'] = !empty($data['price']) ? convertPriceToDefaultCurrency($data['price']) : null;

        $data['organization_price'] = !empty($data['organization_price']) ? convertPriceToDefaultCurrency($data['organization_price']) : null;
        $webinar = Webinar::create([
            'type' => Webinar::$webinar,
            'slug' => preg_replace(
                '/[^A-Za-z0-9\-]/',
                '',
                str_replace(' ', '-', strtolower($data['slug']))
            ) . '-' . Str::random(5),
            'teacher_id' => $data['teacher_id'],
            'creator_id' => $data['creator_id'],
            'category_id' => $data['category_id'],
            'price' => $data['price'] ?? 0,
            'thumbnail' => $data['thumbnail'] ?? null,
            'implementation_cost' => $data['implementation_cost'],
            'support' => !empty($data['support']),
            'downloadable' => !empty($data['downloadable']),
            'partner_instructor' => !empty($data['partner_instructor']),
            'subscribe' => !empty($data['subscribe']),
            'private' => !empty($data['private']),
            'forum' => !empty($data['forum']),
            'enable_waitlist' => (!empty($data['enable_waitlist'])),
            'organization_price' => $data['organization_price'] ?? null,
            'personalization_user' => $data['personalization_user'] ?? null,
            'assigned_user' => $data['assigned_user'] ?? null,
            'genre' => $data['genre'] ?? null,
            'status' => Webinar::$assigned,
            'created_at' => time(),
            'updated_at' => time(),

        ]);

        $code = $this->createWebinarCode($webinar);
        $webinar->update([
            'code' => $code ?? '',
        ]);

        if ($webinar) {
            WebinarTranslation::updateOrCreate([
                'webinar_id' => $webinar->id,
                'locale' => mb_strtolower($data['locale']),
                'title' => $data['title'],
                'seo_description' => $data['seo_description'],
                'description' => $data['description'],
            ]);
        }

        return redirect(getAdminPanelUrl() . '/webinars/content/' . $webinar->id . '/edit?locale=' . $data['locale']);
    }

    public function contentEdit(Request $request, $id)
    {
        $this->authorize('admin_webinars_qlnd');

        $webinar = Webinar::where('id', $id)
            ->with([
                'tickets',
                'sessions',
                'files',
                'faqs',
                'category' => function ($query) {
                    $query->with([
                        'filters' => function ($query) {
                            $query->with('options');
                        }
                    ]);
                },
                'filterOptions',
                'prerequisites',
                'quizzes' => function ($query) {
                    $query->with([
                        'quizQuestions' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }
                    ]);
                },
                'webinarPartnerTeacher' => function ($query) {
                    $query->with([
                        'teacher' => function ($query) {
                            $query->select('id', 'full_name');
                        }
                    ]);
                },
                'tags',
                'textLessons',
                'assignments',
                'chapters' => function ($query) {
                    $query->orderBy('order', 'asc');
                    $query->with([
                        'chapterItems' => function ($query) {
                            $query->orderBy('order', 'asc');

                            $query->with([
                                'quiz' => function ($query) {
                                    $query->with([
                                        'quizQuestions' => function ($query) {
                                            $query->orderBy('order', 'asc');
                                        }
                                    ]);
                                }
                            ]);
                        }
                    ]);
                },
            ])
            ->first();
        if (empty($webinar)) {
            abort(404);
        }

        $locale = $request->get('locale', app()->getLocale());
        storeContentLocale($locale, $webinar->getTable(), $webinar->id);
        $webinarTrans = WebinarTranslation::where([
            'locale' => mb_strtolower($locale),
            'webinar_id' => $id
        ])->first();

        $subject = Category::find($webinar->category_id);

        $major = Category::where('id', $subject->parent_id)
            ->with('subCategories')
            ->first();

        $school = Category::where('id', $major->parent_id)
            ->with('subCategories')
            ->first();

        if ($school) {
            $major_list = Category::where('parent_id', $school->id)
                ->with('subCategories')
                ->get();
        }

        $subject_list = Category::where('parent_id', $major->id)
            ->with('subCategories')
            ->get();

        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get()
            ->sortBy(function ($category) {
                return $category->title;
            });

        $teacherQuizzes = Quiz::where('webinar_id', null)
            ->where('creator_id', $webinar->teacher_id)
            ->get();

        $users = Accounting::join('users', 'users.id', '=', 'accounting.user_id')
            ->where('is_personalization', 1)
            ->groupBy('user_id')
            ->get();

        $tags = $webinar->tags->pluck('title')->toArray();

        $genres = WebinarType::where('status', 'active')
            ->get();

        $ctv = User::where('status', 'active')
            ->where('role_id', 12)
            ->orderBy('full_name')
            ->get();


        $data = [
            'pageTitle' => trans('admin/main.edit') . ' | ' . $webinar->title,
            'categories' => $categories,
            'webinar' => $webinar,
            'webinarCategoryFilters' => !empty($webinar->category) ? $webinar->category->filters : null,
            'webinarFilterOptions' => $webinar->filterOptions->pluck('filter_option_id')->toArray(),
            'tickets' => $webinar->tickets,
            'chapters' => $webinar->chapters,
            'sessions' => $webinar->sessions,
            'files' => $webinar->files,
            'textLessons' => $webinar->textLessons,
            'faqs' => $webinar->faqs,
            'assignments' => $webinar->assignments,
            'teacherQuizzes' => $teacherQuizzes,
            'prerequisites' => $webinar->prerequisites,
            'webinarQuizzes' => $webinar->quizzes,
            'webinarPartnerTeacher' => $webinar->webinarPartnerTeacher,
            'webinarTags' => $tags,
            'defaultLocale' => getDefaultLocale(),
            'content' => $webinarTrans ? $webinarTrans->content : '',
            'table_contents' => $webinarTrans ? $webinarTrans->table_contents : '',
            'preview_content' => $webinarTrans ? $webinarTrans->preview_content : '',
            'major' => $major,
            'school' => $school,
            'subject_list' => $subject_list,
            'major_list' => $major_list ?? null,
            'subject' => $subject,
            'users' => $users,
            'genres' => $genres,
            'ctv' => $ctv
        ];

        return view('admin.webinar_qlnd.create', $data);
    }

    public function contentUpdate(Request $request, $id)
    {
        $this->authorize('admin_webinars_qlnd');
        $data = $request->all();

        $webinar = Webinar::find($id);
        $reject = (!empty($data['draft']) and $data['draft'] == 'inactive');
        $assigned = (!empty($data['draft']) and $data['draft'] == 'assigned');
        $pending = (!empty($data['draft']) and $data['draft'] == 'pending');


        $rules = [
            'title' => 'required|max:255',
            'teacher_id' => 'required|exists:users,id',
            'category_id' => 'required',
            'description' => 'required',
            'implementation_cost' => 'required',
            'assigned_user' => 'required',
            'genre' => 'required'
        ];

        $this->validate($request, $rules);

        if (!empty($data['teacher_id'])) {
            $teacher = User::find($data['teacher_id']);
            $creator = !empty($data['organ_id']) ? User::find($data['organ_id']) : $webinar->creator;

            if (empty($teacher) or ($creator->isOrganization() and ($teacher->organ_id != $creator->id and $teacher->id != $creator->id))) {
                $toastData = [
                    'title' => trans('public.request_failed'),
                    'msg' => trans('admin/main.is_not_the_teacher_of_this_organization'),
                    'status' => 'error'
                ];
                return back()->with(['toast' => $toastData]);
            }
        }

        $data['status'] = $assigned ? Webinar::$assigned : ($reject ? Webinar::$inactive : ($pending ? Webinar::$pending : Webinar::$assigned));

        if(!$reject) {
            unset($data['message_for_reviewer']);
        }

        $data['partner_instructor'] = !empty($data['partner_instructor']) ? true : false;

        if (empty($data['partner_instructor'])) {
            WebinarPartnerTeacher::where('webinar_id', $webinar->id)->delete();
            unset($data['partners']);
        }

        if ($data['category_id'] !== $webinar->category_id) {
            WebinarFilterOption::where('webinar_id', $webinar->id)->delete();
        }

        $filters = $request->get('filters', null);
        if (!empty($filters) and is_array($filters)) {
            WebinarFilterOption::where('webinar_id', $webinar->id)->delete();
            foreach ($filters as $filter) {
                WebinarFilterOption::create([
                    'webinar_id' => $webinar->id,
                    'filter_option_id' => $filter
                ]);
            }
        }

        if (!empty($request->get('tags'))) {
            $tags = explode(',', $request->get('tags'));
            Tag::where('webinar_id', $webinar->id)->delete();

            foreach ($tags as $tag) {
                Tag::create([
                    'webinar_id' => $webinar->id,
                    'title' => $tag,
                ]);
            }
        }

        if (!empty($request->get('partner_instructor')) and !empty($request->get('partners'))) {
            WebinarPartnerTeacher::where('webinar_id', $webinar->id)->delete();

            foreach ($request->get('partners') as $partnerId) {
                WebinarPartnerTeacher::create([
                    'webinar_id' => $webinar->id,
                    'teacher_id' => $partnerId,
                ]);
            }
        }
        unset(
            $data['_token'],
            $data['current_step'],
            $data['draft'],
            $data['get_next'],
            $data['partners'],
            $data['tags'],
            $data['filters'],
            $data['ajax']
        );

        if (empty($data['video_demo'])) {
            $data['video_demo_source'] = null;
        }

        if (
            !empty($data['video_demo_source']) and !in_array(
                $data['video_demo_source'],
                ['upload', 'youtube', 'vimeo', 'external_link']
            )
        ) {
            $data['video_demo_source'] = 'upload';
        }
        if (!empty($data['genre'])) {
            $data['price'] = WebinarType::find($data['genre'])->price;
        }

        $newCreatorId = !empty($data['organ_id']) ? $data['organ_id'] : $data['teacher_id'];
        $changedCreator = ($webinar->creator_id != $newCreatorId);

        $data['price'] = !empty($data['price']) ? convertPriceToDefaultCurrency($data['price']) : null;
        $data['organization_price'] = !empty($data['organization_price']) ? convertPriceToDefaultCurrency($data['organization_price']) : null;

        $webinar->update([
            'slug' => $data['slug'],
            'timezone' => $data['timezone'] ?? null,
            'duration' => $data['duration'] ?? null,
            'enable_waitlist' => (!empty($data['enable_waitlist'])),
            'downloadable' => !empty($data['downloadable']),
            'support' => !empty($data['support']),
            'partner_instructor' => !empty($data['partner_instructor']),
            'subscribe' => !empty($data['subscribe']),
            'private' => !empty($data['private']),
            'forum' => !empty($data['forum']),
            'implementation_cost' => $data['implementation_cost'],
            'organization_price' => $data['organization_price'] ?? null,
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'points' => $data['points'] ?? null,
            'message_for_reviewer' => $data['message_for_reviewer'] ?? null,
            'personalization_user' => $data['personalization_user'] ?? null,
            'assigned_user' => $data['assigned_user'] ?? null,
            'genre' => $data['genre'] ?? null,
            'status' => $data['status'],
            'updated_at' => time(),
        ]);

        if ($webinar) {
            WebinarTranslation::updateOrCreate([
                'webinar_id' => $webinar->id,
                'locale' => mb_strtolower($data['locale']),
            ], [
                'title' => $data['title'],
                'description' => $data['description'],
                'seo_description' => $data['seo_description'],
            ]);
        }

        if ($reject) {
            // sendNotification('course_reject', ['[c.title]' => $webinar->title], $webinar->teacher_id);
        }

        if ($changedCreator) {
            $this->webinarChangedCreator($webinar);
        }

        removeContentLocale();

        return back();
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('admin_webinars_qlnd');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->delete();

        return redirect(getAdminPanelUrl() . '/webinars/content');
    }

    public function reject(Request $request, $id)
    {
        $this->authorize('admin_webinars_qlnd');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->update([
            'status' => Webinar::$inactive
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('update.course_status_changes_to_rejected'),
            'status' => 'success'
        ];

        return redirect(getAdminPanelUrl() . '/webinars/content')->with(['toast' => $toastData]);
    }

    public function reviewed(Request $request, $id)
    {
        $this->authorize('admin_webinars_qlnd');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->update([
            'status' => Webinar::$reviewed
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('Tài liệu đã được gửi phê duyệt thành công'),
            'status' => 'success'
        ];

        return redirect(getAdminPanelUrl() . '/webinars/content')->with(['toast' => $toastData]);
    }

    public function search(Request $request)
    {

        $term = $request->get('term');

        $option = $request->get('option', null);

        $query = Webinar::select('id')
            ->whereTranslationLike('title', "%$term%");

        if (!empty($option) and $option == 'just_webinar') {
            $query->where('type', Webinar::$webinar);
            $query->where('status', Webinar::$active);
        }

        $webinar = $query->get();

        return response()->json($webinar, 200);
    }

    public function exportExcel(Request $request)
    {
//        $this->authorize('admin_webinars_export_excel');

        $query = Webinar::query();

        $query = $this->filterWebinar($query, $request)
            ->with([
                'teacher' => function ($qu) {
                    $qu->select('id', 'full_name');
                },
                'sales'
            ]);

        $webinars = $query->get();

        $webinarExport = new WebinarsXbExport($webinars);

        return Excel::download($webinarExport, 'webinars.xlsx');
    }

    public function preview($id, $justReturnData = false)
    {
        $user = null;

        if (auth()->check()) {
            $user = auth()->user();
        }

        $course = Webinar::where('id', $id)
            ->with([
                'quizzes' => function ($query) {
                    $query->where('status', 'active')
                        ->with(['quizResults', 'quizQuestions']);
                },
                'tags',
                'prerequisites' => function ($query) {
                    $query->with([
                        'prerequisiteWebinar' => function ($query) {
                            $query->with([
                                'teacher' => function ($qu) {
                                    $qu->select('id', 'full_name', 'avatar');
                                }
                            ]);
                        }
                    ]);
                    $query->orderBy('order', 'asc');
                },
                'faqs' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'webinarExtraDescription' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'chapters' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive);
                    $query->orderBy('order', 'asc');

                    $query->with([
                        'chapterItems' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }
                    ]);
                },
                'files' => function ($query) use ($user) {
                    $query->join('webinar_chapters', 'webinar_chapters.id', '=', 'files.chapter_id')
                        ->select('files.*', DB::raw('webinar_chapters.order as chapterOrder'))
                        ->where('files.status', WebinarChapter::$chapterActive)
                        ->orderBy('chapterOrder', 'asc')
                        ->orderBy('files.order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'textLessons' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->withCount(['attachments'])
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'sessions' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'assignments' => function ($query) {
                    $query->where('status', WebinarChapter::$chapterActive);
                },
                'tickets' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'filterOptions',
                'category',
                'teacher',
                'reviews' => function ($query) {
                    $query->where('status', 'active');
                    $query->with([
                        'comments' => function ($query) {
                            $query->where('status', 'active');
                        },
                        'creator' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }
                    ]);
                },
                'comments' => function ($query) {
                    $query->where('status', 'active');
                    $query->whereNull('reply_id');
                    $query->with([
                        'user' => function ($query) {
                            $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                        },
                        'replies' => function ($query) {
                            $query->where('status', 'active');
                            $query->with([
                                'user' => function ($query) {
                                    $query->select(
                                        'id',
                                        'full_name',
                                        'role_name',
                                        'role_id',
                                        'avatar',
                                        'avatar_settings'
                                    );
                                }
                            ]);
                        }
                    ]);
                    $query->orderBy('created_at', 'desc');
                },
            ])
            ->withCount([
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                },
                'noticeboards'
            ])
            ->first();


        if (empty($course)) {
            return $justReturnData ? false : back();
        }


        $hasBought = true;
        $isPrivate = $course->private;

        if (!empty($user) and ($user->id == $course->creator_id or $user->organ_id == $course->creator_id or $user->isAdmin())) {
            $isPrivate = false;
        }

        if ($isPrivate and $hasBought) { // check the user has bought the course or not
            $isPrivate = false;
        }

        if ($isPrivate) {
            return $justReturnData ? false : back();
        }

        $isFavorite = false;

        if (!empty($user)) {
            $isFavorite = Favorite::where('webinar_id', $course->id)
                ->where('user_id', $user->id)
                ->first();
        }

        $webinarContentCount = 0;
        if (!empty($course->sessions)) {
            $webinarContentCount += $course->sessions->count();
        }
        if (!empty($course->files)) {
            $webinarContentCount += $course->files->count();
        }
        if (!empty($course->textLessons)) {
            $webinarContentCount += $course->textLessons->count();
        }
        if (!empty($course->quizzes)) {
            $webinarContentCount += $course->quizzes->count();
        }
        if (!empty($course->assignments)) {
            $webinarContentCount += $course->assignments->count();
        }

        $advertisingBanners = AdvertisingBanner::where('published', true)
            ->whereIn('position', ['course', 'course_sidebar'])
            ->get();

        $sessionsWithoutChapter = $course->sessions->whereNull('chapter_id');

        $filesWithoutChapter = $course->files->whereNull('chapter_id');

        $textLessonsWithoutChapter = $course->textLessons->whereNull('chapter_id');

        //        $quizzes = $course->quizzes->whereNull('chapter_id');

        if ($user) {

            if (!empty($course->chapters) and count($course->chapters)) {
                foreach ($course->chapters as $chapter) {
                    if (!empty($chapter->chapterItems) and count($chapter->chapterItems)) {
                        foreach ($chapter->chapterItems as $chapterItem) {
                            if (!empty($chapterItem->quiz)) {
                                $chapterItem->quiz = $this->checkQuizResults($user, $chapterItem->quiz);
                            }
                        }
                    }
                }
            }
        }

        $pageRobot = getPageRobot('course_show'); // index
        $canSale = ($course->canSale() and !$hasBought);

        /* Installments */
        $showInstallments = true;

        if ($canSale and !empty($course->price) and $course->price > 0 and $showInstallments and getInstallmentsSettings('status') and (empty($user) or $user->enable_installments)) {
            $installmentPlans = new InstallmentPlans($user);
            $installments = $installmentPlans->getPlans(
                'courses',
                $course->id,
                $course->type,
                $course->category_id,
                $course->teacher_id
            );
        }

        /* Cashback Rules */
        if ($canSale and !empty($course->price) and getFeaturesSettings('cashback_active') and (empty($user) or !$user->disable_cashback)) {
            $cashbackRulesMixin = new CashbackRules($user);
            $cashbackRules = $cashbackRulesMixin->getRules(
                'courses',
                $course->id,
                $course->type,
                $course->category_id,
                $course->teacher_id
            );
        }

        $docTrans = WebinarTranslation::where('webinar_id', '=', $course->id)->first();

        $newDoc = $this->convertHTMLImgSrc($docTrans->content);
        $docTrans->content = $newDoc;

        $data = [
            'pageTitle' => $course->title,
            'pageDescription' => $course->seo_description,
            'pageRobot' => $pageRobot,
            'pageMetaImage' => $course->getImage(),
            'course' => $course,
            'docTrans' => $docTrans,
            'isFavorite' => $isFavorite,
            'hasBought' => $hasBought,
            'user' => $user,
            'webinarContentCount' => $webinarContentCount,
            'advertisingBanners' => $advertisingBanners->where('position', 'course'),
            'advertisingBannersSidebar' => $advertisingBanners->where('position', 'course_sidebar'),
            'activeSpecialOffer' => $course->activeSpecialOffer(),
            'sessionsWithoutChapter' => $sessionsWithoutChapter,
            'filesWithoutChapter' => $filesWithoutChapter,
            'textLessonsWithoutChapter' => $textLessonsWithoutChapter,
            'installments' => $installments ?? null,
            'cashbackRules' => $cashbackRules ?? null,
        ];

        return view('admin.webinars.course-preview', $data);
    }

    public function convertHTMLImgSrc($htmlContent)
    {
        // Create a new DOMDocument
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'));

        // Get all img tags
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (strpos($src, '../../') === 0) {
                $newSrc = str_replace('../../', 'https://snapstudy.vn/', $src);
                $img->setAttribute('src', $newSrc);
            }
        }

        $modifiedHtml = $dom->saveHTML();

        return $modifiedHtml;
    }

    public function createWebinarCode($webinar)
    {
        $year = date("Y");
        $lastTwoDigits = substr($year, -2);
        $code = '';
        switch ($webinar->type) {
            case "webinar":
                $type = '01';
                break;
            case "course":
                $type = '02';
                break;
            case "quizz":
                $type = '03';
                break;
            default:
                $type = '00';
        }
        $code = 'VN' . $webinar->category->category->category->prefix . $webinar->category->category->campus_code . $lastTwoDigits .
            $webinar->category->subject_code . $type . $webinar->id;

        return $code;

    }

    public function copyCourse($id)
    {
        $webinar = Webinar::find($id);

        if (!$webinar) {
            return redirect()->back()->with('error', 'Khóa học không tồn tại.');
        }

        $newCourse = $webinar->replicate();
        $newCourse->status = Webinar::$pending;
        $newCourse->code = null;
        $newCourse->created_at = time();
        $newCourse->updated_at = time();
        $newCourse->code = null;
        $newCourse->slug = $webinar->slug . '-' . Str::random(5);
        unset($newCourse->locale);
        $newCourse->save();

        $webinarTranslation = WebinarTranslation::where('webinar_id', $id)->first();
        $webinarTranslationNew = $webinarTranslation->replicate();
        $webinarTranslationNew->title = $webinar->title . ' (Copy)';
        $webinarTranslationNew->webinar_id = $newCourse->id;
        $webinarTranslationNew->save();


        return redirect()->route('webinar.index')->with('success', 'Khóa học đã được sao chép thành công.');
    }

    public function assignIndex(Request $request)
    {
        $this->authorize('admin_webinars_ctv');
        $user = auth()->user();

        removeContentLocale();

        $query = Webinar::query()
            ->where('assigned_user', $user->id);

        $totalWebinars = $query->count();
        $totalPendingWebinars = deepClone($query)->where('webinars.status', 'pending')->count();
        $totalDurations = deepClone($query)->sum('duration');
        $totalSales = deepClone($query)->join('sales', 'webinars.id', '=', 'sales.webinar_id')
            ->select(DB::raw('count(sales.webinar_id) as sales_count'))
            ->where('sales.type', '<>', 'personalization')
            ->whereNotNull('sales.webinar_id')
            ->whereNull('sales.refund_at')
            ->first();

        $categories = Category::where('parent_id', null)
            ->get()
            ->sortBy(function ($category) {
                return $category->title;
            });

        $inProgressWebinars = $this->getInProgressWebinarsCount();

        $query = $this->filterWebinar($query, $request)
            ->with([
                'category',
                'teacher' => function ($qu) {
                    $qu->select('id', 'full_name');
                },
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                }
            ]);

        $webinars = $query->paginate(10);

        if ($request->get('status', null) == 'active_finished') {
            foreach ($webinars as $key => $webinar) {
                if ($webinar->last_date > time()) {
                    unset($webinars[$key]);
                }
            }
        }


        $data = [
            'pageTitle' => trans('admin/pages/webinars.webinars_list_page_title'),
            'webinars' => $webinars,
            'totalWebinars' => $totalWebinars,
            'totalPendingWebinars' => $totalPendingWebinars,
            'totalDurations' => $totalDurations,
            'totalSales' => !empty($totalSales) ? $totalSales->sales_count : 0,
            'categories' => $categories,
            'inProgressWebinars' => $inProgressWebinars ?? 0,
            'classesType' => 'webinar',
        ];

        $teacher_ids = $request->get('teacher_ids', null);
        if (!empty($teacher_ids)) {
            $data['teachers'] = User::select('id', 'full_name')->whereIn('id', $teacher_ids)->get();
        }
        $creator_ids = $request->get('creator_ids', null);
        if (!empty($creator_ids)) {
            $data['creators'] = User::select('id', 'full_name')->whereIn('id', $creator_ids)->get();
        }

        return view('admin.webinar_ctv.lists', $data);
    }

    public function assignEdit(Request $request, $id)
    {
        $this->authorize('admin_webinars_ctv');

        $webinar = Webinar::where('id', $id)
            ->with([
                'tickets',
                'sessions',
                'files',
                'faqs',
                'category' => function ($query) {
                    $query->with([
                        'filters' => function ($query) {
                            $query->with('options');
                        }
                    ]);
                },
                'filterOptions',
                'prerequisites',
                'quizzes' => function ($query) {
                    $query->with([
                        'quizQuestions' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }
                    ]);
                },
                'webinarPartnerTeacher' => function ($query) {
                    $query->with([
                        'teacher' => function ($query) {
                            $query->select('id', 'full_name');
                        }
                    ]);
                },
                'tags',
                'textLessons',
                'assignments',
                'chapters' => function ($query) {
                    $query->orderBy('order', 'asc');
                    $query->with([
                        'chapterItems' => function ($query) {
                            $query->orderBy('order', 'asc');

                            $query->with([
                                'quiz' => function ($query) {
                                    $query->with([
                                        'quizQuestions' => function ($query) {
                                            $query->orderBy('order', 'asc');
                                        }
                                    ]);
                                }
                            ]);
                        }
                    ]);
                },
            ])
            ->first();
        if (empty($webinar)) {
            abort(404);
        }

        $locale = $request->get('locale', app()->getLocale());
        storeContentLocale($locale, $webinar->getTable(), $webinar->id);
        $webinarTrans = WebinarTranslation::where([
            'locale' => mb_strtolower($locale),
            'webinar_id' => $id
        ])->first();

        $subject = Category::find($webinar->category_id);

        $major = Category::where('id', $subject->parent_id)
            ->with('subCategories')
            ->first();

        $school = Category::where('id', $major->parent_id)
            ->with('subCategories')
            ->first();

        if ($school) {
            $major_list = Category::where('parent_id', $school->id)
                ->with('subCategories')
                ->get();
        }

        $subject_list = Category::where('parent_id', $major->id)
            ->with('subCategories')
            ->get();

        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get()
            ->sortBy(function ($category) {
                return $category->title;
            });

        $teacherQuizzes = Quiz::where('webinar_id', null)
            ->where('creator_id', $webinar->teacher_id)
            ->get();

        $users = Accounting::join('users', 'users.id', '=', 'accounting.user_id')
            ->where('is_personalization', 1)
            ->groupBy('user_id')
            ->get();

        $tags = $webinar->tags->pluck('title')->toArray();

        $genres = WebinarType::where('status', 'active')
            ->get();

        $staffsRoles = Role::where('is_admin', true)->get();
        $staffsRoleIds = $staffsRoles->pluck('id')->toArray();

        $ctv = User::where('status', 'active')
            ->where('role_id', 12)
            ->orderBy('full_name')
            ->get();


        $data = [
            'pageTitle' => trans('admin/main.edit') . ' | ' . $webinar->title,
            'categories' => $categories,
            'webinar' => $webinar,
            'webinarCategoryFilters' => !empty($webinar->category) ? $webinar->category->filters : null,
            'webinarFilterOptions' => $webinar->filterOptions->pluck('filter_option_id')->toArray(),
            'tickets' => $webinar->tickets,
            'chapters' => $webinar->chapters,
            'sessions' => $webinar->sessions,
            'files' => $webinar->files,
            'textLessons' => $webinar->textLessons,
            'faqs' => $webinar->faqs,
            'assignments' => $webinar->assignments,
            'teacherQuizzes' => $teacherQuizzes,
            'prerequisites' => $webinar->prerequisites,
            'webinarQuizzes' => $webinar->quizzes,
            'webinarPartnerTeacher' => $webinar->webinarPartnerTeacher,
            'webinarTags' => $tags,
            'defaultLocale' => getDefaultLocale(),
            'content' => $webinarTrans ? $webinarTrans->content : '',
            'table_contents' => $webinarTrans ? $webinarTrans->table_contents : '',
            'preview_content' => $webinarTrans ? $webinarTrans->preview_content : '',
            'major' => $major,
            'school' => $school,
            'subject_list' => $subject_list,
            'major_list' => $major_list ?? null,
            'subject' => $subject,
            'users' => $users,
            'genres' => $genres,
            'ctv' => $ctv
        ];

        return view('admin.webinar_ctv.create', $data);
    }

    public function publishIndex(Request $request)
    {
        $this->authorize('admin_webinars_qlxb');

        removeContentLocale();

        $query = Webinar::query();

        $totalWebinars = $query->count();
        $totalPendingWebinars = deepClone($query)->where('webinars.status', 'pending')->count();
        $totalDurations = deepClone($query)->sum('duration');
        $totalSales = deepClone($query)->join('sales', 'webinars.id', '=', 'sales.webinar_id')
            ->select(DB::raw('count(sales.webinar_id) as sales_count'))
            ->where('sales.type', '<>', 'personalization')
            ->whereIn('status', ['active', 'pending'])
            ->whereNotNull('sales.webinar_id')
            ->whereNull('sales.refund_at')
            ->first();

        $categories = Category::where('parent_id', null)
            ->get()
            ->sortBy(function ($category) {
                return $category->title;
            });

        $inProgressWebinars = $this->getInProgressWebinarsCount();

        $query = $this->filterWebinar($query, $request)
            ->whereIn('status', ['active', 'pending'])
            ->with([
                'category',
                'teacher' => function ($qu) {
                    $qu->select('id', 'full_name');
                },
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                }
            ]);

        $webinars = $query->paginate(10);

        if ($request->get('status', null) == 'active_finished') {
            foreach ($webinars as $key => $webinar) {
                if ($webinar->last_date > time()) {
                    unset($webinars[$key]);
                }
            }
        }

        $data = [
            'pageTitle' => trans('admin/pages/webinars.webinars_list_page_title'),
            'webinars' => $webinars,
            'totalWebinars' => $totalWebinars,
            'totalPendingWebinars' => $totalPendingWebinars,
            'totalDurations' => $totalDurations,
            'totalSales' => !empty($totalSales) ? $totalSales->sales_count : 0,
            'categories' => $categories,
            'inProgressWebinars' => $inProgressWebinars ?? 0,
            'classesType' => 'webinar',
        ];

        $teacher_ids = $request->get('teacher_ids', null);
        if (!empty($teacher_ids)) {
            $data['teachers'] = User::select('id', 'full_name')->whereIn('id', $teacher_ids)->get();
        }
        $creator_ids = $request->get('creator_ids', null);
        if (!empty($creator_ids)) {
            $data['creators'] = User::select('id', 'full_name')->whereIn('id', $creator_ids)->get();
        }

        return view('admin.webinar_qlxb.lists', $data);
    }

    public function assignUpdate(Request $request, $id)
    {
        $this->authorize('admin_webinars_ctv');
        $data = $request->all();

        $webinar = Webinar::find($id);
        $review = (!empty($data['draft']) and $data['draft'] == 'reviewed');

        $rules = [
            'content' => 'required',
//            'preview_content' => 'required',
//            'table_contents' => 'required',
        ];


        $this->validate($request, $rules);

        if (!empty($data['teacher_id'])) {
            $teacher = User::find($data['teacher_id']);
            $creator = !empty($data['organ_id']) ? User::find($data['organ_id']) : $webinar->creator;

            if (empty($teacher) or ($creator->isOrganization() and ($teacher->organ_id != $creator->id and $teacher->id != $creator->id))) {
                $toastData = [
                    'title' => trans('public.request_failed'),
                    'msg' => trans('admin/main.is_not_the_teacher_of_this_organization'),
                    'status' => 'error'
                ];
                return back()->with(['toast' => $toastData]);
            }
        }

        // Handle auto fill Table_Content
        preg_match('/<div class="mce-toc">.*?<\/div>/s', $data['content'], $matches);
        if (isset($matches[0])) {
            $data['table_contents'] = $matches[0];
            $data['content'] = preg_replace('/<div class="mce-toc">.*?<\/div>/s', '', $data['content']);
        }
        // Handle auto fill Preview Content
        $previewLength = strlen($data['content']) / 5; // 1/4 of content
        $lastTagPosition = strrpos(substr($data['content'], 0, $previewLength), '>');
        $data['preview_content'] = substr($data['content'], 0, $lastTagPosition + 1);

        $data['status'] = $review ? Webinar::$reviewed : Webinar::$assigned;

        $data['revision_count'] = $webinar->revision_count;
        if($review) {
            $data['revision_count'] = $webinar->revision_count + 1;
        }

        unset(
            $data['_token'],
            $data['current_step'],
            $data['draft'],
            $data['get_next'],
            $data['partners'],
            $data['tags'],
            $data['filters'],
            $data['ajax']
        );

        $webinar->update([
            'updated_at' => time(),
            'revision_count' => $data['revision_count'],
            'status' => $data['status'],
        ]);

        if ($webinar) {
            WebinarTranslation::updateOrCreate([
                'webinar_id' => $webinar->id,
                'locale' => mb_strtolower($data['locale']),
            ], [
                'content' => $data['content'],
                'table_contents' => $data['table_contents'],
                'preview_content' => $data['preview_content'],
            ]);
        }



        removeContentLocale();

        return back();
    }

    public function acceptIndex(Request $request)
    {

        $query = User::join('webinars', 'users.id', '=', 'webinars.assigned_user')
            ->select('users.id', 'users.full_name', 'users.email', DB::raw('COUNT(webinars.id) as webinar_count'), DB::raw('SUM(webinars.implementation_cost) as total_amount'))
            ->where('webinars.status', Webinar::$active);

        $title = $request->get('title', null);
        $from = $request->get('from', null);
        $to = $request->get('to', null);

        if (!empty($title)) {
            $query->where(function($query) use ($title) {
                $query->where('users.full_name', 'like', "%$title%")
                    ->orWhere('users.email', 'like', "%$title%");
            });
        }

        $query = fromAndToDateFilter($from, $to, $query, 'webinars.created_at');


        $implementation_cost = $query->sum('webinars.implementation_cost');
        $total = $query->count();


        $query = $query->groupBy('users.id');


        $assignUser = $query->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/webinars.webinars_list_page_title'),
            'classesType' => 'webinar',
            'implementation_cost' => $implementation_cost,
            'total' => $total,
            'assignUser' => $assignUser
        ];
        return view('admin.webinar_qlxb.list_accept', $data);
    }

    public function exportAcceptExcel(Request $request)
    {

        $query = User::join('webinars', 'users.id', '=', 'webinars.assigned_user')
            ->select('users.id', 'users.full_name', 'users.email', DB::raw('COUNT(webinars.id) as webinar_count'), DB::raw('SUM(webinars.implementation_cost) as total_amount'))
            ->where('webinars.status', Webinar::$active);

        $title = $request->get('title', null);
        $from = $request->get('from', null);
        $to = $request->get('to', null);

        if (!empty($title)) {
            $query->where(function($query) use ($title) {
                $query->where('users.full_name', 'like', "%$title%")
                    ->orWhere('users.email', 'like', "%$title%");
            });
        }

        $query = fromAndToDateFilter($from, $to, $query, 'webinars.created_at');

        $webinars = $query->get();

        $webinarExport = new WebinarsAcceptExport($webinars);

        return Excel::download($webinarExport, 'webinars_accept.xlsx');
    }
}
