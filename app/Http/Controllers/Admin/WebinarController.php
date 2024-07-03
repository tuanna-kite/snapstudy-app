<?php

namespace App\Http\Controllers\Admin;

use App\Exports\WebinarsExport;
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
use App\User;
use App\Models\Webinar;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class WebinarController extends Controller
{
    use WebinarChangeCreator;


    public function index(Request $request)
    {
        $this->authorize('admin_webinars_list');

        removeContentLocale();

        $type = $request->get('type', 'webinar');
        $query = Webinar::where('webinars.type', '!=', 'quizz');

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

        return view('admin.webinars.lists', $data);
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
        $creator_ids = $request->get('creator_ids', null);

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

        if (!empty($creator_ids) and count($creator_ids)) {
            $query->whereIn('creator_id', $creator_ids);
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

    public function create()
    {
        $this->authorize('admin_webinars_create');

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

        $data = [
            'pageTitle' => trans('admin/main.webinar_new_page_title'),
            'teachers' => $teachers,
            'categories' => $categories,
            'users' => $users
        ];

        return view('admin.webinars.create', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('admin_webinars_create');
        $user = Auth::user()->id;
        $request->validate([
            'type' => 'required|in:webinar,course,text_lesson',
            'title' => 'required|max:255',
            'slug' => 'max:255|unique:webinars,slug',
            // //            'thumbnail' => 'required',
            // // 'image_cover' => 'required',
            'teacher_id' => 'required|exists:users,id',
            'category_id' => 'required',
            'description' => 'required',
            'content' => 'required',
            // 'table_contents' => 'required',
            // 'preview_content' => 'required',
            // 'duration' => 'required|numeric'
            // 'start_date' => 'required_if:type,webinar',
            // 'capacity' => 'required_if:type,webinar',
        ]);



        $data = $request->all();

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

        $table_contents = [
            'table_contents' => $data['table_contents']
        ];

        $validator = Validator::make($table_contents, [
            'table_contents' => 'required',
        ], [
            'table_contents.required' => 'Vui lòng nhập mục lục ở nội dung',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors->add('content', $errors->first('table_contents'));
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        if ($data['type'] != Webinar::$webinar) {
            $data['start_date'] = null;
        }

        if (!empty($data['start_date']) and $data['type'] == Webinar::$webinar) {
            if (empty($data['timezone']) or !getFeaturesSettings('timezone_in_create_webinar')) {
                $data['timezone'] = getTimezone();
            }

            $startDate = convertTimeToUTCzone($data['start_date'], $data['timezone']);

            $data['start_date'] = $startDate->getTimestamp();
        }

        if (empty($data['slug'])) {
            $data['slug'] = Webinar::makeSlug($data['title']);
        }

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

        $data['price'] = !empty($data['price']) ? convertPriceToDefaultCurrency($data['price']) : null;

        $data['organization_price'] = !empty($data['organization_price']) ? convertPriceToDefaultCurrency($data['organization_price']) : null;
        $webinar = Webinar::create([
            // 'image_cover' => $data['image_cover'],
            // 'video_demo' => $data['video_demo'],
            // 'video_demo_source' => $data['video_demo'] ? $data['video_demo_source'] : null,
            // 'capacity' => $data['capacity'] ?? null,
            // 'start_date' => (!empty($data['start_date'])) ? $data['start_date'] : null,
            // 'timezone' => $data['timezone'] ?? null,
            // 'duration' => $data['duration'] ?? null,
            // 'certificate' => !empty($data['certificate']) ? true : false,
            // 'access_days' => $data['access_days'] ?? null,
            // 'points' => $data['points'] ?? null,
            'type' => $data['type'],
            'slug' => preg_replace(
                '/[^A-Za-z0-9\-]/',
                '',
                str_replace(' ', '-', strtolower($data['slug']))
            ) . '-' . Str::random(5),
            'teacher_id' => $data['teacher_id'],
            'creator_id' => $data['creator_id'],
            'category_id' => $data['category_id'],
            'thumbnail' => $data['thumbnail'] ?? null,
            'price' => $data['price'],
            'support' => !empty($data['support']),
            'downloadable' => !empty($data['downloadable']),
            'partner_instructor' => !empty($data['partner_instructor']),
            'subscribe' => !empty($data['subscribe']),
            'private' => !empty($data['private']),
            'forum' => !empty($data['forum']),
            'enable_waitlist' => (!empty($data['enable_waitlist'])),
            'organization_price' => $data['organization_price'] ?? null,
            'personalization_user' => $data['personalization_user'] ?? null,
            'message_for_reviewer' => $data['message_for_reviewer'] ?? null,
            'status' => Webinar::$pending,
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
                'description' => $data['description'],
                'content' => $data['content'],
                'table_contents' => $data['table_contents'],
                'preview_content' => $data['preview_content'],
                'seo_description' => $data['seo_description'],
            ]);
        }

        return redirect(getAdminPanelUrl() . '/webinars/' . $webinar->id . '/edit?locale=' . $data['locale']);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');

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

        if ($webinarTrans) {
            $newContent = $this->convertHTMLImgSrc($webinarTrans->content);
            $webinarTrans->content = $newContent;
            if (!empty($webinarTrans->preview_content)){
                $newPreviewContent = $this->convertHTMLImgSrc($webinarTrans->preview_content);
                $webinarTrans->preview_content = $newPreviewContent;
            }
            if (!empty($webinarTrans->table_contents)){
                $newTableContent = $this->convertHTMLImgSrc($webinarTrans->table_contents);
                $webinarTrans->table_contents = $newTableContent;
            }
        }

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
            'users' => $users
        ];

        return view('admin.webinars.create', $data);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');
        $data = $request->all();

        $webinar = Webinar::find($id);
        $isDraft = (!empty($data['draft']) and $data['draft'] == 1);
        $reject = (!empty($data['draft']) and $data['draft'] == 'reject');
        $publish = (!empty($data['draft']) and $data['draft'] == 'publish');

        $rules = [
            'type' => 'required|in:webinar,course,text_lesson',
            'title' => 'required|max:255',
            'slug' => 'max:255|unique:webinars,slug,' . $webinar->id,
            //            'thumbnail' => 'required',
            // 'image_cover' => 'required',
            'description' => 'required',
            'content' => 'required',
            'teacher_id' => 'required|exists:users,id',
            'category_id' => 'required',
            'preview_content' => 'required',
            'table_contents' => 'required',
        ];

        // if ($webinar->isWebinar()) {
        //     $rules['start_date'] = 'required|date';
        //     $rules['duration'] = 'required';
        //     $rules['capacity'] = 'required|integer';
        // }

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


        if (empty($data['slug'])) {
            $data['slug'] = Webinar::makeSlug($data['title']);
        }

        $data['status'] = $publish ? Webinar::$active : ($reject ? Webinar::$inactive : ($isDraft ? Webinar::$isDraft : Webinar::$pending));
        $data['updated_at'] = time();

        // if (!empty($data['start_date']) and $webinar->type == 'webinar') {
        //     if (empty($data['timezone']) or !getFeaturesSettings('timezone_in_create_webinar')) {
        //         $data['timezone'] = getTimezone();
        //     }

        //     $startDate = convertTimeToUTCzone($data['start_date'], $data['timezone']);

        //     $data['start_date'] = $startDate->getTimestamp();
        // } else {
        //     $data['start_date'] = null;
        // }


        $data['support'] = !empty($data['support']) ? true : false;
        $data['certificate'] = !empty($data['certificate']) ? true : false;
        $data['downloadable'] = !empty($data['downloadable']) ? true : false;
        $data['partner_instructor'] = !empty($data['partner_instructor']) ? true : false;
        $data['subscribe'] = !empty($data['subscribe']) ? true : false;
        $data['forum'] = !empty($data['forum']) ? true : false;
        $data['private'] = !empty($data['private']) ? true : false;
        $data['enable_waitlist'] = (!empty($data['enable_waitlist']));

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

        $newCreatorId = !empty($data['organ_id']) ? $data['organ_id'] : $data['teacher_id'];
        $changedCreator = ($webinar->creator_id != $newCreatorId);

        $data['price'] = !empty($data['price']) ? convertPriceToDefaultCurrency($data['price']) : null;
        $data['organization_price'] = !empty($data['organization_price']) ? convertPriceToDefaultCurrency($data['organization_price']) : null;

        $webinar->update([
            'slug' => $data['slug'],
            'creator_id' => $newCreatorId,
            'teacher_id' => $data['teacher_id'],
            'type' => $data['type'],
            'thumbnail' => $data['thumbnail'],
            // 'image_cover' => $data['image_cover'],
            // 'video_demo' => $data['video_demo'],
            // 'video_demo_source' => $data['video_demo'] ? $data['video_demo_source'] : null,
            'capacity' => $data['capacity'] ?? null,
            // 'start_date' => $data['start_date'],
            'timezone' => $data['timezone'] ?? null,
            'duration' => $data['duration'] ?? null,
            'support' => $data['support'],
            'certificate' => $data['certificate'],
            'private' => $data['private'],
            'enable_waitlist' => $data['enable_waitlist'],
            'downloadable' => $data['downloadable'],
            'partner_instructor' => $data['partner_instructor'],
            'subscribe' => $data['subscribe'],
            'forum' => $data['forum'],
            'access_days' => $data['access_days'] ?? null,
            'price' => $data['price'],
            'organization_price' => $data['organization_price'] ?? null,
            'category_id' => $data['category_id'],
            'points' => $data['points'] ?? null,
            'message_for_reviewer' => $data['message_for_reviewer'] ?? null,
            'personalization_user' => $data['personalization_user'] ?? null,
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
                'content' => $data['content'],
                'seo_description' => $data['seo_description'],
                'table_contents' => $data['table_contents'],
                'preview_content' => $data['preview_content'],
            ]);
        }

        if ($publish) {
            // sendNotification('course_approve', ['[c.title]' => $webinar->title], $webinar->teacher_id);

            $createClassesReward = RewardAccounting::calculateScore(Reward::CREATE_CLASSES);
            RewardAccounting::makeRewardAccounting(
                $webinar->creator_id,
                $createClassesReward,
                Reward::CREATE_CLASSES,
                $webinar->id,
                true
            );
        } elseif ($reject) {
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
        $this->authorize('admin_webinars_delete');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->delete();

        return redirect(getAdminPanelUrl() . '/webinars');
    }

    public function approve(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->update([
            'status' => Webinar::$active
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('update.course_status_changes_to_approved'),
            'status' => 'success'
        ];

        return redirect(getAdminPanelUrl() . '/webinars')->with(['toast' => $toastData]);
    }

    public function reject(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->update([
            'status' => Webinar::$inactive
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('update.course_status_changes_to_rejected'),
            'status' => 'success'
        ];

        return redirect(getAdminPanelUrl() . '/webinars')->with(['toast' => $toastData]);
    }

    public function unpublish(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->update([
            'status' => Webinar::$pending
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('update.course_status_changes_to_unpublished'),
            'status' => 'success'
        ];

        return redirect(getAdminPanelUrl() . '/webinars')->with(['toast' => $toastData]);
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
        $this->authorize('admin_webinars_export_excel');

        $query = Webinar::query();

        $query = $this->filterWebinar($query, $request)
            ->with([
                'teacher' => function ($qu) {
                    $qu->select('id', 'full_name');
                },
                'sales'
            ]);

        $webinars = $query->get();

        $webinarExport = new WebinarsExport($webinars);

        return Excel::download($webinarExport, 'webinars.xlsx');
    }

    public function studentsLists(Request $request, $id)
    {
        $this->authorize('admin_webinar_students_lists');

        $webinar = Webinar::where('id', $id)
            ->with([
                'teacher' => function ($qu) {
                    $qu->select('id', 'full_name');
                },
                'chapters' => function ($query) {
                    $query->where('status', 'active');
                },
                'sessions' => function ($query) {
                    $query->where('status', 'active');
                },
                'assignments' => function ($query) {
                    $query->where('status', 'active');
                },
                'quizzes' => function ($query) {
                    $query->where('status', 'active');
                },
                'files' => function ($query) {
                    $query->where('status', 'active');
                },
            ])
            ->first();


        if (!empty($webinar)) {
            $giftsIds = Gift::query()->where('webinar_id', $webinar->id)
                ->where('status', 'active')
                ->where(function ($query) {
                    $query->whereNull('date');
                    $query->orWhere('date', '<', time());
                })
                ->whereHas('sale')
                ->pluck('id')
                ->toArray();

            $installmentSalesIds = [];
            $installmentOrders = InstallmentOrder::query()
                ->where('webinar_id', $webinar->id)
                ->where('status', 'open')
                ->get();

            foreach ($installmentOrders as $installmentOrder) {

                $salesId = $installmentOrder->payments->pluck('sale_id')->toArray();
                $installmentSalesIds = array_merge($installmentSalesIds, $salesId);
            }

            $query = User::join('sales', 'sales.buyer_id', 'users.id')
                ->leftJoin('webinar_reviews', function ($query) use ($webinar) {
                    $query->on('webinar_reviews.creator_id', 'users.id')
                        ->where('webinar_reviews.webinar_id', $webinar->id);
                })
                ->select(
                    'users.*',
                    'webinar_reviews.rates',
                    'sales.access_to_purchased_item',
                    'sales.id as sale_id',
                    'sales.gift_id',
                    DB::raw('min(sales.created_at) as purchase_date')
                )
                ->where(function ($query) use ($webinar, $giftsIds, $installmentSalesIds) {
                    $query->where('sales.webinar_id', $webinar->id);
                    $query->orWhereIn('sales.gift_id', $giftsIds);
                    $query->orWhereIn('sales.id', $installmentSalesIds);
                })
                ->groupBy('sales.buyer_id')
                ->whereNull('sales.refund_at');

            $students = $this->studentsListsFilters($webinar, $query, $request)
                ->orderBy('sales.created_at', 'desc')
                ->paginate(10);

            $userGroups = Group::where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();

            $totalExpireStudents = 0;
            if (!empty($webinar->access_days)) {
                $accessTimestamp = $webinar->access_days * 24 * 60 * 60;

                $totalExpireStudents = User::join('sales', 'sales.buyer_id', 'users.id')
                    ->select('users.*', DB::raw('sales.created_at as purchase_date'))
                    ->where(function ($query) use ($webinar, $giftsIds) {
                        $query->where('sales.webinar_id', $webinar->id);
                        $query->orWhereIn('sales.gift_id', $giftsIds);
                    })
                    ->whereRaw('sales.created_at + ? < ?', [$accessTimestamp, time()])
                    ->whereNull('sales.refund_at')
                    ->count();
            }

            $webinarStatisticController = new WebinarStatisticController();

            $allStudentsIds = User::join('sales', 'sales.buyer_id', 'users.id')
                ->select('users.*', DB::raw('sales.created_at as purchase_date'))
                ->where(function ($query) use ($webinar, $giftsIds) {
                    $query->where('sales.webinar_id', $webinar->id);
                    $query->orWhereIn('sales.gift_id', $giftsIds);
                })
                ->whereNull('sales.refund_at')
                ->pluck('id')
                ->toArray();

            $learningPercents = [];
            foreach ($allStudentsIds as $studentsId) {
                $learningPercents[$studentsId] = $webinarStatisticController->getCourseProgressForStudent(
                    $webinar,
                    $studentsId
                );
            }

            foreach ($students as $key => $student) {
                if (!empty($student->gift_id)) {
                    $gift = Gift::query()->where('id', $student->gift_id)->first();

                    if (!empty($gift)) {
                        $receipt = $gift->receipt;

                        if (!empty($receipt)) {
                            $receipt->rates = $student->rates;
                            $receipt->access_to_purchased_item = $student->access_to_purchased_item;
                            $receipt->sale_id = $student->sale_id;
                            $receipt->purchase_date = $student->purchase_date;
                            $receipt->learning = $webinarStatisticController->getCourseProgressForStudent(
                                $webinar,
                                $receipt->id
                            );

                            $learningPercents[$student->id] = $receipt->learning;

                            $students[$key] = $receipt;
                        } else { /* Gift recipient who has not registered yet */
                            $newUser = new User();
                            $newUser->full_name = $gift->name;
                            $newUser->email = $gift->email;
                            $newUser->rates = 0;
                            $newUser->access_to_purchased_item = $student->access_to_purchased_item;
                            $newUser->sale_id = $student->sale_id;
                            $newUser->purchase_date = $student->purchase_date;
                            $newUser->learning = 0;

                            $students[$key] = $newUser;
                        }
                    }
                } else {
                    $student->learning = !empty($learningPercents[$student->id]) ? $learningPercents[$student->id] : 0;
                }
            }

            $roles = Role::all();

            $data = [
                'pageTitle' => trans('admin/main.students'),
                'webinar' => $webinar,
                'students' => $students,
                'userGroups' => $userGroups,
                'roles' => $roles,
                'totalStudents' => $students->total(),
                'totalActiveStudents' => $students->total() - $totalExpireStudents,
                'totalExpireStudents' => $totalExpireStudents,
                'averageLearning' => count($learningPercents) ? round(
                    array_sum($learningPercents) / count($learningPercents),
                    2
                ) : 0,
            ];

            return view('admin.webinars.students', $data);
        }

        abort(404);
    }

    private function studentsListsFilters($webinar, $query, $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $full_name = $request->get('full_name');
        $sort = $request->get('sort');
        $group_id = $request->get('group_id');
        $role_id = $request->get('role_id');
        $status = $request->get('status');

        $query = fromAndToDateFilter($from, $to, $query, 'sales.created_at');

        if (!empty($full_name)) {
            $query->where('users.full_name', 'like', "%$full_name%");
        }

        if (!empty($sort)) {
            if ($sort == 'rate_asc') {
                $query->orderBy('webinar_reviews.rates', 'asc');
            }

            if ($sort == 'rate_desc') {
                $query->orderBy('webinar_reviews.rates', 'desc');
            }
        }

        if (!empty($group_id)) {
            $userIds = GroupUser::where('group_id', $group_id)->pluck('user_id')->toArray();

            $query->whereIn('users.id', $userIds);
        }

        if (!empty($role_id)) {
            $query->where('users.role_id', $role_id);
        }

        if (!empty($status)) {
            if ($status == 'expire' and !empty($webinar->access_days)) {
                $accessTimestamp = $webinar->access_days * 24 * 60 * 60;

                $query->whereRaw('sales.created_at + ? < ?', [$accessTimestamp, time()]);
            }
        }

        return $query;
    }

    public function notificationToStudents($id)
    {
        $this->authorize('admin_webinar_notification_to_students');

        $webinar = Webinar::findOrFail($id);

        $data = [
            'pageTitle' => trans('notification.send_notification'),
            'webinar' => $webinar
        ];

        return view('admin.webinars.send-notification-to-course-students', $data);
    }


    public function sendNotificationToStudents(Request $request, $id)
    {
        $this->authorize('admin_webinar_notification_to_students');

        $this->validate($request, [
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        $data = $request->all();

        $webinar = Webinar::where('id', $id)
            ->with([
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                    $query->with([
                        'buyer'
                    ]);
                }
            ])
            ->first();

        if (!empty($webinar)) {
            foreach ($webinar->sales as $sale) {
                if (!empty($sale->buyer)) {
                    $user = $sale->buyer;

                    Notification::create([
                        'user_id' => $user->id,
                        'group_id' => null,
                        'sender_id' => auth()->id(),
                        'title' => $data['title'],
                        'message' => $data['message'],
                        'sender' => Notification::$AdminSender,
                        'type' => 'single',
                        'created_at' => time()
                    ]);

                    if (!empty($user->email) and env('APP_ENV') == 'production') {
                        \Mail::to($user->email)->send(new SendNotifications([
                            'title' => $data['title'],
                            'message' => $data['message']
                        ]));
                    }
                }
            }

            $toastData = [
                'title' => trans('public.request_success'),
                'msg' => trans(
                    'update.the_notification_was_successfully_sent_to_n_students',
                    ['count' => count($webinar->sales)]
                ),
                'status' => 'success'
            ];

            return redirect(getAdminPanelUrl("/webinars/{$webinar->id}/students"))->with(['toast' => $toastData]);
        }

        abort(404);
    }

    public function orderItems(Request $request)
    {
        $this->authorize('admin_webinars_edit');
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

        $tableName = $data['table'];
        $itemIds = explode(',', $data['items']);

        if (!is_array($itemIds) and !empty($itemIds)) {
            $itemIds = [$itemIds];
        }

        if (!empty($itemIds) and is_array($itemIds) and count($itemIds)) {
            switch ($tableName) {
                case 'tickets':
                    foreach ($itemIds as $order => $id) {
                        Ticket::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'sessions':
                    foreach ($itemIds as $order => $id) {
                        Session::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'files':
                    foreach ($itemIds as $order => $id) {
                        File::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'text_lessons':
                    foreach ($itemIds as $order => $id) {
                        TextLesson::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'webinar_chapters':
                    foreach ($itemIds as $order => $id) {
                        WebinarChapter::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'webinar_chapter_items':
                    foreach ($itemIds as $order => $id) {
                        WebinarChapterItem::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                case 'bundle_webinars':
                    foreach ($itemIds as $order => $id) {
                        BundleWebinar::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
            }
        }

        return response()->json([
            'title' => trans('public.request_success'),
            'msg' => trans('update.items_sorted_successful')
        ]);
    }


    public function getContentItemByLocale(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');

        $data = $request->all();

        $validator = Validator::make($data, [
            'item_id' => 'required',
            'locale' => 'required',
            'relation' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $webinar = Webinar::where('id', $id)->first();

        if (!empty($webinar)) {

            $itemId = $data['item_id'];
            $locale = $data['locale'];
            $relation = $data['relation'];

            if (!empty($webinar->$relation)) {
                $item = $webinar->$relation->where('id', $itemId)->first();

                if (!empty($item)) {
                    foreach ($item->translatedAttributes as $attribute) {
                        try {
                            $item->$attribute = $item->translate(mb_strtolower($locale))->$attribute;
                        } catch (\Exception $e) {
                            $item->$attribute = null;
                        }
                    }

                    return response()->json([
                        'item' => $item
                    ], 200);
                }
            }
        }

        abort(403);
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
}
