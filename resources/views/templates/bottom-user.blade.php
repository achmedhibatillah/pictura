        </div>
    </div>
    <div class="mt-auto bg-clrw row m-0 p-0 justify-content-center w-100">
        <div class="col-11 col-md-10 col-xl-8 m-0 p-0" style="max-width:1200px;">
            <div class="row m-0 p-0 pt-2 pt-md-0 pb-2">
                <div class="col-7 row m-0 p-0">
                    <div class="col-4 m-0 p-0">
                        <div class="cursor-pointer text-clr1" onclick="window.location.href='<?= url('/') ?>'">
                            <div class="d-flex justify-content-center img-hover">
                                <img src="{{ asset('assets/img/icons/homepage.png') }}" class="he-27 we-27 img-death">
                            </div>
                            <p class="text-center m-0 d-none d-md-block fsz-10">Homepage</p>
                        </div>
                    </div>
                    <div class="col-4 m-0 p-0">
                        <div class="cursor-pointer text-clr1" onclick="window.location.href='<?= url('/') ?>'">
                            <div class="d-flex justify-content-center img-hover">
                                <img src="{{ asset('assets/img/icons/post.png') }}" class="he-27 we-27 img-death">
                            </div>
                            <p class="text-center m-0 d-none d-md-block fsz-10">New Post</p>
                        </div>
                    </div>
                    <div class="col-4 m-0 p-0">
                        <div class="cursor-pointer text-clr1" onclick="window.location.href='<?= url('/') ?>'">
                            <div class="d-flex justify-content-center img-hover">
                                <img src="{{ asset('assets/img/icons/notification.png') }}" class="he-27 we-27 img-death">
                            </div>
                            <p class="text-center m-0 d-none d-md-block fsz-10">Notification</p>
                        </div>
                    </div>
                </div>
                <div class="col-5 m-0 p-0 text-clr1 position-relative d-flex flex-column">
                    <div id="profile-bottom" class="position-absolute translate-center rounded-circle overflow-hidden cursor-pointer" style="border:3px solid white;left:50%;"  onclick="window.location.href='<?= url('usr/' . session('user')['user_username']) ?>'">
                        @if(session('user')['user_photo'] !== null)
                            <img src="{{ asset(session('user')['user_photo']) }}" class="img-cover img-death">
                        @else
                            <img src="{{ asset('assets/img/icons/blank-profile.png') }}" class="img-cover img-death">
                        @endif                    
                    </div>
                    <div class="d-flex justify-content-center mt-auto">
                        <p class="text-center m-0 cursor-pointer w-75 overflow-hidden fsz-10 d-flex align-items-center justify-content-center" onclick="window.location.href='<?= url('usr/' . session('user')['user_username']) ?>'"><i class="font-rounded fst-normal fsz-9 mb-1" style="margin-right:1px;">@</i>{{ session('user')['user_username'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>