@extends('admin.layouts.app')

@push('styles_top')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ trans('admin/main.promotions') }}</div>
            </div>
        </div>


        <div class="section-body card">

            <div class="d-flex align-items-center justify-content-between">
                <div class="">
                    <h2 class="section-title ml-4">{{ !empty($promotion) ? trans('admin/main.edit') : trans('admin/main.create') }}</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/financial/promotion-code/{{ !empty($promotion) ? $promotion->id.'/update' : 'store' }}" method="Post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label>{{ trans('Số lượng') }}</label>
                                    <input type="number" name="quantity"
                                           class="form-control  @error('quantity') is-invalid @enderror" step="1"
                                           value="{{ old('quantity') }}"/>
                                    @error('quantity')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('Giảm giá') }}(%)</label>
                                    <input type="number" name="discount"
                                           class="form-control  @error('discount') is-invalid @enderror" step="0.1"
                                           value="{{ old('discount') }}"/>
                                    @error('discount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('Ngày hết hạn') }}</label>
                                    <input type="date" name="expires_at"
                                           class="form-control  @error('expires_at') is-invalid @enderror"
                                           value="{{ old('expires_at') }}"/>
                                    @error('expires_at')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class=" mt-4">
                                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </section>
@endsection

