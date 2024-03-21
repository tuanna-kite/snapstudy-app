<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $pageTitle ?? '' }} </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/assets/admin/vendor/bootstrap/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/vendors/fontawesome/css/all.min.css"/>


    <link rel="stylesheet" href="/assets/admin/css/style.css">
    <link rel="stylesheet" href="/assets/admin/css/custom.css">
    <link rel="stylesheet" href="/assets/admin/css/components.css">

    <style>
        {!! !empty(getCustomCssAndJs('css')) ? getCustomCssAndJs('css') : '' !!}
    </style>
</head>
<body>

<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-md-10 offset-md-1 col-lg-10 offset-lg-1">
                    <div class="card card-primary">
                        <div class="row m-0">
                            <div class="col-12 col-md-12">
                                <div class="card-body">
                                    <div class="section-body">
                                        <div class="invoice">
                                            <div class="invoice-print">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="invoice-title">
                                                            {{--                                                            <h2>{{ $generalSettings['site_name'] }}</h2>--}}
                                                            <div>
                                                                <img width="80px"
                                                                     src="{{asset('assets/default/image/icons/favicon.ico')}}"
                                                                     alt="logo">
                                                            </div>
                                                            <div class="invoice-number">{{ trans('public.item_id') }}:
                                                                #{{ $webinar->id }}</div>
                                                        </div>
                                                        <h3 class="text-center mt-3" style="color: black">
                                                            PHIẾU MUA HÀNG
                                                        </h3>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <address>
                                                                    <strong>{{ trans('quiz.student') }}:</strong>
                                                                    <br>
                                                                    <h5>{{ $sale->buyer->full_name }}</h5>
                                                                </address>

                                                                <address>
                                                                    <strong>Email:</strong><br>
                                                                    {{ $sale->buyer->email }}
                                                                    <br>
                                                                </address>
                                                            </div>
                                                            <div class="col-6 text-right">
                                                                <h6>
                                                                    CÔNG TY CỔ PHẦN ĐẦU TƯ VÀ PHÁT TRIỂN GIÁO DỤC HỒNG
                                                                    LĨNH
                                                                </h6>
                                                                <address>
                                                                    <strong>{{ trans('home.platform_address') }}
                                                                        :</strong><br>
                                                                    {{--                                                                    {!! nl2br(getContactPageSettings('address')) !!}--}}
                                                                    Số 159 ngõ Thịnh Quang, Phố Thịnh Quang, Phường
                                                                    Thịnh Quang, Quận Đống Đa, Hà Nội
                                                                </address>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            </div>

                                                            <div class="col-md-6 text-right">
                                                                <address>
                                                                    <strong>{{ trans('panel.purchase_date') }}:</strong><br>
                                                                    {{ dateTimeFormat($sale->created_at,'d/M Y H:i') }}
                                                                    <br><br>
                                                                </address>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <div class="section-title">{{ trans('home.order_summary') }}</div>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover table-md">
                                                                <tr>
                                                                    <th data-width="40">#</th>
                                                                    <th>{{ trans('cart.item') }}</th>
                                                                    <th class="text-center">{{ trans('admin/main.type') }}</th>
                                                                    <th class="text-center">Số lượng</th>
                                                                    <th class="text-center">{{ trans('public.price') }}
                                                                        <br>
                                                                        <span style="font-size: 12px">(8% VAT)</span>
                                                                    </th>
                                                                    <th class="text-right">{{ trans('cart.total') }}</th>
                                                                </tr>

                                                                <tr>
                                                                    <td>{{ $webinar->id }}</td>
                                                                    <td>{{ $webinar->title }}</td>
                                                                    <td class="text-center">{{ trans('webinars.'.$webinar->type) }}</td>
                                                                    <td class="text-center">
                                                                        1
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if(!empty($sale->amount))
                                                                            {{ handlePrice($sale->amount) }}
                                                                        @else
                                                                            {{ trans('public.free') }}
                                                                        @endif
                                                                    </td>

                                                                    <td class="text-right">
                                                                        @if(!empty($sale->total_amount))
                                                                            {{ handlePrice($sale->total_amount) }}
                                                                        @else
                                                                            0
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="row mt-4">

                                                            <div class="col-lg-12 text-right">
                                                                {{--                                                                <div class="invoice-detail-item">--}}
                                                                {{--                                                                    <div class="invoice-detail-name">{{ trans('cart.sub_total') }}</div>--}}
                                                                {{--                                                                    <div class="invoice-detail-value">{{ handlePrice($sale->amount) }}</div>--}}
                                                                {{--                                                                </div>--}}
                                                                {{--                                                                <div class="invoice-detail-item">--}}
                                                                {{--                                                                    <div class="invoice-detail-name">{{ trans('cart.tax') }}--}}
                                                                {{--                                                                        ({{ getFinancialSettings('tax') }}%)--}}
                                                                {{--                                                                    </div>--}}
                                                                {{--                                                                    <div class="invoice-detail-value">--}}
                                                                {{--                                                                        @if(!empty($sale->tax))--}}
                                                                {{--                                                                            {{ handlePrice($sale->tax) }}--}}
                                                                {{--                                                                        @else--}}
                                                                {{--                                                                            ---}}
                                                                {{--                                                                        @endif--}}
                                                                {{--                                                                    </div>--}}
                                                                {{--                                                                </div>--}}
                                                                {{--                                                                <div class="invoice-detail-item">--}}
                                                                {{--                                                                    <div class="invoice-detail-name">{{ trans('public.discount') }}</div>--}}
                                                                {{--                                                                    <div class="invoice-detail-value">--}}
                                                                {{--                                                                        @if(!empty($sale->discount))--}}
                                                                {{--                                                                            {{ handlePrice($sale->discount) }}--}}
                                                                {{--                                                                        @else--}}
                                                                {{--                                                                            ---}}
                                                                {{--                                                                        @endif--}}
                                                                {{--                                                                    </div>--}}
                                                                {{--                                                                </div>--}}
                                                                <hr class="mt-2 mb-2">
                                                                <div class="invoice-detail-item">
                                                                    <div class="invoice-detail-name">{{ trans('cart.total') }}</div>
                                                                    <div class="invoice-detail-value invoice-detail-value-lg">
                                                                        @if(!empty($sale->total_amount))
                                                                            {{ handlePrice($sale->total_amount) }}
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="d-md-none d-lg-block text-md-right">
                                                <button type="button" onclick="window.print()"
                                                        class="btn btn-warning btn-icon icon-left">
                                                    <i class="fas fa-print"></i> Print
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
</body>
