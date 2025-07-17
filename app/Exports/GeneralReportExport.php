<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection; // or FromArray
use Maatwebsite\Excel\Concerns\WithHeadings; // Often useful for headers

class GeneralReportExport implements FromCollection, WithHeadings // or FromArray
{
    protected $data;
    protected $title;

    public function __construct(array $data, string $title)
    {
        $this->data = $data;
        $this->title = $title;
    }

    public function collection()
    {
        // If reportData is already an array of arrays, return it directly
        return collect($this->data);
    }

    public function headings(): array
    {
        // Define your column headers based on the keys in your reportData
        // For 'Overall Queue Performance', this might look like:
        if (!empty($this->data)) {
            return array_keys($this->data[0]);
        }
        return [];
    }
    // You might also need a map() method if your data needs transformation
    // public function map($row): array
    // {
    //     return [
    //         $row['label'],
    //         $row['total_calls'],
    //         $row['answered'],
    //         // ... and so on for all fields you want to export
    //     ];
    // }
}