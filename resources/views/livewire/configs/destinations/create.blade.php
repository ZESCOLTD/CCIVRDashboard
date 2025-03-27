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
                    <div class="form-group mb-3">
                        <label for="context">Context:</label>
                        <select class="form-control @error('context') is-invalid @enderror" id="context" required
                                wire:model="context">
                            <option>--Choose--</option>
                            @foreach($contexts as $context)
                                <option value="{{$context->id}}"> {{$context->context}} </option>
                            @endforeach
                        </select>


                        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="destination">Destination:</label>
                        <input type="text" class="form-control @error('destination') is-invalid @enderror"
                               id="destination" placeholder="Enter Name" wire:model="destination">
                        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="option">Option:</label>
                        <input type="text" class="form-control @error('option') is-invalid @enderror"
                               id="option" placeholder="Enter Option" wire:model="option">
                        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>


                </div>
                <div class="modal-footer">
                    <div class="d-grid gap-2">
                        <button wire:click.prevent="store()" class="btn btn-success btn-block">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
