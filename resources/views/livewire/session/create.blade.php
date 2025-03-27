<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Create Sessions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>×</span>
                </button>
            </div>

            <form>

                <div class="modal-body">
                    <input type="hidden" wire:model="config_context_id">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label for="context">Name:</label>
                                <input type="text" class="form-control @error('context') is-invalid @enderror"
                                    id="context" placeholder="Enter session name ..." wire:model.defer="name"
                                    {{-- value="{{ $session->name }}" --}}>
                                @error('context')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="context">Time from:</label>
                                <input type="time" class="form-control @error('context') is-invalid @enderror"
                                    wire:model.defer="time_from" id="context" placeholder="Enter Time from "
                                    {{-- value="{{ $session->time_from }}" --}}>
                                @error('context')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label for="context">Description:</label>
                                <input type="text" class="form-control @error('context') is-invalid @enderror"
                                    wire:model.defer="description" id="context"
                                    placeholder="Enter session description ..." {{-- value="{{ $session->description }}" --}}>
                                @error('context')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="context">Time to:</label>
                                <input type="time" class="form-control @error('context') is-invalid @enderror"
                                    wire:model.defer="time_to" id="context" placeholder="Enter Context"
                                    {{-- value="{{ $session->time_to }}" --}}>
                                @error('context')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>




                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 d-flex justify-content-between">
                            <!-- Save Button -->
                            <button wire:click.prevent="store()" class="btn btn-info">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
