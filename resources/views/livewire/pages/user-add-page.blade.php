<div class="container">
    <div class="row ">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Man Number</label>
                            <input type="text" class="form-control" wire:model.defer="man_number">
                            @error('man_number')
                            <div class="alert alert-danger m-2">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">First Name</label>
                                <input type="text" class="form-control" wire:model.defer="firstname">
                                @error('firstname')
                                <div class="alert alert-danger m-2">{{ $message }}</span> @enderror

                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Last Name</label>
                                    <input type="text" class="form-control" wire:model.defer="lastname">
                                    @error('lastname')
                                    <div class="alert alert-danger m-2">{{ $message }}</span> @enderror

                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">E-mail Address</label>
                                        <input type="email" class="form-control" wire:model.defer="email">
                                        @error('email')
                                        <div class="alert alert-danger m-2">{{ $message }}</span> @enderror

                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Password</label>
                                            <input type="password" class="form-control"
                                                   wire:model.defer="password">
                                            @error('password')
                                            <div class="alert alert-danger m-2">{{ $message }}</span> @enderror

                                            </div>


                                            <button class="btn btn-primary" type="submit">Add User</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
