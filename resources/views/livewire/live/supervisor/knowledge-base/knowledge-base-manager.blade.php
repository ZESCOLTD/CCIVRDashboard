<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0" style="color: #0f974b; font-weight: 600;">
                    <i class="fas fa-book mr-2" style="color: #f49e38;"></i>
                    Knowledge Base
                </h1>
                <button wire:click="startCreating" class="btn btn-success">
                    <i class="fas fa-plus mr-2"></i>Add New
                </button>
            </div>
            <hr style="border-top: 3px solid #f49e38; opacity: 0.7;">
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Knowledge Base List -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #0f974b; color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-list mr-2"></i>
                        Knowledge Items
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($knowledgeBases as $item)
                            <a wire:click="show({{ $item->id }})"
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center
                                      {{ $currentItem && $currentItem->id === $item->id ? 'active' : '' }}">
                                <span>{{ $item->topic }}</span>
                                <small class="text-muted">{{ $item->last_updated->diffForHumans() }}</small>
                            </a>
                        @empty
                            <div class="list-group-item text-center text-muted py-4">
                                No knowledge base items found
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Knowledge Base Detail/Form -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center"
                     style="background-color: #0f974b; color: white;">
                    <h5 class="mb-0">
                        <i class="fas {{ $isEditing ? 'fa-edit' : 'fa-plus-circle' }} mr-2"></i>
                        {{ $isEditing ? 'Edit Knowledge Item' : 'Create New Knowledge Item' }}
                    </h5>
                    @if($isEditing && $currentItem)
                        <button wire:click="delete({{ $currentItem->id }})"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this item?')">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    @if($isEditing || !$isEditing)
                        <form wire:submit.prevent="{{ $isEditing ? 'updateItem' : 'store' }}">
                            <div class="form-group">
                                <label for="topic" style="color: #0f974b;">Topic</label>
                                <input type="text" wire:model="topic" id="topic"
                                       class="form-control @error('topic') is-invalid @enderror"
                                       placeholder="Enter topic...">
                                @error('topic') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="description" style="color: #0f974b;">Description</label>
                                <textarea wire:model="description" id="description" rows="10"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Enter detailed description..."></textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" wire:click="cancel"
                                        class="btn btn-outline-secondary mr-2">
                                    <i class="fas fa-times mr-1"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i>
                                    {{ $isEditing ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-3x mb-3" style="color: #f49e38;"></i>
                            <h4>Select an item to view or edit</h4>
                            <p class="text-muted">Or click "Add New" to create a knowledge base entry</p>
                        </div>
                    @endif
                </div>
                @if($currentItem)
                    <div class="card-footer text-muted">
                        Last updated: {{ $currentItem->last_updated->format('M d, Y H:i') }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>