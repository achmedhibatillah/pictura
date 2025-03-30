<div class="row m-0 p-0">
    <div class="col-md-8 m-0 p-0">
        <div class="card mb-2 m-0 p-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle overflow-hidden cursor-pointer flex-shrink-0" style="height:70px;width:70px;">
                    <img src="{{ asset('assets/img/icons/blank-profile.png') }}" class="img-cover img-hover">
                </div>
                <div class="ms-4">
                    <h5 class="m-0 mb-1 fw-bold text-clr1"><i class="font-rounded fst-normal me-1">@</i>{{ $user['user_username'] }}</h5>
                    <p class="m-0 mb-1">{{ $user['user_fullname'] }}</p>
                    <p class="m-0 fsz-11 text-secondary">{{ $user['user_desc'] }}</p>
                    @if($ismyprofile == false)
                        <form action="{{ url('req/connect') }}" method="post" class="mt-2">
                            @csrf
                            <input type="hidden" name="user_id_dst" value="{{ $user['user_id'] }}">
                            <button type="submit" class="btn btn-sm btn-clr1 rounded-s px-3 lh-1 fsz-11">Connect</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="card mb-2 m-0 p-0 py-2">
            <div class="row m-0 p-0">
                <div class="col-4 m-0 p-0 text-center px-2">
                    <p class="m-0 fsz-12">11</p>
                    <p class="m-0 fsz-11 text-secondary">Posts</p>
                </div>
                <div class="col-4 m-0 p-0 text-center px-2">
                    <p class="m-0 fsz-12">39</p>
                    <p class="m-0 fsz-11 text-secondary">Connected</p>
                </div>
                <div class="col-4 m-0 p-0 text-center px-2">
                    <p class="m-0 fsz-12">21</p>
                    <p class="m-0 fsz-11 text-secondary">Connecting</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 m-0 p-0 ps-2">
        <div class="card mb-2 m-0 cursor-pointer bg-clr4 hover d-flex align-items-center justify-content-center he-50" onclick="window.location.href='<?= url('edit-profile') ?>'">
            <p class="text-clr1 fsz-12 m-0 lh-1 text-center">Edit my profile<i class="fa-solid fa-user-pen ms-1"></i></p>
        </div>
        <div class="card mb-2 m-0 cursor-pointer bg-clr4 hover d-flex align-items-center justify-content-center he-50" onclick="window.location.href='<?= url('edit-profile') ?>'">
            <p class="text-clr1 fsz-12 m-0 lh-1 text-center">New Post<img src="{{ asset('assets/img/icons/post.png') }}" class="he-22 ms-1"></p>
        </div>
    </div>
</div>