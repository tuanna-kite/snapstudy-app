@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.webinar_type') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ trans('admin/main.webinar_type') }}</div>
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
                                        <th>#</th>
                                        <th class="text-left">{{ trans('admin/main.title') }}</th>
                                        <th>{{ trans('admin/main.price') }}</th>
                                        <th>{{ trans('admin/main.status') }}</th>
                                        <th>{{ trans('admin/main.created_at') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>
                                    @foreach($types as $type)
                                        <tr>
                                            <td>{{$type->id}}</td>
                                            <td class="text-left">{{$type->title}}</td>
                                            <td>{{ $type->price }}</td>
                                            <td>
                                                @if($type->status === \App\Models\WebinarType::ACTIVE)
                                                    <span class="text-success">{{ trans('admin/main.active') }}</span>
                                                @else
                                                    <span class="text-warning">{{ trans('admin/main.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ dateTimeFormat($type->created_at,'j M Y') }}</td>
                                            <td>
                                                <a href="{{ getAdminPanelUrl() }}/webinar-type/{{ $type->id }}/edit" class="btn-transparent text-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/webinar-type/'.$type->id.'/delete'])

                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $types->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')

@endpush
