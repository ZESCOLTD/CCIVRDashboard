<div>
    <h2>Change Password</h2>



    <div class="row">
        <div class="col-md-6">
    <div class="card card-body">

        <form wire:submit.prevent="changePassword">
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" wire:model="password" class="form-control" id="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" wire:model="confirm_password" class="form-control" id="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>

    </div>
        </div>


        <div class="col-md-6">


            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible">
                    <p class="lead"> {{ session()->get('success') }}</p>
                </div>
            @endif
            @if (session()->has('info'))
                <div class="alert alert-info alert-dismissible">
                    <p class="lead"> {{ session()->get('info') }}</p>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-warning alert-dismissible">
                    <p class="lead"> {{ session()->get('error') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card card-body">
                <span>Your password should include uppercase, lowercase letters, special characters, and numbers.</span>
            </div>
        </div>

    </div>

</div>
