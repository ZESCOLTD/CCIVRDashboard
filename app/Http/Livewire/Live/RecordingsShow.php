<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\RecordingComment;
use Livewire\Component;
use App\Models\Live\Recordings as LiveRecordings;
use App\Models\Live\TransactionCode as TransCode;
use Illuminate\Support\Facades\Auth;

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
        //dd($id);
    }
    public function render()
    {
        $recording = LiveRecordings::with('comments')->where('id', '=', $this->record_id)->first();
        $transactionCodes = TransCode::all();
        $comments = $recording->comments;
        $api = config("app.RECORDS_SERVER_ENDPOINT");

        return view('livewire.live.recordings-show', ['recording' => $recording, 'api' => $api, 'transactionCodes' => $transactionCodes, 'comments' => $comments]);
    }


    public function editTCode()
    {
        LiveRecordings::where('id',  $this->record_id)
            ->update(['transaction_code' => $this->t_code]);
        $this->t_code = null;
        session()->flash('success', 'Transaction code updated successfully!');
    }

    public function addRating()
    {
        RecordingComment::create(['recordings_id' => $this->record_id, 'rating' => $this->rating, 'comment' => $this->comment, 'user_id' => Auth::user()->id, 'username' => Auth::user()->name]);
        session()->flash('rating', 'Rating added successfully!');
    }
}
