<?php

namespace App\Exports;

use App\Models\AppraisalHeader;
use App\Models\AppraisalStatus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AppraisalExport implements FromCollection, WithHeadings
{
    private $statusID;

    public function __construct($statusID)
    {
        $this->statusID = $statusID;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return AppraisalHeader::where('appraisal_status_id', $this->statusID)->select(
                'appraisal_reference_number',
                'appraisal_status_id',
                'appraisee_id',
                'appraisee_man_no',
                'appraisee_name',
                'appraisee_email',
                'appraisee_mobile_number',
                'appraisee_location',
                'appraisee_functional_section',
                'appraisee_position',
                'appraisee_grade',
                'appraiser_id',
                'appraiser_man_no',
                'appraiser_name',
                'appraiser_email',
                'appraiser_mobile_number',
                'appraiser_location',
                'appraiser_functional_section',
                'appraiser_position',
                'appraiser_grade'
            )->get()->unique('appraisee_man_no');
    }

    public function headings(): array
    {
        return [
            'Appraisal Reference Number',
            'Appraisal Status ID',
            'Appraisee Id',
            'Appraisee Man Number',
            'Appraisee Name',
            'Appraisee Email',
            'Appraisee Mobile Number',
            'Appraisee Location',
            'Appraisee Functional Section',
            'Appraisee Position',
            'Appraisee Grade',
            'Appraiser ID',
            'Appraiser Man Number',
            'Appraiser Name',
            'Appraiser Email',
            'Appraiser Mobile Number',
            'Appraiser Location',
            'Appraiser Functional Section',
            'Appraiser Position',
            'Appraiser Grade'
        ];

    }
}
