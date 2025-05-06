<!-- Update Inverter Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Knowledge Base Management Portal</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <form wire:submit.prevent="update">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="topic">Make <span class="text-danger">*</span></label>
                        <input type="text" id="topic" class="form-control @error('topic') is-invalid @enderror" placeholder="Enter Topic" wire:model.defer="topic">
                        @error('topic') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea id="description" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description" wire:model.defer="description"></textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                </div>

                <div class="modal-footer">
                    <div wire:loading wire:target="update" class="text-success me-auto">
                        Updating... <span class="spinner-border spinner-border-sm"></span>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
