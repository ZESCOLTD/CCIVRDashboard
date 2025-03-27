<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Update Contexts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>×</span>
                </button>
            </div>

            <form>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Man No.</label>
                                <input class="form-control text-muted" wire:model="agent_man_no">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Name:</label>
                                <input class="form-control text-muted" wire:model.defer="agent_name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Agent number:</label>
                                <input class="form-control text-muted" wire:model.defer="agent_endpoint">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Set number:</label>
                                <input class="form-control text-muted" wire:model.defer="agent_set_number">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">State</label>
                                <input class="form-control text-muted" wire:model.defer="agent_state">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <input class="form-control text-muted" wire:model.defer="agent_status">
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="d-grid gap-2">
                        <button wire:click.prevent="create()" class="btn btn-success btn-block">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
