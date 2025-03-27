<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Session Details</h5>
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
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <p class="form-control-plaintext text-muted">{{ $session->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Time from:</label>
                        <p class="form-control-plaintext text-muted">{{ $session->time_from }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Description:</label>
                        <p class="form-control-plaintext text-muted">{{ $session->description }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Time to:</label>
                        <p class="form-control-plaintext text-muted">{{ $session->time_to }}</p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button data-toggle="modal" data-target="#updateModal" class="btn btn-info mr-3">Edit</button>
                <button wire:click.prevent="remove()" onclick="deleteCallSession('{{ $session->id }}')"
                    class="btn btn-danger">Remove</button>
            </div>
        </div>
    </div>

    @include('livewire.session.edit')


    <script>
        function deleteCallSession(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteCallSession', id);
        }

        document.addEventListener('livewire:load', function() {
            @this.on('closeModal', () => {
                $('#updateModal').modal('hide');
            });
        });
    </script>
</div>
