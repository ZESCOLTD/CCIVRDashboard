<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <a href="{{route('users.create')}}" class="btn btn-outline-primary">Add</a>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <livewire:users.user-list/>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">


            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                       aria-controls="home" aria-selected="true">Details</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                       aria-controls="profile" aria-selected="false">Tokens</a>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <livewire:users.user-show/>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <livewire:users.token-index/>
                </div>
            </div>

        </div>

    </div>

</div>
