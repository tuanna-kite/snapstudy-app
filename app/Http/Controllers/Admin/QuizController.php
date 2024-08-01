<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\Accounting;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesResult;
use App\Models\Role;
use App\Models\Translation\QuizTranslation;
use App\Models\Translation\WebinarTranslation;
use App\Models\Webinar;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use App\Models\WebinarType;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin_quizzes_list');

        removeContentLocale();

        $query = Quiz::query();

        $totalQuizzes = deepClone($query)->count();
        $totalActiveQuizzes = deepClone($query)->where('status', 'active')->count();
        $totalStudents = QuizzesResult::groupBy('user_id')->count();
        $totalPassedStudents = QuizzesResult::where('status', 'passed')->groupBy('user_id')->count();

        $query = $this->filters($query, $request);

        $quizzes = $query->with([
            'webinar',
            'teacher',
            'quizQuestions',
            'quizResults',
        ])->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/quiz.admin_quizzes_list'),
            'quizzes' => $quizzes,
            'totalQuizzes' => $totalQuizzes,
            'totalActiveQuizzes' => $totalActiveQuizzes,
            'totalStudents' => $totalStudents,
            'totalPassedStudents' => $totalPassedStudents,
        ];

        $teacher_ids = $request->get('teacher_ids');
        $webinar_ids = $request->get('webinar_ids');

        if (!empty($teacher_ids)) {
            $data['teachers'] = User::select('id', 'full_name')
                ->whereIn('id', $teacher_ids)->get();
        }

        if (!empty($webinar_ids)) {
            $data['webinars'] = Webinar::select('id')
                ->whereIn('id', $webinar_ids)->get();
        }

        return view('admin.quizzes.lists', $data);
    }

    private function filters($query, $request)
    {
        $from = $request->get('from', null);
        $to = $request->get('to', null);
        $title = $request->get('title', null);
        $sort = $request->get('sort', null);
        $teacher_ids = $request->get('teacher_ids', null);
        $webinar_ids = $request->get('webinar_ids', null);
        $status = $request->get('status', null);

        $query = fromAndToDateFilter($from, $to, $query, 'created_at');

        if (!empty($title)) {
            $query->whereTranslationLike('title', '%' . $title . '%');
        }

        if (!empty($sort)) {
            switch ($sort) {
                case 'have_certificate':
                    $query->where('certificate', true);
                    break;
                case 'students_count_asc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count', 'asc');
                    break;

                case 'students_count_desc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count', 'desc');
                    break;
                case 'passed_count_asc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->where('quizzes_results.status', 'passed')
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count', 'asc');
                    break;

                case 'passed_count_desc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->where('quizzes_results.status', 'passed')
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count', 'desc');
                    break;

                case 'grade_avg_asc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', 'quizzes_results.user_grade', DB::raw('avg(quizzes_results.user_grade) as grade_avg'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('grade_avg', 'asc');
                    break;

                case 'grade_avg_desc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', 'quizzes_results.user_grade', DB::raw('avg(quizzes_results.user_grade) as grade_avg'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('grade_avg', 'desc');
                    break;

                case 'created_at_asc':
                    $query->orderBy('created_at', 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if (!empty($teacher_ids)) {
            $query->whereIn('creator_id', $teacher_ids);
        }

        if (!empty($webinar_ids)) {
            $query->whereIn('webinar_id', $webinar_ids);
        }

        if (!empty($status) and $status !== 'all') {
            $query->where('status', strtolower($status));
        }

        return $query;
    }

    public function create()
    {
        $this->authorize('admin_quizzes_create');
        $categories = Category::where('parent_id', null)
            ->get()
            ->sortBy(function($category) {
                return $category->title;
            });
        $data = [
            'pageTitle' => trans('quiz.new_quiz'),
            'categories' => $categories
        ];

        return view('admin.quizzes.create', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('admin_quizzes_create');

        $data = $request->get('ajax')['new'];
        $locale = $data['locale'] ?? getDefaultLocale();

        $rules = [
            'title' => 'required|max:255',
            'seo_description' => 'required|max:500',
            'price' => 'required',
            'category_id' => 'required',
//            'webinar_id' => 'required|exists:webinars,id',
//            'pass_mark' => 'required',
        ];

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json([
                'code' => 422,
                'errors' => $validate->errors()
            ], 422);
        }

        if (empty($data['slug'])) {
            $data['slug'] = Webinar::makeSlug($data['title']);
        }

        $webinar = Webinar::create([
            'type' => Webinar::$quizz,
            'slug' => preg_replace('/[^A-Za-z0-9\-]/', '',
                    str_replace(' ', '-', strtolower($data['slug']))).'-'.Str::random(5),
            'teacher_id' => $data['teacher_id'],
            'creator_id' => $data['creator_id'],
            'category_id' => $data['category_id'],
            'thumbnail' => $data['thumbnail'] ?? null,
            'price' => $data['price'],
            'status' => Webinar::$pending,
            'created_at' => time(),
            'updated_at' => time(),

        ]);

        if ($webinar) {
            WebinarTranslation::updateOrCreate([
                'webinar_id' => $webinar->id,
                'locale' => mb_strtolower($data['locale']),
                'title' => $data['title'],
                'seo_description' => $data['seo_description'],
            ]);
        }


        if (!empty($webinar)) {
            $chapter = null;

            if (!empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id', $data['chapter_id'])
                    ->where('webinar_id', $webinar->id)
                    ->first();
            }

            $quiz = Quiz::create([
                'webinar_id' => $webinar->id,
                'chapter_id' => !empty($chapter) ? $chapter->id : null,
                'creator_id' => $webinar->creator_id,
                'attempt' => $data['attempt'] ?? null,
                'pass_mark' => $data['pass_mark'] ?? 1,
                'time' => $data['time'] ?? null,
                'status' => Quiz::INACTIVE,
                'certificate' => (!empty($data['certificate']) and $data['certificate'] == 'on'),
                'display_questions_randomly' => (!empty($data['display_questions_randomly']) and $data['display_questions_randomly'] == 'on'),
                'expiry_days' => (!empty($data['expiry_days']) and $data['expiry_days'] > 0) ? $data['expiry_days'] : null,
                'created_at' => time(),
            ]);

            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id,
                'locale' => mb_strtolower($locale),
            ], [
                'title' => $data['title'],
            ]);

            if (!empty($quiz->chapter_id)) {
                WebinarChapterItem::makeItem($webinar->creator_id, $quiz->chapter_id, $quiz->id, WebinarChapterItem::$chapterQuiz);
            }

            // Send Notification To All Students
            $webinar->sendNotificationToAllStudentsForNewQuizPublished($quiz);

            if ($request->ajax()) {

                $redirectUrl = '';

                if (empty($data['is_webinar_page'])) {
                    $redirectUrl = getAdminPanelUrl('/quizzes/' . $quiz->id . '/edit');
                }

                return response()->json([
                    'code' => 200,
                    'redirect_url' => $redirectUrl
                ]);
            } else {
                return redirect()->route('adminEditQuiz', ['id' => $quiz->id]);
            }
        } else {
            return back()->withErrors([
                'webinar_id' => trans('validation.exists', ['attribute' => trans('admin/main.course')])
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_quizzes_edit');

        $quiz = Quiz::query()->where('id', $id)
            ->with([
                'quizQuestions' => function ($query) {
                    $query->orderBy('order', 'asc');
                    $query->with('quizzesQuestionsAnswers');
                },
            ])
            ->with('webinar')
            ->first();

        if (empty($quiz)) {
            abort(404);
        }

        $creator = $quiz->creator;

        $webinars = Webinar::where('status', 'active')
            ->where(function ($query) use ($creator) {
                $query->where('teacher_id', $creator->id)
                    ->orWhere('creator_id', $creator->id);
            })->get();

        $locale = $request->get('locale', app()->getLocale());
        if (empty($locale)) {
            $locale = app()->getLocale();
        }
        storeContentLocale($locale, $quiz->getTable(), $quiz->id);

        $quiz->title = $quiz->getTitleAttribute();
        $quiz->locale = mb_strtoupper($locale);

        $chapters = collect();

        if (!empty($quiz->webinar)) {
            $chapters = $quiz->webinar->chapters;
        }

        $categories = Category::where('parent_id', null)
            ->get()
            ->sortBy(function($category) {
                return $category->title;
            });

        $data = [
            'pageTitle' => trans('public.edit') . ' ' . $quiz->title,
            'webinars' => $webinars,
            'quiz' => $quiz,
            'quizQuestions' => $quiz->quizQuestions,
            'creator' => $creator,
            'chapters' => $chapters,
            'locale' => mb_strtolower($locale),
            'defaultLocale' => getDefaultLocale(),
            'categories' => $categories,
        ];

        return view('admin.quizzes.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::query()->findOrFail($id);
        $user = $quiz->creator;

        $data = $request->get('ajax')[$id];
        $locale = $data['locale'] ?? getDefaultLocale();

        $rules = [
            'title' => 'required|max:255',
            'seo_description' => 'required|max:500',
            'price' => 'required',
            'category_id' => 'required',
        ];

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json([
                'code' => 422,
                'errors' => $validate->errors()
            ], 422);
        }

        $chapter = null;
        if (empty($data['slug'])) {
            $data['slug'] = Webinar::makeSlug($data['title']);
        }

        if ($quiz) {
            $webinar = Webinar::where('id', $quiz->webinar_id)->first();

            if (!empty($webinar) and !empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id', $data['chapter_id'])
                    ->where('webinar_id', $webinar->id)
                    ->first();
            }
        }

        $webinar->update([
            'slug' => preg_replace('/[^A-Za-z0-9\-]/', '',
                    str_replace(' ', '-', strtolower($data['slug']))).'-'.Str::random(5),
            'price' => $data['price'],
            'category_id' => $data['category_id'],
            'updated_at' => time(),
        ]);

        if ($webinar) {
            WebinarTranslation::updateOrCreate([
                'webinar_id' => $webinar->id,
                'locale' => mb_strtolower($data['locale']),
            ], [
                'title' => $data['title'],
                'seo_description' => $data['seo_description'],
            ]);
        }

        $quiz->update([
            'chapter_id' => !empty($chapter) ? $chapter->id : null,
            'attempt' => $data['attempt'] ?? null,
            'pass_mark' => $data['pass_mark'] ?? 1,
            'time' => $data['time'] ?? null,
            'updated_at' => time(),
        ]);

        if (!empty($quiz)) {
            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id,
                'locale' => mb_strtolower($locale),
            ], [
                'title' => $data['title'],
            ]);

            $checkChapterItem = WebinarChapterItem::where('user_id', $user->id)
                ->where('item_id', $quiz->id)
                ->where('type', WebinarChapterItem::$chapterQuiz)
                ->first();

            if (!empty($quiz->chapter_id)) {
                if (empty($checkChapterItem)) {
                    WebinarChapterItem::makeItem($user->id, $quiz->chapter_id, $quiz->id, WebinarChapterItem::$chapterQuiz);
                } elseif ($checkChapterItem->chapter_id != $quiz->chapter_id) {
                    $checkChapterItem->delete(); // remove quiz from old chapter and assign it to new chapter

                    WebinarChapterItem::makeItem($user->id, $quiz->chapter_id, $quiz->id, WebinarChapterItem::$chapterQuiz);
                }
            } else if (!empty($checkChapterItem)) {
                $checkChapterItem->delete();
            }
        }

        removeContentLocale();

        if ($request->ajax()) {
            return response()->json([
                'code' => 200
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function delete(Request $request, $id)
    {
        $this->authorize('admin_quizzes_delete');

        $quiz = Quiz::findOrFail($id);

        $quiz->delete();

        $checkChapterItem = WebinarChapterItem::where('item_id', $id)
            ->where('type', WebinarChapterItem::$chapterQuiz)
            ->first();

        if (!empty($checkChapterItem)) {
            $checkChapterItem->delete();
        }

        if ($request->ajax()) {
            return response()->json([
                'code' => 200
            ], 200);
        }

        return redirect()->back();
    }

    public function results($id)
    {
        $this->authorize('admin_quizzes_results');

        $quizzesResults = QuizzesResult::where('quiz_id', $id)
            ->with([
                'quiz' => function ($query) {
                    $query->with(['teacher']);
                },
                'user'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/quizResults.quiz_result_list_page_title'),
            'quizzesResults' => $quizzesResults,
            'quiz_id' => $id
        ];

        return view('admin.quizzes.results', $data);
    }

    public function resultsExportExcel($id)
    {
        $this->authorize('admin_quiz_result_export_excel');

        $quizzesResults = QuizzesResult::where('quiz_id', $id)
            ->with([
                'quiz' => function ($query) {
                    $query->with(['teacher']);
                },
                'user'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $export = new QuizResultsExport($quizzesResults);

        return Excel::download($export, 'quiz_result.xlsx');
    }

    public function resultDelete($result_id)
    {
        $this->authorize('admin_quizzes_results_delete');

        $quizzesResults = QuizzesResult::where('id', $result_id)->first();

        if (!empty($quizzesResults)) {
            $quizzesResults->delete();
        }

        return redirect()->back();
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('admin_quizzes_lists_excel');

        $query = Quiz::query();

        $query = $this->filters($query, $request);

        $quizzes = $query->with([
            'webinar',
            'teacher',
            'quizQuestions',
            'quizResults',
        ])->get();

        return Excel::download(new QuizzesAdminExport($quizzes), trans('quiz.quizzes') . '.xlsx');
    }

    public function orderItems(Request $request, $quizId)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'items' => 'required',
            'table' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $quiz = Quiz::query()->where('id', $quizId)->first();

        if (!empty($quiz)) {
            $tableName = $data['table'];
            $itemIds = explode(',', $data['items']);

            if (!is_array($itemIds) and !empty($itemIds)) {
                $itemIds = [$itemIds];
            }

            if (!empty($itemIds) and is_array($itemIds) and count($itemIds)) {
                switch ($tableName) {
                    case 'quizzes_questions':
                        foreach ($itemIds as $order => $id) {
                            QuizzesQuestion::where('id', $id)
                                ->where('quiz_id', $quiz->id)
                                ->update(['order' => ($order + 1)]);
                        }
                        break;
                }
            }
        }

        return response()->json([
            'title' => trans('public.request_success'),
            'msg' => trans('update.items_sorted_successful')
        ]);
    }

    public function approve(Request $request, $id)
    {
        $this->authorize('admin_quizzes_edit');

        $quizz = Quiz::query()
            ->findOrFail($id);

        $webinar = Webinar::query()->findOrFail($quizz->webinar_id);

        $quizz->update([
            'status' => Quiz::ACTIVE
        ]);

        $webinar->update([
            'status' => Webinar::$active
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('update.course_status_changes_to_approved'),
            'status' => 'success'
        ];

        return redirect(getAdminPanelUrl().'/quizzes')->with(['toast' => $toastData]);
    }

    public function reject(Request $request, $id)
    {
        $this->authorize('admin_quizzes_edit');

        $quizz = Quiz::query()
            ->findOrFail($id);

        $webinar = Webinar::query()->findOrFail($quizz->webinar_id);

        $quizz->update([
            'status' => Quiz::INACTIVE
        ]);

        $webinar->update([
            'status' => Webinar::$inactive
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('update.course_status_changes_to_rejected'),
            'status' => 'success'
        ];

        return redirect(getAdminPanelUrl().'/quizzes')->with(['toast' => $toastData]);
    }

    public function unpublish(Request $request, $id)
    {
        $this->authorize('admin_quizzes_edit');

        $quizz = Quiz::query()
            ->findOrFail($id);

        $webinar = Webinar::query()->findOrFail($quizz->webinar_id);

        $quizz->update([
            'status' => Quiz::INACTIVE
        ]);

        $webinar->update([
            'status' => Webinar::$pending
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('update.course_status_changes_to_unpublished'),
            'status' => 'success'
        ];

        return redirect(getAdminPanelUrl().'/quizzes')->with(['toast' => $toastData]);
    }

    public function contentCreate()
    {
        $this->authorize('admin_quizzes_create');
        $categories = Category::where('parent_id', null)
            ->get()
            ->sortBy(function($category) {
                return $category->title;
            });

        $staffsRoles = Role::where('is_admin', true)->get();
        $staffsRoleIds = $staffsRoles->pluck('id')->toArray();

        $ctv = User::where('status', 'active')
            ->whereIn('role_id', $staffsRoleIds)
            ->get();

        $genres = WebinarType::where('status', 'active')
            ->get();
        $data = [
            'pageTitle' => trans('quiz.new_quiz'),
            'categories' => $categories,
            'ctv' => $ctv,
            'genres' => $genres
        ];

        return view('admin.quizzes_qlnd.create', $data);
    }

    public function contentStore(Request $request)
    {
        $this->authorize('admin_webinars_qlnd');

        $data = $request->all();
        $locale = $data['locale'] ?? getDefaultLocale();

        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'implementation_cost' => 'required',
            'assigned_user' => 'required',
            'genre' => 'required'
        ];

        $this->validate($request, $rules);

        if (empty($data['slug'])) {
            $data['slug'] = Webinar::makeSlug($data['title']);
        }
        if (!empty($data['genre'])) {
            $data['price'] = WebinarType::find($data['genre'])->price;
        }

        $webinar = Webinar::create([
            'type' => Webinar::$quizz,
            'slug' => preg_replace('/[^A-Za-z0-9\-]/', '',
                    str_replace(' ', '-', strtolower($data['slug']))).'-'.Str::random(5),
            'teacher_id' => $data['teacher_id'],
            'creator_id' => $data['creator_id'],
            'category_id' => $data['category_id'],
            'thumbnail' => $data['thumbnail'] ?? null,
            'price' => $data['price'],
            'status' => Webinar::$assigned,
            'assigned_user' => $data['assigned_user'] ?? null,
            'genre' => $data['genre'] ?? null,
            'implementation_cost' => $data['implementation_cost'],
            'created_at' => time(),
            'updated_at' => time(),

        ]);

        if ($webinar) {
            WebinarTranslation::updateOrCreate([
                'webinar_id' => $webinar->id,
                'locale' => mb_strtolower($data['locale']),
                'title' => $data['title'],
                'seo_description' => $data['seo_description'],
            ]);
        }


        if (!empty($webinar)) {
            $chapter = null;

            if (!empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id', $data['chapter_id'])
                    ->where('webinar_id', $webinar->id)
                    ->first();
            }

            $quiz = Quiz::create([
                'webinar_id' => $webinar->id,
                'chapter_id' => !empty($chapter) ? $chapter->id : null,
                'creator_id' => $webinar->creator_id,
                'attempt' => $data['attempt'] ?? null,
                'pass_mark' => $data['pass_mark'] ?? 1,
                'time' => $data['time'] ?? null,
                'status' => Quiz::INACTIVE,
                'certificate' => (!empty($data['certificate']) and $data['certificate'] == 'on'),
                'display_questions_randomly' => (!empty($data['display_questions_randomly']) and $data['display_questions_randomly'] == 'on'),
                'expiry_days' => (!empty($data['expiry_days']) and $data['expiry_days'] > 0) ? $data['expiry_days'] : null,
                'created_at' => time(),
            ]);

            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id,
                'locale' => mb_strtolower($locale),
            ], [
                'title' => $data['title'],
            ]);

            if (!empty($quiz->chapter_id)) {
                WebinarChapterItem::makeItem($webinar->creator_id, $quiz->chapter_id, $quiz->id, WebinarChapterItem::$chapterQuiz);
            }

            // Send Notification To All Students
//            $webinar->sendNotificationToAllStudentsForNewQuizPublished($quiz);

            return redirect(route('webinar.content.index'));
        } else {
            return back()->withErrors([
                'webinar_id' => trans('validation.exists', ['attribute' => trans('admin/main.course')])
            ]);
        }
    }

    public function contentEdit(Request $request, $id)
    {
        $this->authorize('admin_webinars_qlnd');

        $quiz = Quiz::query()->where('id', $id)
            ->with([
                'quizQuestions' => function ($query) {
                    $query->orderBy('order', 'asc');
                    $query->with('quizzesQuestionsAnswers');
                },
            ])
            ->with('webinar')
            ->first();
        $webinar = $quiz->webinar;
        if (empty($quiz)) {
            abort(404);
        }

        $creator = $quiz->creator;

        $webinars = Webinar::where('status', 'active')
            ->where(function ($query) use ($creator) {
                $query->where('teacher_id', $creator->id)
                    ->orWhere('creator_id', $creator->id);
            })->get();

        $locale = $request->get('locale', app()->getLocale());
        if (empty($locale)) {
            $locale = app()->getLocale();
        }
        storeContentLocale($locale, $quiz->getTable(), $quiz->id);

        $quiz->title = $quiz->getTitleAttribute();
        $quiz->locale = mb_strtoupper($locale);

        $chapters = collect();

        if (!empty($quiz->webinar)) {
            $chapters = $quiz->webinar->chapters;
        }

        $categories = Category::where('parent_id', null)
            ->get()
            ->sortBy(function($category) {
                return $category->title;
            });

        $ctv = User::where('status', 'active')
            ->get();

        $genres = WebinarType::where('status', 'active')
            ->get();
        $data = [
            'pageTitle' => trans('public.edit') . ' ' . $quiz->title,
            'webinars' => $webinars,
            'webinar' => $webinar,
            'quiz' => $quiz,
            'quizQuestions' => $quiz->quizQuestions,
            'creator' => $creator,
            'chapters' => $chapters,
            'locale' => mb_strtolower($locale),
            'defaultLocale' => getDefaultLocale(),
            'categories' => $categories,
            'ctv' => $ctv,
            'genres' => $genres
        ];

        return view('admin.quizzes_qlnd.edit', $data);
    }

    public function contentUpdate(Request $request, $id)
    {
        $quiz = Quiz::query()->findOrFail($id);
        $user = $quiz->creator;

        $data = $request->all();
        $locale = $data['locale'] ?? getDefaultLocale();

        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'implementation_cost' => 'required',
            'assigned_user' => 'required',
            'genre' => 'required'
        ];
        $this->validate($request, $rules);

        $chapter = null;
        if (empty($data['slug'])) {
            $data['slug'] = Webinar::makeSlug($data['title']);
        }

        if ($quiz) {
            $webinar = Webinar::where('id', $quiz->webinar_id)->first();

            if (!empty($webinar) and !empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id', $data['chapter_id'])
                    ->where('webinar_id', $webinar->id)
                    ->first();
            }
        }

        if (!empty($data['genre'])) {
            $data['price'] = WebinarType::find($data['genre'])->price;
        }


        $reject = (!empty($data['draft']) and $data['draft'] == 'inactive');
        $assigned = (!empty($data['draft']) and $data['draft'] == 'assigned');
        $pending = (!empty($data['draft']) and $data['draft'] == 'pending');

        $data['status'] = $assigned ? Webinar::$assigned : ($reject ? Webinar::$inactive : ($pending ? Webinar::$pending : Webinar::$assigned));


        $webinar->update([
            'slug' => preg_replace('/[^A-Za-z0-9\-]/', '',
                    str_replace(' ', '-', strtolower($data['slug']))).'-'.Str::random(5),
            'price' => $data['price'],
            'category_id' => $data['category_id'],
            'updated_at' => time(),
            'assigned_user' => $data['assigned_user'] ?? null,
            'genre' => $data['genre'] ?? null,
            'implementation_cost' => $data['implementation_cost'],
            'status' => $data['status'],
            'message_for_reviewer' => $data['message_for_reviewer'] ?? null,
        ]);

        if ($webinar) {
            WebinarTranslation::updateOrCreate([
                'webinar_id' => $webinar->id,
                'locale' => mb_strtolower($data['locale']),
            ], [
                'title' => $data['title'],
                'seo_description' => $data['seo_description'],
            ]);
        }

        $quiz->update([
            'chapter_id' => !empty($chapter) ? $chapter->id : null,
            'attempt' => $data['attempt'] ?? null,
            'pass_mark' => $data['pass_mark'] ?? 1,
            'time' => $data['time'] ?? null,
            'status' => $data['status'],
            'updated_at' => time(),
        ]);

        if (!empty($quiz)) {
            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id,
                'locale' => mb_strtolower($locale),
            ], [
                'title' => $data['title'],
            ]);

            $checkChapterItem = WebinarChapterItem::where('user_id', $user->id)
                ->where('item_id', $quiz->id)
                ->where('type', WebinarChapterItem::$chapterQuiz)
                ->first();

            if (!empty($quiz->chapter_id)) {
                if (empty($checkChapterItem)) {
                    WebinarChapterItem::makeItem($user->id, $quiz->chapter_id, $quiz->id, WebinarChapterItem::$chapterQuiz);
                } elseif ($checkChapterItem->chapter_id != $quiz->chapter_id) {
                    $checkChapterItem->delete(); // remove quiz from old chapter and assign it to new chapter

                    WebinarChapterItem::makeItem($user->id, $quiz->chapter_id, $quiz->id, WebinarChapterItem::$chapterQuiz);
                }
            } else if (!empty($checkChapterItem)) {
                $checkChapterItem->delete();
            }
        }

        removeContentLocale();

        return redirect(route('webinar.content.index'));
    }

    public function assignEdit(Request $request, $id)
    {
        $this->authorize('admin_webinars_ctv');

        $quiz = Quiz::query()->where('id', $id)
            ->with([
                'quizQuestions' => function ($query) {
                    $query->orderBy('order', 'asc');
                    $query->with('quizzesQuestionsAnswers');
                },
            ])
            ->with('webinar')
            ->first();
        $webinar = $quiz->webinar;
        if (empty($quiz)) {
            abort(404);
        }

        $creator = $quiz->creator;

        $webinars = Webinar::where('status', 'active')
            ->where(function ($query) use ($creator) {
                $query->where('teacher_id', $creator->id)
                    ->orWhere('creator_id', $creator->id);
            })->get();

        $locale = $request->get('locale', app()->getLocale());
        if (empty($locale)) {
            $locale = app()->getLocale();
        }
        storeContentLocale($locale, $quiz->getTable(), $quiz->id);

        $quiz->title = $quiz->getTitleAttribute();
        $quiz->locale = mb_strtoupper($locale);

        $chapters = collect();

        if (!empty($quiz->webinar)) {
            $chapters = $quiz->webinar->chapters;
        }

        $categories = Category::where('parent_id', null)
            ->get()
            ->sortBy(function($category) {
                return $category->title;
            });

        $staffsRoles = Role::where('is_admin', true)->get();
        $staffsRoleIds = $staffsRoles->pluck('id')->toArray();

        $ctv = User::where('status', 'active')
            ->whereIn('role_id', $staffsRoleIds)
            ->get();

        $genres = WebinarType::where('status', 'active')
            ->get();
        $data = [
            'pageTitle' => trans('public.edit') . ' ' . $quiz->title,
            'webinars' => $webinars,
            'webinar' => $webinar,
            'quiz' => $quiz,
            'quizQuestions' => $quiz->quizQuestions,
            'creator' => $creator,
            'chapters' => $chapters,
            'locale' => mb_strtolower($locale),
            'defaultLocale' => getDefaultLocale(),
            'categories' => $categories,
            'ctv' => $ctv,
            'genres' => $genres
        ];

        return view('admin.quizzes_ctv.edit', $data);
    }

    public function assignUpdate(Request $request, $id)
    {
        $quiz = Quiz::query()->findOrFail($id);
        $user = $quiz->creator;

        $data = $request->all();
        $locale = $data['locale'] ?? getDefaultLocale();

        if ($quiz) {
            $webinar = Webinar::where('id', $quiz->webinar_id)->first();

            if (!empty($webinar) and !empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id', $data['chapter_id'])
                    ->where('webinar_id', $webinar->id)
                    ->first();
            }
        }

        $review = (!empty($data['draft']) and $data['draft'] == 'reviewed');
        $data['status'] = $review ? Webinar::$reviewed : Webinar::$assigned;

        $data['revision_count'] = $webinar->revision_count;
        if($review) {
            $data['revision_count'] = $webinar->revision_count + 1;
        }


        $webinar->update([
            'status' => $data['status'],
            'revision_count' => $data['revision_count'],
            'updated_at' => time(),
        ]);

        $quiz->update([
            'status' => $data['status'],
            'updated_at' => time(),
        ]);


        return redirect(route('webinar.assign.index'));
    }
}
