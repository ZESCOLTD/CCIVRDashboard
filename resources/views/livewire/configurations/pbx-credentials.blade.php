<div class="row">
    <div class="container h-100">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createModal">Create New Record</button>

        <div class="row">
            <table class="table table-sm" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th> <!-- New Actions Column -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $item): ?>
                    <tr>
                        <td>{{ $item['config_key_id'] }}</td>
                        <td>{{ $item['config_value'] }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                wire:click="openEditModal({{ $item['id'] }})">Edit</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal" id="createModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <select required class="form-control" id="name" wire:model="newName">
                                <option value="">--Choose--</option>
                                <option value="{{ config('constants.configs.pbx_username') }}">
                                    {{ config('constants.configs.pbx_username') }} </option>>
                                <option value="{{ config('constants.configs.pbx_password') }}">
                                    {{ config('constants.configs.pbx_password') }} </option>>
                                <option value="{{ config('constants.configs.API_SERVER_ENDPOINT') }}">
                                    {{ config('constants.configs.API_SERVER_ENDPOINT') }} </option>>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Value</label>
                            <input type="email" class="form-control" id="email" wire:model="newEmail">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="createRecord">Create</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal" id="editModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" wire:model="editName">
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" wire:model="editEmail">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="updateRecord">Update</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            window.livewire.on('show-create-modal', () => {
                $('#createModal').modal('show');
            });

            window.livewire.on('show-edit-modal', () => {
                $('#editModal').modal('show');
            });

            window.livewire.on('close-modal', () => {
                $('#createModal').modal('hide');
                $('#editModal').modal('hide');
            });
        });
    </script>
</div>
