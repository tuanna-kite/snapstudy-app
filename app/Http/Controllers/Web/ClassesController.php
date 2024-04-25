<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\SpecialOffer;
use App\Models\Ticket;
use App\Models\Webinar;
use App\Models\WebinarFilterOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassesController extends Controller
{
    public $tableName = 'webinars';
    public $columnId = 'webinar_id';

    public function index(Request $request)
    {
        $slugSchool = $request->get('school', []);
        $search = $request->get('search', '');
        $school = Category::whereIN('slug', $slugSchool)->pluck('id')->toArray();
        $webinarsQuery = Webinar::where('webinars.status', 'active')
            ->where('private', false);

        $schools = Category::whereNull('parent_id')
            ->orderBy('order', 'asc')
            ->get();

        if ($slugSchool) {
            $subjectQuery = Category::whereIn('parent_id', $school);
        } else {
            $subjectQuery = Category::whereNotNull('parent_id');
        }
        if ($search) {
            $subjectQuery = $subjectQuery->whereTranslationLike('title', "%$search%");
        }
        $subjectAll = $subjectQuery->paginate(12);

        $seoSettings = getSeoMetas('classes');
        $pageTitle = $seoSettings['title'] ?? '';
        $pageDescription = $seoSettings['description'] ?? '';
        $pageRobot = getPageRobot('classes');
        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'pageRobot' => $pageRobot,
            'schools' => $schools,
            'school' => $school,
            'subjectAll' => $subjectAll

        ];
        return view('web_v2.pages.course-list', $data);
    }

    public function handleFilters($request, $query)
    {

        $upcoming = $request->get('upcoming', null);
        $isFree = $request->get('free', null);
        $withDiscount = $request->get('discount', null);
        $isDownloadable = $request->get('downloadable', null);
        $sort = $request->get('sort', null);
        $filterOptions = $request->get('filter_option', []);
        $typeOptions = $request->get('type', []);
        $moreOptions = $request->get('moreOptions', []);
        $schoolOptions = $request->get('schoolOptions', []);
        $search = $request->get('search');
        $majorOptions = $request->get('majorOptions', []);
        $subjectOptions = $request->get('subjectOptions', []);


        $query->whereHas('teacher', function ($query) {
            $query->where('status', 'active')
                ->where(function ($query) {
                    $query->where('ban', false)
                        ->orWhere(function ($query) {
                            $query->whereNotNull('ban_end_at')
                                ->where('ban_end_at', '<', time());
                        });
                });
        });

        if ($this->tableName == 'webinars') {
            // school
            if (!empty($schoolOptions) and is_array($schoolOptions)) {
                $query->whereHas('category', function ($query) use ($schoolOptions) {
                    $query->whereIn('slug', $schoolOptions);
                });
            }
            // subject
            if (!empty($subjectOptions) and is_array($subjectOptions)) {
                $query->whereHas('category', function ($query) use ($subjectOptions) {
                    $query->whereIn('slug', $subjectOptions);
                });
            }
            // search string
            if (!empty($search)) {
                $query->where('private', false)
                    ->where(function ($query) use ($search) {
                        $query->whereTranslationLike('title', "%$search%")
                            ->orWhereTranslationLike('description', "%$search%")
                            ->orWhereTranslationLike('seo_description', "%$search%")
                            ->orWhereTranslationLike('webinar_id', "%$search%");
                    });
            }

            // if (!empty($upcoming) and $upcoming == 'on') {
            //     $query->whereNotNull('start_date')
            //         ->where('start_date', '>=', time());
            // }

            // if (!empty($isDownloadable) and $isDownloadable == 'on') {
            //     $query->where('downloadable', 1);
            // }

            // if (!empty($typeOptions) and is_array($typeOptions)) {
            //     $query->whereIn("{$this->tableName}.type", $typeOptions);
            // }


            // if (!empty($moreOptions) and is_array($moreOptions)) {
            //     if (in_array('subscribe', $moreOptions)) {
            //         $query->where('subscribe', 1);
            //     }

            //     if (in_array('certificate_included', $moreOptions)) {
            //         $query->whereHas('quizzes', function ($query) {
            //             $query->where('certificate', 1)
            //                 ->where('status', 'active');
            //         });
            //     }

            //     if (in_array('with_quiz', $moreOptions)) {
            //         $query->whereHas('quizzes', function ($query) {
            //             $query->where('status', 'active');
            //         });
            //     }

            //     if (in_array('featured', $moreOptions)) {
            //         $query->whereHas('feature', function ($query) {
            //                 $query->whereIn('status', ['publish']);
            //         });
            //     }
            // }
        }


        if (!empty($isFree) and $isFree == 'on') {
            $query->where(function ($qu) {
                $qu->whereNull('price')
                    ->orWhere('price', '0');
            });
        }

        if (!empty($withDiscount) and $withDiscount == 'on') {
            $now = time();
            $webinarIdsHasDiscount = [];

            $tickets = Ticket::where('start_date', '<', $now)
                ->where('end_date', '>', $now)
                ->get();

            foreach ($tickets as $ticket) {
                if ($ticket->isValid()) {
                    $webinarIdsHasDiscount[] = $ticket->{$this->columnId};
                }
            }

            $specialOffersWebinarIds = SpecialOffer::where('status', 'active')
                ->where('from_date', '<', $now)
                ->where('to_date', '>', $now)
                ->pluck('webinar_id')
                ->toArray();

            $webinarIdsHasDiscount = array_merge($specialOffersWebinarIds, $webinarIdsHasDiscount);

            $webinarIdsHasDiscount = array_unique($webinarIdsHasDiscount);

            $query->whereIn("{$this->tableName}.id", $webinarIdsHasDiscount);
        }

        if (!empty($sort)) {
            if ($sort == 'expensive') {
                $query->whereNotNull('price');
                $query->where('price', '>', 0);
                $query->orderBy('price', 'desc');
            }

            if ($sort == 'inexpensive') {
                $query->whereNotNull('price');
                $query->where('price', '>', 0);
                $query->orderBy('price', 'asc');
            }

            if ($sort == 'bestsellers') {
                $query->leftJoin('sales', function ($join) {
                    $join->on("{$this->tableName}.id", '=', "sales.{$this->columnId}")
                        ->whereNull('refund_at');
                })
                    ->whereNotNull("sales.{$this->columnId}")
                    ->select("{$this->tableName}.*", "sales.{$this->columnId}",
                        DB::raw("count(sales.{$this->columnId}) as salesCounts"))
                    ->groupBy("sales.{$this->columnId}")
                    ->orderBy('salesCounts', 'desc');
            }

            if ($sort == 'best_rates') {
                $query->leftJoin('webinar_reviews', function ($join) {
                    $join->on("{$this->tableName}.id", '=', "webinar_reviews.{$this->columnId}");
                    $join->where('webinar_reviews.status', 'active');
                })
                    ->whereNotNull('rates')
                    ->select("{$this->tableName}.*", DB::raw('avg(rates) as rates'))
                    ->groupBy("{$this->tableName}.id")
                    ->orderBy('rates', 'desc');
            }
        }

        if (!empty($filterOptions) and is_array($filterOptions)) {
            $webinarIdsFilterOptions = WebinarFilterOption::whereIn('filter_option_id', $filterOptions)
                ->pluck($this->columnId)
                ->toArray();

            $query->whereIn("{$this->tableName}.id", $webinarIdsFilterOptions);
        }

        return $query;
    }

    public function outline(Request $request)
    {
        $subject = $request->get('subject');
        $search = $request->get('search');
        $subject_id = Category::where('slug', $subject)->pluck('id')->toArray();
        $webinarsQuery = Webinar::where('webinars.status', 'active')
            ->where('private', false);

        if (!empty($subject)) {
            $webinarsQuery->whereIn('webinars.category_id', $subject_id);
        }
        if (!empty($search)) {
            $webinarsQuery->where(function ($query) use ($search) {
                $query->whereTranslationLike('title', "%$search%")
                    ->orWhereTranslationLike('description', "%$search%")
                    ->orWhereTranslationLike('seo_description', "%$search%")
                    ->orWhereTranslationLike('webinar_id', "%$search%");
            });
        }
        $outlines = $webinarsQuery->where('webinars.type', Webinar::$webinar)->paginate(12);
        $exams = $webinarsQuery->where('webinars.type', Webinar::$course)->paginate(12);
        $questions = $webinarsQuery->where('webinars.type', Webinar::$textLesson)->paginate(12);

        $subjectItem = Category::where('slug', $subject)->first();
        if ($subjectItem != null) {
            $subject = $subjectItem->title;
        } else {
            $subject = null;
        }
        $data = [
            'outlines' => $outlines,
            'exams' => $exams,
            'questions' => $questions,
            'subject' => $subject
        ];
        return view('web_v2.pages.outline', $data);
    }

    public function school(Request $request, $slug)
    {
        $search = $request->get('search', '');
        $majors_search = $request->get('majors', []);
        $school = Category::where('slug', $slug)->first();

        $majors = Category::where('parent_id', $school->id)
            ->where('level', 2)
            ->orderBy('order', 'asc')
            ->get();

        $majors_list = Category::where('parent_id', $school->id)
            ->where('level', 2)
            ->pluck('id')->toArray();


        $subjectQuery = Category::where('parent_id', $majors_list)
            ->where('level', 3);

        if ($search) {
            $subjectQuery = $subjectQuery->whereTranslationLike('title', "%$search%");
        }
        if ($majors_search) {
            $subjectQuery = $subjectQuery->whereIn('slug', $majors_search);
        }
        $subjectAll = $subjectQuery->paginate(12);

        $seoSettings = getSeoMetas('classes');
        $pageTitle = $seoSettings['title'] ?? '';
        $pageDescription = $seoSettings['description'] ?? '';
        $pageRobot = getPageRobot('classes');
        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'pageRobot' => $pageRobot,
            'majors' => $majors,
            'school' => $school,
            'subjectAll' => $subjectAll,
        ];
        return view('web_v2.pages.course-list', $data);
    }
}

