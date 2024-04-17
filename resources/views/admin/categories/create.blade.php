@extends('admin.layouts.app')

@push('styles_top')
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{!empty($category) ?trans('/admin/main.edit'): trans('admin/main.new') }} {{ trans('admin/main.category') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ getAdminPanelUrl() }}/categories">{{ trans('admin/main.categories') }}</a>
                </div>
                <div class="breadcrumb-item">{{!empty($category) ?trans('/admin/main.edit'): trans('admin/main.new') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/categories/{{ !empty($category) ? $category->id.'/update' : 'store' }}"
                                  method="Post">
                                {{ csrf_field() }}

                                @if(!empty(getGeneralSettings('content_translate')))
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                        <select name="locale" class="form-control {{ !empty($category) ? 'js-edit-content-locale' : '' }}">
                                            @foreach($userLanguages as $lang => $language)
                                                <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>{{ $language }}</option>
                                            @endforeach
                                        </select>
                                        @error('locale')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                @else
                                    <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">
                                @endif

                                <div class="form-group">
                                    <label>{{ trans('/admin/main.title') }}</label>
                                    <input type="text" name="title"
                                           class="form-control  @error('title') is-invalid @enderror"
                                           value="{{ !empty($category) ? $category->title : old('title') }}"
                                           placeholder="{{ trans('admin/main.choose_title') }}"/>
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('/admin/main.school_name') }}</label>
                                    <input type="text" name="description"
                                           class="form-control  @error('description') is-invalid @enderror"
                                           value="{{ !empty($category) ? $category->description : old('description') }}"
                                           placeholder="{{ trans('admin/main.school_name') }}"/>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('admin/main.prefix') }}</label>
                                    <input type="text" name="prefix"
                                           class="form-control  @error('prefix') is-invalid @enderror"
                                           value="{{ !empty($category) ? $category->prefix : old('prefix') }}"/>
                                    @error('prefix')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.order') }}</label>
                                    <input type="text" name="order"
                                           class="form-control  @error('order') is-invalid @enderror"
                                           value="{{ !empty($category) ? $category->order : old('order') }}"/>
                                    <div class="text-muted text-small mt-1">{{ trans('update.category_order_hint') }}</div>
                                    @error('slug')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.icon') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button" class="input-group-text admin-file-manager " data-input="icon" data-preview="holder">
                                                <i class="fa fa-upload"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="icon" id="icon" value="{{ !empty($category) ? $category->icon : old('icon') }}" class="form-control @error('icon') is-invalid @enderror"/>
                                        <div class="invalid-feedback">@error('icon') {{ $message }} @enderror</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input id="hasSubCategory" type="checkbox" name="has_sub"
                                               class="custom-control-input" {{ (!empty($subCategories) and !$subCategories->isEmpty()) ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                               for="hasSubCategory">{{ trans('admin/main.has_sub_category') }}</label>
                                    </div>
                                </div>

                                <div id="subCategories" class="ml-0 {{ (!empty($subCategories) and !$subCategories->isEmpty()) ? '' : ' d-none' }}">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <strong class="d-block">{{ trans('admin/main.add_majors') }}</strong>

                                        <button type="button" class="btn btn-success add-btn"><i class="fa fa-plus"></i> Add</button>
                                    </div>

                                    <ul class="draggable-lists list-group">

                                        @if((!empty($subCategories) and !$subCategories->isEmpty()))
                                            @foreach($subCategories as $key => $subCategory)
                                                <input type="hidden" name="subCategory_id" value="{{ $subCategory->id }}">
                                                <li class="form-group list-group draggable-lists-outline">

                                                    <div class="p-2 border rounded-sm">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text cursor-pointer move-icon">
                                                                    <i class="fa fa-arrows-alt"></i>
                                                                </div>
                                                            </div>

                                                            <input type="text" name="sub_categories[{{ $subCategory->id }}][title]"
                                                                   class="form-control w-auto flex-grow-1"
                                                                   value="{{ $subCategory->title }}"
                                                                   placeholder="{{ trans('admin/main.choose_title') }}"/>

                                                            <div class="input-group-append">
                                                                @include('admin.includes.delete_button',[
                                                                         'url' => getAdminPanelUrl("/categories/{$subCategory->id}/delete"),
                                                                         'deleteConfirmMsg' => trans('update.category_delete_confirm_msg'),
                                                                         'btnClass' => 'btn btn-danger text-white',
                                                                         'noBtnTransparent' => true
                                                                     ])
                                                            </div>
                                                        </div>

{{--                                                        <div class="input-group w-100 mt-1">--}}
{{--                                                            <input type="text" name="sub_categories[{{ $subCategory->id }}][slug]"--}}
{{--                                                                   class="form-control w-auto flex-grow-1"--}}
{{--                                                                   value="{{ $subCategory->slug }}"--}}
{{--                                                                   placeholder="{{ trans('admin/main.choose_url') }}"/>--}}
{{--                                                        </div>--}}

                                                        <div class="input-group w-100 mt-1">
                                                            <input type="text" name="sub_categories[{{ $subCategory->id }}][description]"
                                                                   class="form-control w-auto flex-grow-1"
                                                                   value="{{ $subCategory->description }}"
                                                                   placeholder="{{ trans('admin/main.description') }}"/>
                                                        </div>

                                                    </div>
                                                    @if($subCategory)
                                                        <div class="d-flex align-items-center justify-content-between mb-2 mt-2 ml-4">
                                                            <strong class="d-block">{{ trans('admin/main.add_subject') }}</strong>
                                                            <button type="button" class="btn btn-success outline-add-btn"><i class="fa fa-plus"></i> Add</button>
                                                        </div>
                                                    @endif

                                                <li class="form-group outline-list list-group ml-4 d-none">
                                                    <div class="p-2 border rounded-sm">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text cursor-pointer move-icon">
                                                                    <i class="fa fa-arrows-alt"></i>
                                                                </div>
                                                            </div>

                                                            <input type="text" name="outline_{{ $subCategory->id }}[record][title]"
                                                                   class="form-control w-auto flex-grow-1"
                                                                   placeholder="{{ trans('admin/main.title_subject') }}"/>

                                                            <div class="input-group-append">
                                                                <button type="button" class="btn remove-btn btn-danger"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </div>

                                                        <div class="input-group mt-1">
                                                            <input type="text" name="outline_{{ $subCategory->id }}[record][description]"
                                                                   class="form-control w-auto flex-grow-1"
                                                                   placeholder="{{ trans('admin/main.description_subject') }}"/>
                                                        </div>
                                                    </div>
                                                </li>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>

                                <div class="text-right mt-4">
                                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                </div>
                            </form>

                            <li class="form-group main-row list-group d-none">
                                <div class="p-2 border rounded-sm">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text cursor-pointer move-icon">
                                                <i class="fa fa-arrows-alt"></i>
                                            </div>
                                        </div>

                                        <input type="text" name="sub_categories[record][title]"
                                               class="form-control w-auto flex-grow-1"
                                               placeholder="{{ trans('admin/main.title_majors') }}"/>

                                        <div class="input-group-append">
                                            <button type="button" class="btn remove-btn btn-danger"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>

                                    <div class="input-group mt-1">
                                        <input type="text" name="sub_categories[record][description]"
                                               class="form-control w-auto flex-grow-1"
                                               placeholder="{{ trans('admin/main.title_majors') }}"/>
                                    </div>
                                </div>
                            </li>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>

    <script src="/assets/default/js/admin/categories.min.js"></script>
@endpush
