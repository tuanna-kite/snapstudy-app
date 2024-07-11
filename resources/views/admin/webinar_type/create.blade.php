@extends('admin.layouts.app')

@push('libraries_top')


@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{!empty($type) ?trans('/admin/main.edit'): trans('admin/main.new') }} {{ trans('admin/main.webinar_type') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active"><a href="{{ route('webinar.type') }}">{{ trans('admin/main.webinar_type') }}</a>
                </div>
                <div class="breadcrumb-item">{{!empty($type) ? trans('/admin/main.edit'): trans('admin/main.new') }}</div>
            </div>
        </div>
        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/webinar-type/{{ !empty($type) ? $type->id.'/update' : 'store' }}" method="Post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group @error('title') is-invalid @enderror">
                                            @if(empty($type))
                                                <label>{{ trans('admin/main.title') }}</label>
                                            @endif
                                            <input type="{{ !empty($type) ? 'hidden' : 'text' }}" name="title" class="form-control"
                                                   value="{{ !empty($type) ? $type->title : old('title') }}"
                                                   placeholder=""/>
                                        </div>

                                        @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                        <div class="form-group @error('price') is-invalid @enderror">
                                            <label>{{ trans('admin/main.price') }}</label>
                                            <input type="text" name="price"
                                                   class="form-control  @error('price') is-invalid @enderror"
                                                   value="{{ !empty($type) ? $type->price : old('price') }}"/>
                                            @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('/admin/main.status') }}</label>
                                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                                <option disabled selected>{{ trans('admin/main.select_status') }}</option>
                                                @foreach (\App\Models\WebinarType::$statuses as $status)
                                                    <option
                                                        value="{{ $status }}" {{ old('status') === $status ? 'selected' :''}}>{{  $status }}</option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class=" mt-4">
                                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/admin/roles.min.js"></script>
@endpush
