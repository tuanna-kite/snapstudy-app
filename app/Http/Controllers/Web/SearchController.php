<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Role;
use App\Models\Webinar;
use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $search = $request->get('search', null);
        if (!empty($search)) {

            $webinars = Webinar::where('status', 'active')
            ->where('private', false)
            ->whereTranslationLike('title', "%$search%")
            ->orWhereTranslationLike('description', "%$search%")
            ->orWhereTranslationLike('seo_description', "%$search%")
            ->orWhereTranslationLike('webinar_id', "%$search%")
            ->with([
                'teacher' => function ($query) {
                    $query->select('id', 'full_name', 'avatar');
                },
                'reviews'
            ])
            ->get();

            $categories = Category::whereTranslationLike('title', "%$search%")->get();
            if (count($categories) > 0) {
                $webinars = Webinar::where('status', 'active')->whereIn('category_id', $categories->pluck('id')->toArray())->get();
            }

            $users = User::where('status', 'active')
                ->where('full_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('mobile', 'like', "%$search%")
                ->with([
                    'webinars' => function ($query) {
                        $query->where('status', 'active');
                        //dd(getBindedSQL($query));
                    }
                ])
                ->get();

            $teachers = $users->where('role_name', Role::$teacher);
            $organizations = $users->where('role_name', Role::$organization);

            $seoSettings = getSeoMetas('search');
            $pageTitle = !empty($seoSettings['title']) ? $seoSettings['title'] : trans('site.search_page_title');
            $pageDescription = !empty($seoSettings['description']) ? $seoSettings['description'] : trans('site.search_page_title');
            $pageRobot = getPageRobot('search');

            $data = [
                'pageTitle' => $pageTitle,
                'pageDescription' => $pageDescription,
                'pageRobot' => $pageRobot,
                'resultCount' => count($webinars) + count($teachers) + count($organizations),
                'webinars' => $webinars,
                'teachers' => $teachers,
                'organizations' => $organizations,
            ];
        }

        return view(getTemplate() . '.pages.search', $data);
    }
}