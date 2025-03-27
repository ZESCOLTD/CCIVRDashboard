<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Transaction code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>×</span>
                </button>
            </div>

            <form>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" wire:model="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="description" placeholder="Enter Description" wire:model="description">
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="code">Code:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="code" placeholder="Enter Code" wire:model="code">
                        @error('context')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button wire:click.prevent="update()" class="btn btn-success">
                        <span wire:loading wire:target="update" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Save
                    </button>
                    <button wire:click.prevent="cancel()" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
