<!-- Create Inverter Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create Knowledge Base Management</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            {{-- Flash Messages --}}
            @if (session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form wire:submit.prevent="store">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="topic">Topic <span class="text-danger">*</span></label>
                        <input type="text" id="topic" class="form-control @error('topic') is-invalid @enderror" placeholder="Enter Topic" wire:model.defer="topic">
                        @error('topic') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Enter Description" wire:model.defer="description" rows="4"></textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                </div>

                <div class="modal-footer">
                    <div wire:loading wire:target="store" class="text-success">
                        Saving... <span class="spinner-border spinner-border-sm"></span>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
