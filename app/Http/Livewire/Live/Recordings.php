<?php

namespace App\Http\Livewire\Live;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Live\Recordings as LiveRecordings;

class Recordings extends Component
{
    public $recording;
    public $from;
    public $to;
    public $search;

    public function render()
    {
        $fromDatetime = $this->from ? Carbon::parse($this->from) : null;
        $toDatetime = $this->to ? Carbon::parse($this->to) : null;

        $query = LiveRecordings::with('agent')->orderBy('created_at', 'DESC');

        if ($fromDatetime && $toDatetime) {
            $query->whereBetween('created_at', [$fromDatetime, $toDatetime]);
        } else {
            $query->whereDate('created_at', Carbon::today());
        }

        if ($this->search) {
            $search = strtolower($this->search);
            $query->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(phone_number) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(clid) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(dst) like ?', ['%' . $search . '%'])
                    ->orWhereHas('agent', function ($query) use ($search) {
                        $query->whereRaw('LOWER(name) like ?', ['%' . $search . '%']);
                    });
            });
        }

        $recordings = $query->paginate(10);
        $sumTotal = $recordings->total();
        $api = config("app.RECORDS_SERVER_ENDPOINT");

        return view('livewire.live.recordings2', [
            'recordings' => $recordings,
            'sumTotal' => $sumTotal,
            'api' => $api
        ]);
    }


    public function store(Request $request): array
    {
        $record = LiveRecordings::create($request->only([
            'agent_number',
            'phone_number',
            'duration_number',
            'file_name',
            'file_path',
            'src',
            'dst',
            'clid',
            'calldate',
            'answerdate',
            'hangupdate',
            'duration',
            'billsec',
            'disposition'
        ]));

        return ['recording' => $record];
    }

    public function download(int $recordingId)
    {
        $this->recording = LiveRecordings::findOrFail($recordingId);
        $filePath = storage_path("app/public/{$this->recording->file_path}.wav");

        return response()->download($filePath, "{$this->recording->file_name}.wav");
    }

    public function embedAudio(Request $request)
    {
        $filePath = storage_path("app/public/{$this->recording->file_path}.wav");

        return response()->file($filePath);
    }

    // public function updatedSearch()
    // {
    //     $search = strtolower($this->search);

    //     $this->recordings = LiveRecordings::whereRaw('LOWER(phone_number) like ?', ['%' . $search . '%'])
    //         ->orWhereRaw('LOWER(clid) like ?', ['%' . $search . '%'])
    //         ->orWhereRaw('LOWER(dst) like ?', ['%' . $search . '%'])
    //         ->orWhereHas('agent', function ($query) use ($search) {
    //             $query->whereRaw('LOWER(name) like ?', ['%' . $search . '%']);
    //         })
    //         ->paginate(10);
    // }
}
