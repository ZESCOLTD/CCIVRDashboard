<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create Transaction Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>×</span>
                </button>
            </div>

            <form>
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="number" class="form-control" id="code" name="code" required wire:model.defer="code">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required wire:model.defer="name">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required wire:model.defer="description">
                    </div>
                </div>
                
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" wire:click.prevent="store()" class="btn btn-primary ml-2">
                        Add Transaction Code
                        <span wire:loading wire:target="store" class="spinner-border spinner-border-sm ml-2" role="status" aria-hidden="true"></span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
