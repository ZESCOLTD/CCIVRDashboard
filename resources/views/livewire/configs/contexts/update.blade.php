<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Contexts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>×</span>
                </button>
            </div>

<form>

    <div class="modal-body">
    <input type="hidden" wire:model="config_context_id">
    <div class="form-group mb-3">
        <label for="context">Context:</label>
        <input type="text" class="form-control @error('context') is-invalid @enderror" id="context" placeholder="Enter Context" wire:model="context">
        @error('context') <span class="text-danger">{{ $message }}</span>@enderror
    </div>


    </div>
    <div class="modal-footer">
    <div class="d-grid gap-2">
        <button wire:click.prevent="update()" class="btn btn-success btn-block">Save</button>
        <button wire:click.prevent="cancel()" class="btn btn-danger">Cancel</button>
    </div>
    </div>
</form>
        </div>
    </div>
</div>
