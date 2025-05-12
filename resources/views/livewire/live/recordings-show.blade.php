<div class="container">

    <div class="card mb-3">

        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif
        <div class="card-header">
            <h5 class="card-title">Recording ID: {{ $recording->id }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Phone Number:</strong> {{ $recording->phone_number }}</p>
                    <p><strong>Agent:</strong> <a
                            href="{{ $recording->agent_number }}">{{ str_replace('SIP/7000/', '', $recording->agent_number) }}</a>
                    </p>
                    <p><strong>Date:</strong> {{ $recording->created_at ?? '--' }}</p>
                    <p><strong>Source:</strong> {{ $recording->src ?? '--' }}</p>
                    <p><strong>Destination:</strong> {{ $recording->dst ?? '--' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Caller ID:</strong> {{ $recording->clid ?? '--' }}</p>
                    <p><strong>Call Date:</strong> {{ $recording->calldate ?? '--' }}</p>
                    <p><strong>Answered Date:</strong> {{ $recording->answerdate ?? '--' }}</p>
                    <p><strong>Hang Up:</strong> {{ $recording->hangupdate ?? '--' }}</p>
                    <p><strong>Duration:</strong> {{ $recording->call_duration ?? '--' }}</p>
                    <p><strong>Transaction code:</strong>
                        {{ $recording->tCode->name ?? ($recording->transaction_code ?? '--') }}</p>
                </div>
            </div>
            <div class="d-inline">
                <audio controls style="vertical-align: middle" title="{{ $recording->file_name }}"
                       src="{{ url('audio', ['file' => $recording->file_name, 'extension' => 'wav']) }}"
                       type="audio/wave">
                    Your browser does not support the audio element.
                </audio>

                <!-- Download Button -->
                <br>
                <a class="btn btn-primary mt-2"
                   href="{{ url('audio', ['file' => $recording->file_name, 'extension' => 'wav']) }}"
                   download="{{ pathinfo($recording->file_name, PATHINFO_FILENAME) }}.mp3">
                    Download as MP3
                </a>
            </div>
            <div class="mt-3">
                <button class="btn btn-primary" data-toggle="modal"
                    data-target="#updateTransactionCodeModal">Edit</button>
                <button class="btn btn-success" data-toggle="modal"
                    data-target="#rateModal{{ $recording->id }}">Rate</button>
            </div>
        </div>
    </div>


    <div class="card">

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Record Id </th>
                        <th>Comment</th>
                        <th>Comment from</th>
                        <th>rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comments as $comment)
                        <tr>
                            <td>{{ $comment->recordings_id }}</td>
                            <td>{{ $comment->comment }}</td>
                            <td>{{ $comment->username }}</td>
                            <td>{{ $comment->rating }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @include('livewire.agent.transaction-code')

    <!-- Rate Modal -->
    <div wire:ignore.self class="modal fade" id="rateModal{{ $recording->id }}" tabindex="-1" role="dialog"
        aria-labelledby="rateModalLabel{{ $recording->id }}" aria-hidden="true">


        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rateModalLabel{{ $recording->id }}">Rate Recording</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (session()->has('rating'))
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('rating') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <form wire:submit.prevent="addRating">
                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <select class="form-control" id="rating" wire:model="rating" required>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea id="comment" class="form-control" wire:model="comment"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Rating</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
