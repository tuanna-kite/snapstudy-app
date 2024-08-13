@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
    <section class="section">


        <div class="section-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary.main">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Tổng thu nhập</h4>
                            </div>
                            <div class="card-body">
                                {{-- TODO: Update Variable here --}}
                                {{ handlePrice($totalWage) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-money-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Thu nhập tháng {{ date('m') }}</h4>
                            </div>
                            <div class="card-body">
                                {{-- TODO: Update Variable here --}}
                                {{ handlePrice($totalWageMount) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Số lượng bài đã hoàn thành</h4>
                            </div>
                            <div class="card-body">
                                {{-- TODO: Update Variable here --}}
                                {{ $totalWebinars }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Số lượng bài chờ duyệt</h4>
                            </div>
                            <div class="card-body">
                                {{-- TODO: Update Variable here --}}
                                {{ $totalPendingWebinars }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <section class="card">
                <div class="card-body">
                    <form method="get" class="mb-0">
                        <input type="hidden" name="type" value="{{ request()->get('type') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input name="title" type="text" class="form-control"
                                        value="{{ request()->get('title') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                                    <div class="input-group">
                                        <input type="date" id="from" class="text-center form-control" name="from"
                                            value="{{ request()->get('from') }}" placeholder="Start Date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                                    <div class="input-group">
                                        <input type="date" id="to" class="text-center form-control" name="to"
                                            value="{{ request()->get('to') }}" placeholder="End Date">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.status') }}</label>
                                    <select name="status" data-plugin-selectTwo class="form-control populate">
                                        <option value="">{{ trans('admin/main.all_status') }}</option>
                                        <option value="">{{ trans('admin/main.all_status') }}</option>
                                        <option value="pending" @if (request()->get('status') == 'pending') selected @endif>
                                            {{ trans('admin/main.stop') }}</option>
                                        <option value="assigned" @if (request()->get('status') == 'assigned') selected @endif>
                                            {{ trans('public.assign') }}</option>
                                        <option value="reviewed" @if (request()->get('status') == 'reviewed') selected @endif>
                                            {{ trans('public.review') }}</option>
                                        <option value="inactive" @if (request()->get('status') == 'inactive') selected @endif>
                                            {{ trans('public.rejected') }}</option>
                                        <option value="active" @if (request()->get('status') == 'active') selected @endif>
                                            {{ trans('public.active') }}</option>
                                        <option value="is_draft" @if (request()->get('status') == 'is_draft') selected @endif>
                                            {{ trans('admin/main.is_draft') }}</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group mt-1">
                                    <label class="input-label mb-4"> </label>
                                    <input type="submit" class="text-center btn btn-primary w-100"
                                        value="{{ trans('admin/main.show_results') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="h-10"></div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive" style="min-height: 300px">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('admin/main.id') }}</th>
                                        <th class="text-left">{{ trans('admin/main.title') }}</th>
                                        <th>{{ trans('admin/main.webinar_type') }}</th>
                                        <th>Chi phí triển khai</th>
                                        <th>{{ trans('admin/main.status') }}</th>
                                        <th width="10%">{{ trans('Số lần chỉnh sửa') }}</th>
                                        <th width="120">{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach ($webinars as $webinar)
                                        @php
                                            $count = $webinars->firstItem() + $loop->iteration - 1;
                                        @endphp
                                        <tr class="text-center">
                                            <td>{{ $count }}</td>
                                            <td>{{ $webinar->id }}</td>

                                            <td width="18%" class="text-left">
                                                <a class="text-primary mt-0 mb-1 font-weight-bold" href="{{ $webinar->type == \App\Models\Webinar::$quizz ? route('quizzes.preview', ['id' => $webinar->id]) : route('webinar.preview', ['id' => $webinar->id]) }}">{{ $webinar->title }}</a>
                                                @if(!empty($webinar->category->title))
                                                    <div class="text-small">{{ $webinar->category->title }}</div>
                                                @else
                                                    <div class="text-small text-warning">
                                                        {{ trans('admin/main.no_category') }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="mt-0 mb-1">
                                                    {{ $webinar->type == \App\Models\Webinar::$course ? 'exam' : $webinar->type }}
                                                </span>
                                            </td>
                                            <td>
                                                {{-- TODO: Check Variable here --}}
                                                {{ handlePrice($webinar->implementation_cost) }}
                                            </td>
                                            <td>
                                                @switch($webinar->status)
                                                    @case(\App\Models\Webinar::$active)
                                                        <div class="text-success font-600-bold">
                                                            {{ trans('admin/main.published') }}
                                                        </div>
                                                        @if ($webinar->isWebinar())
                                                            @if ($webinar->isProgressing())
                                                                <div class="text-warning text-small">
                                                                    ({{ trans('webinars.in_progress') }})
                                                                </div>
                                                            @elseif($webinar->start_date > time())
                                                                <div class="text-danger text-small">
                                                                    ({{ trans('admin/main.not_conducted') }})</div>
                                                            @else
                                                            @endif
                                                        @endif
                                                    @break

                                                    @case(\App\Models\Webinar::$isDraft)
                                                        <span class="text-dark">{{ trans('admin/main.is_draft') }}</span>
                                                    @break

                                                    @case(\App\Models\Webinar::$pending)
                                                        <span class="text-info">{{ trans('admin/main.stop') }}</span>
                                                    @break

                                                    @case(\App\Models\Webinar::$inactive)
                                                        <span class="text-primary">{{ trans('public.rejected') }}</span>
                                                    @break

                                                    @case(\App\Models\Webinar::$assigned)
                                                        <span class="text-warning">{{ trans('public.assign') }}</span>
                                                    @break

                                                    @case(\App\Models\Webinar::$reviewed)
                                                        <span class="text-danger">{{ trans('public.review') }}</span>
                                                    @break

                                                    @case(\App\Models\Webinar::$active)
                                                        <span class="text-success">{{ trans('public.active') }}</span>
                                                    @break
                                                @endswitch
                                            </td>

                                            <td>
                                                <span class="mt-0 mb-1">
                                                    {{ $webinar->revision_count ?? 0 }}
                                                </span>
                                            </td>

                                            <td width="200" class="">
                                                <div class="btn-group dropdown table-actions">
                                                    <button type="button" class="btn-transparent dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu text-left webinars-lists-dropdown">

                                                        @can('admin_webinars_edit')
                                                            @if ($webinar->status == \App\Models\Webinar::$pending)
                                                                @can('admin_webinars_publish')
                                                                    @include(
                                                                        'admin.includes.delete_button',
                                                                        [
                                                                            'url' =>
                                                                                getAdminPanelUrl() .
                                                                                '/webinars/' .
                                                                                $webinar->id .
                                                                                '/approve',
                                                                            'btnClass' =>
                                                                                'd-flex align-items-center text-success text-decoration-none btn-transparent btn-sm mt-1',
                                                                            'btnText' =>
                                                                                '<i class="fa fa-check"></i><span class="ml-2">' .
                                                                                trans('admin/main.approve') .
                                                                                '</span>',
                                                                        ]
                                                                    )

                                                                    @include(
                                                                        'admin.includes.delete_button',
                                                                        [
                                                                            'url' =>
                                                                                getAdminPanelUrl() .
                                                                                '/webinars/' .
                                                                                $webinar->id .
                                                                                '/reject',
                                                                            'btnClass' =>
                                                                                'd-flex align-items-center text-danger text-decoration-none btn-transparent btn-sm mt-1',
                                                                            'btnText' =>
                                                                                '<i class="fa fa-times"></i><span class="ml-2">' .
                                                                                trans('admin/main.reject') .
                                                                                '</span>',
                                                                        ]
                                                                    )
                                                                @endcan
                                                            @elseif($webinar->status == \App\Models\Webinar::$assigned)
                                                                @can('admin_webinars_ctv')
                                                                    @include(
                                                                        'admin.includes.delete_button',
                                                                        [
                                                                            'url' =>
                                                                                getAdminPanelUrl() .
                                                                                '/webinars/' .
                                                                                $webinar->id .
                                                                                '/reviewed',
                                                                            'btnClass' =>
                                                                                'd-flex align-items-center text-danger text-decoration-none btn-transparent btn-sm mt-1',
                                                                            'btnText' =>
                                                                                '<i class="fa fa-times"></i><span class="ml-2">' .
                                                                                trans('admin/main.reviews') .
                                                                                '</span>',
                                                                        ]
                                                                    )
                                                                @endcan
                                                            @endif
                                                        @endcan



                                                        @can('admin_webinars_ctv')
                                                            <a href="{{ $webinar->type == \App\Models\Webinar::$quizz ? route('content.quizzes.edit', ['id' => $webinar->id]) : route('webinar.content.edit', ['id' => $webinar->id]) }}" target="_blank" class="d-flex align-items-center text-dark text-decoration-none btn-transparent btn-sm text-primary mt-1 " title="{{ trans('admin/main.edit') }}">
                                                                <i class="fa fa-edit"></i>
                                                                <span class="ml-2">{{ trans('admin/main.edit') }}</span>
                                                            </a>
                                                        @endcan

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $webinars->appends(request()->input())->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script>
        $('#school').change(function() {
            var schoolId = $(this).val();
            $('#major').removeAttr('disabled');
            $('#major').empty();
            if (schoolId) {
                let html = '<option value="" id="campus_option">{{ trans('admin/main.campus') }}</option>';
                $.get(adminPanelPrefix + '/categories/get-major/' + schoolId, function(result) {
                    if (result && result.code === 200) {
                        console.log(result)

                        if (result.majors && result.majors.length) {
                            for (let major of result.majors) {
                                html += '<option value="' + major.id + '">' + major.title + '</option>';
                            }
                        }
                        $('#major').append(html);
                    }
                })
            } else {
                $('#major').empty();
            }
        });

        $('#major').change(function() {
            var majorID = $(this).val();
            $('#subject').removeAttr('disabled');
            $('#subject').empty();
            if (majorID) {
                let html_major = '<option value="">{{ trans('admin/main.subject2') }}</option>';
                $.get(adminPanelPrefix + '/categories/get-subject/' + majorID, function(result) {
                    if (result && result.code === 200) {
                        const subject = $('#subject');

                        if (result.subjects && result.subjects.length) {
                            for (let subject of result.subjects) {
                                html_major += '<option value="' + subject.id + '">' + subject.title +
                                    '</option>';
                            }
                        }
                        $('#subject').append(html_major);
                    }
                })
            } else {
                $('#subject').empty();
            }
        });

        function copyCourse(courseId) {
            $.ajax({
                url: "{{ route('webinar.copy', '') }}/" + courseId,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.error);
                }
            });
        }
    </script>
@endpush
