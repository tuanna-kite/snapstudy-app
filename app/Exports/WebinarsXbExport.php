<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WebinarsXbExport implements FromCollection, WithHeadings, WithMapping
{
    protected $webinars;

    public function __construct($webinars)
    {
        $this->webinars = $webinars;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->webinars;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            trans('admin/main.id'),
            trans('Cộng tác viên'),
            trans('admin/pages/webinars.title'),
            trans('admin/pages/webinars.course_type'),
            trans('public.implementation_cost'),
            trans('admin/pages/webinars.price'),
            trans('admin/main.created_at'),
            trans('admin/main.status'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($webinar): array
    {
        return [
            $webinar->id,
            $webinar->assignCtv ? $webinar->assignCtv->full_name : '',
            $webinar->title,
            $webinar->type == \App\Models\Webinar::$course ? 'exam' : $webinar->type,
            $webinar->implementation_cost,
            $webinar->price,
            dateTimeFormat($webinar->created_at, 'j M Y | H:i'),
            $webinar->status,
        ];
    }
}
