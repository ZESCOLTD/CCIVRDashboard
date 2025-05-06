<!-- Modal -->
<div wire:ignore.self class="modal fade" id="oneTimePasswordModal" tabindex="-1" role="dialog"
     aria-labelledby="otpModelText"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otpModelText">One Time Password</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span>×</span>
                </button>
            </div>

            <div>
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card card-body">
                    <form wire:submit.prevent="oneTimePassword({{$user->id}})">
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="text" wire:model="one_time_password" class="form-control" id="one_time_password" >
                        </div>

                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
