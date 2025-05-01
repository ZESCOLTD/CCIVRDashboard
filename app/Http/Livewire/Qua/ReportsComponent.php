<?php

namespace App\Http\Livewire\Qua;

use Livewire\Component;
use App\Models\Live\Recordings;
use Carbon\Carbon;

class ReportsComponent extends Component
{
    public $filters = [
        'from' => null,
        'to' => null,
        'src' => '',
        'dst' => '',
        'clid' => '',
        'duration_min' => null,
        'duration_max' => null,
        'userfield' => '',
        'group_by' => '',
        'export_csv' => false,
        'export_graph' => false,
        'limit' => 100,
    ];

    public $records = [];

    public function search()
    {
        $query = Recordings::query();

        // Check the filters
        // dd($this->filters);

        if ($this->filters['from']) {
            $query->where('calldate', '>=', Carbon::parse($this->filters['from']));
        }

        if ($this->filters['to']) {
            $query->where('calldate', '<=', Carbon::parse($this->filters['to']));
        }

        if ($this->filters['src']) {
            $query->where('src', 'like', '%' . $this->filters['src'] . '%');
        }

        if ($this->filters['dst']) {
            $query->where('dst', 'like', '%' . $this->filters['dst'] . '%');
        }

        if ($this->filters['clid']) {
            $query->where('clid', 'like', '%' . $this->filters['clid'] . '%');
        }

        if ($this->filters['duration_min']) {
            $query->where('duration', '>=', $this->filters['duration_min']);
        }

        if ($this->filters['duration_max']) {
            $query->where('duration', '<=', $this->filters['duration_max']);
        }

        if ($this->filters['userfield']) {
            $query->where('userfield', 'like', '%' . $this->filters['userfield'] . '%');
        }

        // Remove limit temporarily to check if it returns data
        $this->records = $query->orderBy('calldate', 'desc')->get();

        // Debugging output
        // dd($this->records);
    }

    public function render()
    {
           return view('livewire.qua.reports-component', [
            'records' => $this->records
        ]);
    }
}
