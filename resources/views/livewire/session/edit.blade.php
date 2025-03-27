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



            <form wire:submit.prevent="edit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name:</label>
                                <input type="text" class="form-control text-muted" value="{{ $session->name }}"
                                    wire:model.defer="name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Time from:</label>
                                <input type="text" type="text" class="form-control text-muted"
                                    value="{{ $session->time_from }}" wire:model.defer="time_from">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Description:</label>
                                <input type="text" class="form-control text-muted"
                                    value="{{ $session->description }}" wire:model.defer="description">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Time to:</label>
                                <input type="text" type="text" class="form-control text-muted"
                                    value="{{ $session->time_to }}" wire:model.defer="time_to">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
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
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 d-flex justify-content-between">
                            <!-- Save Button with Spinner -->
                            <button type="submit" class="btn btn-info m-2">
                                <span wire:loading wire:target="edit" class="spinner-border spinner-border-sm"
                                    role="status" aria-hidden="true"></span>
                                Save
                            </button>

                            <!-- Cancel Button -->
                            <button data-dismiss="modal" class="btn btn-default m-2">Cancel</button>
                        </div>
                    </div>




                </div>
            </form>
        </div>
    </div>
</div>
