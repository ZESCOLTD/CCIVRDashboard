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
                    <input type="hidden" wire:model="config_destination_id">
                    <div class="form-group mb-3">
                        <label for="context">Context:</label>
                        <select class="form-control @error('context') is-invalid @enderror" id="context" required
                                wire:model="context">
                            <option>--Choose--</option>
                            @foreach($contexts as $context)
                                <option value="{{$context->id}}"> {{$context->context}} </option>
                            @endforeach
                        </select>
                        @error('context') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="destination">Destination:</label>
                        <input type="text" class="form-control @error('destination') is-invalid @enderror"
                               id="destination" placeholder="Enter Destination" wire:model="destination">
                        @error('destination') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Description:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                  wire:model="description" placeholder="Enter Description"></textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="option">Option:</label>
                        <input type="text" class="form-control @error('option') is-invalid @enderror"
                               id="option" placeholder="Enter Destination" wire:model="option">
                        @error('destination') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>


                </div>
                <div class="modal-footer">
                    <div class="d-grid gap-2">
                        <button wire:click.prevent="store()" class="btn btn-success btn-block">Save</button>
                        <button wire:click.prevent="cancel()" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
