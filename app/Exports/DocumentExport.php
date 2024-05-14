<?php

namespace App\Exports;

use App\Models\Accounting;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DocumentExport implements FromCollection, WithHeadings, WithMapping
{
    protected $documents;

    public function __construct($documents)
    {
        $this->documents = $documents;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->documents;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            trans('admin/main.title'),
            trans('admin/main.user'),
            trans('admin/main.email'),
            trans('admin/main.amount'),
            trans('admin/main.type'),
            trans('admin/main.creator'),
            trans('public.type_account'),
            trans('public.date_time'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($documents): array
    {
        if (!empty($documents->webinar_id)) {
            $title = trans('update.product_purchased') . '-' . $documents->webinar_id . (!empty($documents->webinar) ? $documents->webinar->title : '');
        } elseif (!empty($documents->bundle_id)) {
            $title = trans('update.product_purchased') . '-' . $documents->product_id . (!empty($documents->bundle) ? $documents->bundle->title : '');
        } elseif (!empty($documents->product_id)) {
            $title = trans('update.product_purchased') . '-' . $documents->product_id . (!empty($documents->product) ? $documents->product->title : '');
        } elseif (!empty($documents->meeting_time_id)){
            $title = trans('update.meeting');
        } elseif (!empty($documents->subscribe_id)){
            $title = trans('update.purchased_subscribe');
        } elseif (!empty($documents->promotion_id)){
            $title = trans('update.purchased_promotion');
        } elseif (!empty($documents->registration_package_id)) {
            $title = trans('update.purchased_registration_package');
        } elseif ($documents->store_type == Accounting::$storeManual) {
            $title = trans('admin/main.manual_document');
        } else {
            $title =  $documents->is_cashback ? $documents->description : trans('admin/main.automatic_document');
        }

        switch ($documents->type){
            case Accounting::$addiction:
                $type = trans('admin/main.addiction');
                break;
            case Accounting::$deduction:
                $type = trans('admin/main.deduction');
                break;
            default:
                $type = '';
        }

        $creator = $documents->creator_id ?  trans('admin/main.admin') : trans('admin/main.automatic');

        return [
            $title,
            $documents->user->full_name,
            $documents->user->email,
            handlePrice($documents->amount),
            $type,
            $creator,
            trans('admin/main.'.$documents->type_account),
            dateTimeFormat($documents->created_at, 'j M Y H:i'),
        ];
    }
}
