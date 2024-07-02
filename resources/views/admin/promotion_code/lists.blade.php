@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.promotions') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ trans('admin/main.promotions') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>ID</th>
                                        <th>{{ trans('Code') }}</th>
                                        <th class="text-center">{{ trans('Discount') }}</th>
                                        <th class="text-center">{{ trans('Trạng thái') }}</th>
                                        <th class="text-center">{{ trans('Ngày hết hạn') }}</th>
                                        <th class="text-center">{{ trans('admin/main.created_at') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($promotions as $promotion)
                                        <tr>
                                            <td>{{ $promotion->id }}</td>
                                            <td>{{ $promotion->code }}</td>
                                            <td class="text-center">{{ $promotion->discount }}</td>
                                            <td class="text-center">{{ $promotion->is_used ? 'Đã sử dụng' : 'Chưa sử dụng' }}</td>
                                            <td class="text-center">{{ $promotion->expires_at }}</td>
                                            <td class="text-center">{{ $promotion->created_at}}</td>
                                            <td>

                                                @can('admin_promotion_delete')
                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/financial/promotion-code/'. $promotion->id.'/delete','btnClass' => ''])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $promotions->appends(request()->input())->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

