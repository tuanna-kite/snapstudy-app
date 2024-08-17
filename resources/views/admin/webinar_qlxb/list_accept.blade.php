@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Quản lý nghiệm thu</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-file-video"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Tổng cộng tài liệu</h4>
                            </div>
                            <div class="card-body">
                                {{ $total }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-money-bill"></i>
                        </div>

                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Tổng chi phí triển khai</h4>
                            </div>
                            <div class="card-body">
                                {{ handlePrice($implementation_cost) }}
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{trans('admin/main.search')}}</label>
                                    <input name="title" type="text" class="form-control" value="{{ request()->get('title') }}" placeholder="Nhập nội dung">
                                </div>
                            </div>

{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="input-label">{{trans('Tháng')}}</label>--}}
{{--                                    <select name="month" data-plugin-selectTwo class="form-control populate">--}}
{{--                                        <option value="">{{trans('Tất cả các tháng')}}</option>--}}
{{--                                        <option value="1" @if(request()->get('month') == '1') selected @endif>1</option>--}}
{{--                                        <option value="2" @if(request()->get('month') == '2') selected @endif>2</option>--}}
{{--                                        <option value="3" @if(request()->get('month') == '3') selected @endif>3</option>--}}
{{--                                        <option value="4" @if(request()->get('month') == '4') selected @endif>4</option>--}}
{{--                                        <option value="5" @if(request()->get('month') == '5') selected @endif>5</option>--}}
{{--                                        <option value="6" @if(request()->get('month') == '6') selected @endif>6</option>--}}
{{--                                        <option value="7" @if(request()->get('month') == '7') selected @endif>7</option>--}}
{{--                                        <option value="8" @if(request()->get('month') == '8') selected @endif>8</option>--}}
{{--                                        <option value="9" @if(request()->get('month') == '9') selected @endif>9</option>--}}
{{--                                        <option value="10" @if(request()->get('month') == '10') selected @endif>10</option>--}}
{{--                                        <option value="11" @if(request()->get('month') == '11') selected @endif>11</option>--}}
{{--                                        <option value="12" @if(request()->get('month') == '12') selected @endif>12</option>--}}

{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{trans('admin/main.start_date')}}</label>
                                    <div class="input-group">
                                        <input type="date" id="from" class="text-center form-control" name="from" value="{{ request()->get('from') }}" placeholder="Start Date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{trans('admin/main.end_date')}}</label>
                                    <div class="input-group">
                                        <input type="date" id="to" class="text-center form-control" name="to" value="{{ request()->get('to') }}" placeholder="End Date">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label"> </label>
                                    <input type="submit" class="text-center btn btn-primary w-100" value="{{trans('admin/main.show_results')}}">
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
                                <div class="text-right">
                                    <a href="{{ getAdminPanelUrl() }}/webinars/accept/excel?{{ http_build_query(request()->all()) }}" class="btn btn-primary">{{ trans('admin/main.export_xls') }}</a>
                                </div>
                             <div class="h-10"></div>
                            <div class="ml-3">
                                @php
                                    $countWebinar = $assignUser->total();
                                @endphp
                                <strong> {{__('home.Total results') }} : {{$countWebinar}}</strong>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive" style="min-height: 300px">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th class="text-left">{{trans('CTV')}}</th>
                                        <th width="20%">{{trans('Số lượng tài liệu')}}</th>
                                        <th width="20%">{{trans('Tổng tiền lương')}}</th>
                                        <th width="20%">{{trans('admin/main.actions')}}</th>
                                    </tr>

                                    @foreach($assignUser as $user)
                                    @php
                                        $count = $assignUser->firstItem() + $loop->iteration - 1;
                                    @endphp
                                        <tr class="text-center">
                                           <td>{{$count}}</td>
                                            <td>
                                                <span class="mt-0 mb-1">
                                                    {{ $user->full_name }}
                                                </span>

                                                <div class="text-small font-600-bold">{{ $user->email }}</div>
                                            </td>

                                            <td>
                                                <span class="mt-0 mb-1">
                                                    {{ $user->webinar_count }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="mt-0 mb-1">
                                                    {{ handlePrice($user->total_amount, true, true) }}
                                                </span>
                                            </td>

                                            <td width="200" class="">
                                                <div class="btn-group dropdown table-actions">
                                                    <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu text-left webinars-lists-dropdown">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $assignUser->appends(request()->input())->links() }}
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
                let html = '<option value="" id="campus_option">{{trans('admin/main.campus')}}</option>';
                $.get(adminPanelPrefix + '/categories/get-major/' + schoolId, function (result) {
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
                let html_major = '<option value="">{{trans('admin/main.subject2')}}</option>';
                $.get(adminPanelPrefix + '/categories/get-subject/' + majorID, function (result) {
                    if (result && result.code === 200) {
                        const subject = $('#subject');

                        if (result.subjects && result.subjects.length) {
                            for (let subject of result.subjects) {
                                html_major += '<option value="' + subject.id + '">' + subject.title + '</option>';
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
                success: function (response) {
                    location.reload();
                },
                error: function (xhr) {
                    alert(xhr.responseJSON.error);
                }
            });
        }

    </script>

@endpush
