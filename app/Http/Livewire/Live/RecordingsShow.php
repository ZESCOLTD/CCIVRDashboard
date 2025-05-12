<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\RecordingComment;
use Livewire\Component;
use App\Models\Live\Recordings as LiveRecordings;
use App\Models\Live\TransactionCode as TransCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;

class RecordingsShow extends Component
{
    public $t_code;
    public $rating, $comment;
    public $record_id;

    protected $rules = [
        'rating' => 'required'
    ];

    public function mount($id)
    {
        $this->record_id = $id;
    }

    public function render()
    {
        $recording = LiveRecordings::with('comments')->where('id', $this->record_id)->first();
        $transactionCodes = TransCode::all();
        $comments = $recording->comments;
        $api = config("app.RECORDS_SERVER_ENDPOINT");

        return view('livewire.live.recordings-show', [
            'recording' => $recording,
            'api' => $api,
            'transactionCodes' => $transactionCodes,
            'comments' => $comments
        ]);
    }

    public function editTCode()
    {
        LiveRecordings::where('id', $this->record_id)
            ->update(['transaction_code' => $this->t_code]);

        $this->t_code = null;
        session()->flash('success', 'Transaction code updated successfully!');
    }

    public function addRating()
    {
        RecordingComment::create([
            'recordings_id' => $this->record_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'user_id' => Auth::user()->id,
            'username' => Auth::user()->name
        ]);

        session()->flash('rating', 'Rating added successfully!');
    }

    public function convertToMp3()
    {
        $recording = LiveRecordings::find($this->record_id);
        if (!$recording) {
            session()->flash('error', 'Recording not found.');
            return;
        }

        $fileName = $recording->file_name;
        $wavPath = storage_path("app/recordings/{$fileName}");
        $mp3Name = pathinfo($fileName, PATHINFO_FILENAME) . '.mp3';
        $mp3Path = storage_path("app/converted/{$mp3Name}");

        // Ensure converted directory exists
        if (!file_exists(dirname($mp3Path))) {
            mkdir(dirname($mp3Path), 0755, true);
        }

        if (!file_exists($wavPath)) {
            session()->flash('error', 'WAV file does not exist.');
            return;
        }

        try {
            $ffmpeg = FFMpeg::create();
            $audio = $ffmpeg->open($wavPath);
            $format = new Mp3();
            $audio->save($format, $mp3Path);

            session()->flash('success', 'MP3 conversion successful.');
        } catch (\Exception $e) {
            session()->flash('error', 'Conversion failed: ' . $e->getMessage());
        }
    }
}
