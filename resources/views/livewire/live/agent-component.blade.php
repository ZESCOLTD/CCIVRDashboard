<div>
    <button class="btn btn-primary mb-3" wire:click="$emit('openSessionModal')">Open Modal</button>

    <!-- Modal -->
    <!-- Session Selection Modal -->
<div class="modal fade" id="sessionModal" tabindex="-1" role="dialog"
aria-labelledby="sessionModalLabel" aria-hidden="true" data-backdrop="static"
data-keyboard="false" wire:ignore.self>
selected {{ $selectedSession }}
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="sessionModalLabel">Select Session</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <select class="form-control" wire:model="selectedSession" wire:change="changeSession">
                <option value="">Select Session</option>
                @foreach ($sessions as $session)
                    <option value="{{ $session->id }}">{{ $session->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="modal-footer">
            @if ($selectedSession == null)
                <button type="button" class="btn btn-primary disabled" wire:click="saveSession">Save
                    changes ...</button>
            @else
                <button type="button" class="btn btn-primary" wire:click="saveSession"
                    data-dismiss="modal">
                    Save changes
                </button>
            @endif
        </div>
    </div>
</div>
</div>

</div>

@push('custom-scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            console.log('[Livewire] livewire:load fired ✅');

            const selected = @json($selectedSession);
            if (!selected) {
                const modal = new bootstrap.Modal(document.getElementById('sessionModal'));

                modal.show();

            }
        });



        document.addEventListener('openSessionModal', () => {
            const modal = new bootstrap.Modal(document.getElementById('sessionModal'));
            modal.show();
        });

        document.addEventListener('closeSessionModal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('sessionModal'));
            if (modal) modal.hide();
        });
    </script>
@endpush
