<tr class="text-left">
    <th class="pl-6 py-4">
        <p class="font-semibold text-sm text-primary.main">
            @if($accounting->is_cashback)
                {{-- {{ trans('update.cashback') }} --}}
            @elseif(!empty($accounting->webinar_id) and !empty($accounting->webinar))
                {{ $accounting->webinar->title }}
            @elseif(!empty($accounting->bundle_id) and !empty($accounting->bundle))
                {{ $accounting->bundle->title }}
            @elseif(!empty($accounting->product_id) and !empty($accounting->product))
                {{ $accounting->product->title }}
            @elseif(!empty($accounting->meeting_time_id))
                {{ trans('meeting.reservation_appointment') }}
            @elseif(!empty($accounting->subscribe_id) and !empty($accounting->subscribe))
                {{ $accounting->subscribe->title }}
            @elseif(!empty($accounting->promotion_id) and !empty($accounting->promotion))
                {{ $accounting->promotion->title }}
            @elseif(!empty($accounting->registration_package_id) and !empty($accounting->registrationPackage))
                {{ $accounting->registrationPackage->title }}
            @elseif(!empty($accounting->installment_payment_id))
                {{ trans('update.installment') }}
            @elseif($accounting->store_type == \App\Models\Accounting::$storeManual)
                {{ trans('financial.manual_document') }}
            @elseif($accounting->type == \App\Models\Accounting::$addiction and $accounting->type_account == \App\Models\Accounting::$asset)
                {{ trans('financial.charge_account') }}
            @elseif($accounting->type == \App\Models\Accounting::$deduction and $accounting->type_account == \App\Models\Accounting::$income)
                {{ trans('financial.payout') }}
            @elseif($accounting->is_registration_bonus)
                {{ trans('update.registration_bonus') }}
            @else
                ---
            @endif
        </p>
        <p class="font-normal text-sm text-text.light.secondary">
            @if(!empty($accounting->webinar_id) and !empty($accounting->webinar))
                #{{ $accounting->webinar->id }}{{ ($accounting->is_cashback) ? '-'.$accounting->webinar->title : '' }}
            @elseif(!empty($accounting->bundle_id) and !empty($accounting->bundle))
                #{{ $accounting->bundle->id }}{{ ($accounting->is_cashback) ? '-'.$accounting->bundle->title : '' }}
            @elseif(!empty($accounting->product_id) and !empty($accounting->product))
                #{{ $accounting->product->id }}{{ ($accounting->is_cashback) ? '-'.$accounting->product->title : '' }}
            @elseif(!empty($accounting->meeting_time_id) and !empty($accounting->meetingTime))
                {{ $accounting->meetingTime->meeting->creator->full_name }}
            @elseif(!empty($accounting->subscribe_id) and !empty($accounting->subscribe))
                {{ $accounting->subscribe->id }}{{ ($accounting->is_cashback) ? '-'.$accounting->subscribe->title : '' }}
            @elseif(!empty($accounting->promotion_id) and !empty($accounting->promotion))
                {{ $accounting->promotion->id }}{{ ($accounting->is_cashback) ? '-'.$accounting->promotion->title : '' }}
            @elseif(!empty($accounting->registration_package_id) and !empty($accounting->registrationPackage))
                {{ $accounting->registrationPackage->id }}{{ ($accounting->is_cashback) ? '-'.$accounting->registrationPackage->title : '' }}
            @elseif(!empty($accounting->installment_payment_id))
                @php
                    $installmentItemTitle = "--";
                    $installmentOrderPayment = $accounting->installmentOrderPayment;

                    if (!empty($installmentOrderPayment)) {
                        $installmentOrder = $installmentOrderPayment->installmentOrder;
                        if (!empty($installmentOrder)) {
                            $installmentItem = $installmentOrder->getItem();
                            if (!empty($installmentItem)) {
                                $installmentItemTitle = $installmentItem->title;
                            }
                        }
                    }
                @endphp
                {{ $installmentItemTitle }}
            @else
                ---
            @endif
        </p>
    </th>
    <th class="">
        <span class="font-normal text-sm text-text.light.primary">
            {{ $accounting->description }}
        </span>
    </th>
    <th class="">
        <span class="font-normal text-sm text-text.light.primary">
            {{ trans('public.'.$accounting->store_type) }}
        </span>
    </th>
    <th class="">
        <span class="font-normal text-sm text-text.light.primary">
            {{ dateTimeFormat($accounting->created_at, 'j M Y') }}
        </span>
    </th>
    <th class="">
        @switch($accounting->type)
            @case(\App\Models\Accounting::$addiction)
                <span class="font-semibold text-base text-primary.main">+{{ handlePrice($accounting->amount, false) }}</span>
                @break;
            @case(\App\Models\Accounting::$deduction)
                <span class="font-semibold text-base text-secondary.main">-{{ handlePrice($accounting->amount, false) }}</span>
                @break;
        @endswitch
    </th>
</tr>
