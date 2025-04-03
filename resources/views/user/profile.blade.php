<div class="row m-0 p-0">
    <div class="col-md-8 m-0 p-0">
        <div class="card mb-2 m-0 p-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle overflow-hidden flex-shrink-0" style="height:70px;width:70px;">
                    @if($user['user_photo'] !== null)
                        <img src="{{ asset($user['user_photo']) }}" class="img-cover img-death">
                    @else
                        <img src="{{ asset('assets/img/icons/blank-profile.png') }}" class="img-cover img-death">
                    @endif
                </div>
                <div class="ms-4">
                    <h5 class="m-0 mb-1 fw-bold text-clr1"><i class="font-rounded fst-normal me-1">@</i>{{ $user['user_username'] }}</h5>
                    <p class="m-0 mb-1">{{ $user['user_fullname'] }}</p>
                    <p class="m-0 fsz-11 text-secondary">{{ $user['user_desc'] }}</p>
                    @if($ismyprofile == false)
                        @if($connect['src'] == true)
                            <form action="{{ url('req/disconnect') }}" method="post" class="mt-2">
                                @csrf
                                <input type="hidden" name="user_id_dst" value="{{ $user['user_id'] }}">
                                <button type="submit" class="btn btn-sm btn-outline-clr1 rounded-s px-3 lh-1 fsz-11">Disconnect</button>
                            </form>
                        @else
                            <form action="{{ url('req/connect') }}" method="post" class="mt-2">
                                @csrf
                                <input type="hidden" name="user_id_dst" value="{{ $user['user_id'] }}">
                                <button type="submit" class="btn btn-sm btn-clr1 rounded-s px-3 lh-1 fsz-11">Connect</button>
                            </form>
                        @endif
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
                <div class="col-4 m-0 p-0 text-center px-2 d-flex justify-content-center">
                    <div class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#modalConnected">
                        <p class="m-0 fsz-12">{{ $connect_data['connected']['count'] }}</p>
                        <p class="m-0 fsz-11 text-secondary">Connected</p>
                    </div>
                </div>
                <div class="col-4 m-0 p-0 text-center px-2 d-flex justify-content-center">
                    <div class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#modalConnecting">
                        <p class="m-0 fsz-12">{{ $connect_data['connecting']['count'] }}</p>
                        <p class="m-0 fsz-11 text-secondary">Connecting</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 m-0 p-0 ps-0 ps-md-2"> 
        @if($ismyprofile == true)
        <div class="card m-0 px-3 py-2">
            <div class="d-flex mt-2 mb-2 text-clr1 fw-bold">Action</div>
            <div class="m-0 cursor-pointer bg-clrw hover d-flex align-items-center he-40" onclick="window.location.href='<?= url('edit-profile') ?>'">
                <div class="we-40 d-flex justify-content-center"><i class="fa-solid fa-user-pen text-clr1 fsz-11"></i></div>
                <p class="text-clr1 fsz-12 m-0 lh-1 text-start">Edit my profile</p>
            </div>
            <hr class="m-0">
            <div class="m-0 cursor-pointer bg-clrw hover d-flex align-items-center he-40" onclick="window.location.href='<?= url('new-post') ?>'">
                <div class="we-40 d-flex justify-content-center"><img src="{{ asset('assets/img/icons/post.png') }}" class="he-22 img-death"></div>
                <p class="text-clr1 fsz-12 m-0 lh-1 text-start">New post and my draft</p>
            </div>
            <hr class="m-0">
            <div class="m-0 text-danger cursor-pointer bg-clrw hover d-flex align-items-center he-40" onclick="window.location.href='<?= url('new-post') ?>'">
                <div class="we-40 d-flex justify-content-center"><i class="fas fa-sign-out-alt"></i></div>
                <p class="fsz-12 m-0 lh-1 text-start">Logout</p>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalConnected" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-light rounded-m">
            <div class="modal-header bg-clr2 text-light">
                <h4 class="modal-title fw-bold">Connected</h4>
                <button type="button" class="ms-auto hover bg-clr2 border-light text-light rounded-circle he-28 we-28" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <div class="w-100">
                    @if(!empty($connect_data['connected']['users']))
                        @foreach($connect_data['connected']['users'] as $x)
                            <div class="d-flex align-items-center m-0 px-2 py-3 bg-clrw hover cursor-pointer" onclick="window.location.href='<?= url('usr/' . $x->user_username) ?>'">
                                <div class="rounded-circle overflow-hidden flex-shrink-0" style="height:30px;width:30px;">
                                    @if($x->user_photo !== null)
                                        <img src="{{ asset($x->user_photo) }}" class="img-cover img-death">
                                    @else
                                        <img src="{{ asset('assets/img/icons/blank-profile.png') }}" class="img-cover img-death">
                                    @endif
                                </div>
                                <div class="ms-3">
                                    <p class="m-0 mb-1 text-clr1 fw-bold lh-1 d-flex align-items-center"><i class="font-rounded fst-normal">@</i> {{ $x->user_username }} {!! ($x->user_id == session('user')['user_id']) ? '<i class="fst-normal fw-normal ms-1 fsz-9 border-clr1 rounded px-2">you</i>'  : '' !!}</p>
                                    <p class="m-0 text-secondary lh-1">{{ $x->user_fullname }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="m-0 text-secondary">{{ $user['user_fullname'] }} is not connected to anyone yet.</p>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalConnecting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-light rounded-m">
            <div class="modal-header bg-clr2 text-light">
                <h4 class="modal-title fw-bold">Connecting</h4>
                <button type="button" class="ms-auto hover bg-clr2 border-light text-light rounded-circle he-28 we-28" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <div class="w-100">
                    @if(!empty($connect_data['connecting']['users']))
                        @foreach($connect_data['connecting']['users'] as $x)
                            <div class="d-flex align-items-center m-0 px-2 py-3 bg-clrw hover cursor-pointer" onclick="window.location.href='<?= url('usr/' . $x->user_username) ?>'">
                                <div class="rounded-circle overflow-hidden flex-shrink-0" style="height:30px;width:30px;">
                                    @if($x->user_photo !== null)
                                        <img src="{{ asset($x->user_photo) }}" class="img-cover img-death">
                                    @else
                                        <img src="{{ asset('assets/img/icons/blank-profile.png') }}" class="img-cover img-death">
                                    @endif
                                </div>
                                <div class="ms-3">
                                    <p class="m-0 mb-1 text-clr1 fw-bold lh-1 d-flex align-items-center"><i class="font-rounded fst-normal">@</i> {{ $x->user_username }} {!! ($x->user_id == session('user')['user_id']) ? '<i class="fst-normal fw-normal ms-1 fsz-9 border-clr1 rounded px-2">you</i>'  : '' !!}</p>
                                    <p class="m-0 text-secondary lh-1">{{ $x->user_fullname }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="m-0 text-secondary">{{ $user['user_fullname'] }} is not connecting to anyone yet.</p>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>