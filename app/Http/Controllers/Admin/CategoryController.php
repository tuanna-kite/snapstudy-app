<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Translation\CategoryTranslation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        removeContentLocale();

        $this->authorize('admin_categories_list');

        $categories = Category::where('parent_id', null)
            ->with([
                'subCategories'
            ])
            ->orderBy('id', 'desc')
            ->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/categories.categories_list_page_title'),
            'categories' => $categories
        ];

        return view('admin.categories.lists', $data);
    }

    public function create()
    {
        $this->authorize('admin_categories_create');


        $data = [
            'pageTitle' => trans('admin/main.category_new_page_title'),
        ];

        return view('admin.categories.create', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('admin_categories_create');

        $this->validate($request, [
            'title' => 'required|min:3|max:128',
            'description' => 'required|min:3|max:255',
            'slug' => 'nullable|max:255|unique:categories,slug',
            'prefix' => 'required|min:2|max:255',
            'icon' => 'required'
        ]);

        $data = $request->all();

        if (!empty($data['order'])) {
            $order = $data['order'];
        } else {
            $order = Category::whereNull('parent_id')->count() + 1;
        }

        $category = Category::create([
            'slug' => $data['prefix'] . '_' . Category::makeSlug($data['title']),
            'icon' => $data['icon'],
            'order' => $order,
            'prefix' => $data['prefix'],
            'level' => 1,
        ]);

        CategoryTranslation::updateOrCreate([
            'category_id' => $category->id,
            'locale' => mb_strtolower($data['locale']),
        ], [
            'title' => $data['title'],
            'description' => $data['description']
        ]);

        $hasSubCategories = (!empty($request->get('has_sub')) and $request->get('has_sub') == 'on');
        $this->setSubCategory($category, $request->get('sub_categories'), $hasSubCategories, $data['locale']);

        cache()->forget(Category::$cacheKey);

        removeContentLocale();

        return redirect(getAdminPanelUrl() . '/categories');
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_categories_edit');

        $category = Category::findOrFail($id);
        $subCategories = Category::where('parent_id', $category->id)
            ->where('level', 2)
            ->orderBy('order', 'asc')
            ->get();

        $locale = $request->get('locale', app()->getLocale());
        storeContentLocale($locale, $category->getTable(), $category->id);

        $data = [
            'pageTitle' => trans('admin/pages/categories.edit_page_title'),
            'category' => $category,
            'subCategories' => $subCategories
        ];

        return view('admin.categories.create', $data);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin_categories_edit');

        $category = Category::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'slug' => 'nullable|max:255|unique:categories,slug,' . $category->id,
            'prefix' => 'required|min:2|max:255',
            'icon' => 'required',
        ]);

        $data = $request->all();

        $category->update([
            'icon' => $data['icon'],
            'slug' => $data['prefix'] . '_' . Category::makeSlug($data['title']),
            'order' => $data['order'] ?? $category->order,
            'prefix' => $data['prefix'],
            'level' => 1,
        ]);

        CategoryTranslation::updateOrCreate([
            'category_id' => $category->id,
            'locale' => mb_strtolower($data['locale']),
        ], [
            'title' => $data['title'],
            'description' => $data['description']
        ]);

        $hasSubCategories = (!empty($request->get('has_sub')) and $request->get('has_sub') == 'on');
        $this->setSubCategory($category, $request->get('sub_categories'), $hasSubCategories, $data['locale'], $request);


        cache()->forget(Category::$cacheKey);

        removeContentLocale();

        return redirect(getAdminPanelUrl() . '/categories');
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('admin_categories_delete');

        $category = Category::where('id', $id)->first();
        $parent = !empty($category->parent_id) ? $category->parent_id : null;

        if (!empty($category)) {
            Category::where('parent_id', $category->id)
                ->delete();

            $category->delete();
        }

        cache()->forget(Category::$cacheKey);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => !empty($parent) ? trans('update.sub_category_successfully_deleted') : trans('update.category_successfully_deleted'),
            'status' => 'success'
        ];

        return !empty($parent) ? back()->with(['toast' => $toastData]) : redirect(getAdminPanelUrl() . '/categories')->with(['toast' => $toastData]);
    }

    public function search(Request $request)
    {
        $term = $request->get('term');

        $option = $request->get('option', null);

        $query = Category::select('id')
            ->whereTranslationLike('title', "%$term%");

        /*if (!empty($option)) {

        }*/

        $categories = $query->get();

        return response()->json($categories, 200);
    }

    public function setSubCategory(Category $category, $subCategories, $hasSubCategories, $locale, $request = null)
    {
        $order = 1;
        $oldIds = [];

        if ($hasSubCategories and !empty($subCategories) and count($subCategories)) {
            foreach ($subCategories as $key => $subCategory) {
                $check = Category::where('id', $key)->first();

                if (is_numeric($key)) {
                    $oldIds[] = $key;
                }

                if (!empty($subCategory['title'])) {
                    $checkSlug = 0;
                    if (!empty($subCategory['slug'])) {
                        $checkSlug = Category::query()->where('slug', $subCategory['slug'])->count();
                    }

                    $slug = (!empty($subCategory['slug']) and ($checkSlug == 0 or ($checkSlug == 1 and $check->slug == $subCategory['slug']))) ? $subCategory['slug'] : Category::makeSlug($subCategory['title']);

                    if (!empty($check)) {
                        $check->update([
                            'order' => $order,
                            'icon' => $subCategory['icon'] ?? null,
                            'slug' => $slug,
                            'level' => 2,
                            'campus_code' => $subCategory['campus_code'] ?? null,
                        ]);

                        CategoryTranslation::updateOrCreate([
                            'category_id' => $check->id,
                            'locale' => mb_strtolower($locale),
                        ], [
                            'title' => $subCategory['title'],
                            'description' => $subCategory['description']
                        ]);
                        $this->setSubject($category, $check->id, $request->get('outline_' . $check->id), $locale);

                    } else {

                        $new = Category::create([
                            'parent_id' => $category->id,
                            'slug' => $slug,
                            'icon' => $subCategory['icon'] ?? null,
                            'order' => $order,
                            'level' => 2,
                        ]);

                        CategoryTranslation::updateOrCreate([
                            'category_id' => $new->id,
                            'locale' => mb_strtolower($locale),
                        ], [
                            'title' => $subCategory['title'],
                            'description' => $subCategory['description']
                        ]);
                        $oldIds[] = $new->id;
                    }

                    $order += 1;
                }
            }
        }

        Category::where('parent_id', $category->id)
            ->whereNotIn('id', $oldIds)
            ->delete();

        return true;
    }

    public function setSubject(Category $category, $subCategoryID, $subjects, $locale, $request = null)
    {
        $order = 1;
        $oldIds = [];

        if (!empty($subjects)) {
            foreach ($subjects as $key => $subject) {
                $check = Category::where('id', $key)
                    ->where('level', 3)
                    ->first();

                if (is_numeric($key)) {
                    $oldIds[] = $key;
                }

                if (!empty($subject['title'])) {
                    if (!empty($check)) {
                        CategoryTranslation::updateOrCreate([
                            'category_id' => $check->id,
                            'locale' => mb_strtolower($locale),
                        ], [
                            'title' => $subject['title'],
                            'description' => $subject['description']
                        ]);
                    } else {
                        $data = [
                            'parent_id' => $subCategoryID,
                            'icon' => $subject['icon'] ?? null,
                            'slug' => Category::makeSlug($subject['title']),
                            'order' => $order,
                            'level' => 3,
                            'subject_code' => $subject['subject_code'] ?? null,
                        ];
                        $new = Category::create($data);

                        CategoryTranslation::updateOrCreate([
                            'category_id' => $new->id,
                            'locale' => mb_strtolower($locale),
                        ], [
                            'title' => $subject['title'],
                            'description' => $subject['description']
                        ]);

                        $oldIds[] = $new->id;
                    }

                    $order += 1;
                }
            }
        }

        Category::where('parent_id', $subCategoryID)
            ->whereNotIn('id', $oldIds)
            ->delete();

        return true;
    }

    public function getMajorBySchool($school_id)
    {
        $majors = Category::where('parent_id', $school_id)
            ->where('level', 2)
            ->orderBy('order', 'asc')
            ->get();

        return response()->json([
            'code' => 200,
            'majors' => $majors
        ]);
    }

    public function getSubjectByMajor($major_id)
    {
        $subjects = Category::where('parent_id', $major_id)
            ->where('level', 3)
            ->orderBy('order', 'asc')
            ->get();

        return response()->json([
            'code' => 200,
            'subjects' => $subjects
        ]);
    }
}
