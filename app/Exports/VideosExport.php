<?php

namespace App\Exports;

use App\Models\Videos;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VideosExport implements FromCollection, WithHeadings
{
    protected $videos;

    public function __construct($videos)
    {
        $this->videos = $videos;
    }

    public function collection()
    {
        return $this->videos;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Video Id',
            'Status',
            'From Agent',
            'From Email',
            'From Phone',
            'Video Link',
        ];
    }
}