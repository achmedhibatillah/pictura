<div class="row m-0 p-0 justify-content-center">
    <div class="col-md-8 m-0 p-0">
        <div class="mb-2">
            @include('templates/flashdata')
        </div>
        <div class="card m-0 p-3 mb-2">
            <p class="m-0 text-center">Edit My Profile</p>
        </div>
        <div class="card m-0 p-3 mb-2">
            <div class="row m-0 p-0">
                <div class="col-md-6 m-0 p-0 d-flex flex-column justify-content-center text-center">
                    <p class="fsz-11 m-0 text-secondary">Email</p>
                    <p class="m-0 fsz-12">{{ $user['user_email'] }}</p>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalEditEmail" class="td-none fsz-11 d-flex justify-content-center align-items-center">change email<i class="fa-solid fa-pen-to-square fsz-9 ms-1"></i></a>
                </div>
                <div class="col-md-6 m-0 p-0 d-flex flex-column justify-content-center text-center">
                    <hr class="d-block d-md-none">
                    <p class="fsz-11 m-0 text-secondary">Password</p>
                    <p class="m-0 fsz-12">***</p>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalEditPass" class="td-none fsz-11 d-flex justify-content-center align-items-center">change password<i class="fa-solid fa-pen-to-square fsz-9 ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="card m-0 p-3 mb-2">
            <div class="d-flex align-items-center flex-column">
                <div class="position-relative hover">
                    <div class="rounded-circle overflow-hidden cursor-pointer flex-shrink-0" data-bs-toggle="modal" data-bs-target="#modalEditPhoto" style="height:70px;width:70px;">
                        @if($user['user_photo'] !== null)
                            <img src="{{ asset($user['user_photo']) }}" class="img-cover img-death">
                        @else
                            <img src="{{ asset('assets/img/icons/blank-profile.png') }}" class="img-cover img-death">
                        @endif
                    </div>
                    <div class="bg-clr1 text-light he-20 we-20 fsz-8 rounded-circle d-flex justify-content-center align-items-center position-absolute translate-center hover cursor-pointer" style="bottom:-10px;right:-10px;"><i class="fas fa-pencil"></i></div>
                </div>
                <div class="d-flex align-items-start mt-4">
                    <div class="text-center">
                        <h5 class="m-0 mb-1 fw-bold text-clr1"><i class="font-rounded fst-normal me-1">@</i>{{ $user['user_username'] }}</h5>
                        <p class="m-0 mb-1">{{ $user['user_fullname'] }}</p>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalEditName" class="td-none fsz-11 d-flex justify-content-center align-items-center">change name<i class="fa-solid fa-pen-to-square fsz-9 ms-1"></i></a>
                    </div>
                </div>
                <div class="w-100">
                    <hr>
                    <p class="m-0 mb-1 fsz-10 text-secondary d-flex align-items-center">Description :</p>
                    <p class="m-0 fsz-11">
                        @if($user['user_desc'])
                            {{ $user['user_desc'] }}
                        @else 
                        <i class="text-secondary m-0">Your profile has no description.</i>
                        @endif
                    </p>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalEditDescription" class="td-none fsz-11 d-flex align-items-center">change description<i class="fa-solid fa-pen-to-square fsz-9 ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditEmail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-light rounded-m">
            <div class="modal-header bg-clr2 text-light">
                <h3 class="modal-title fw-bold">Change email</h3>
                <button type="button" class="ms-auto hover bg-clr2 border-light text-light rounded-circle he-28 we-28" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="{{ url('edit-profile/email') }}" id="formEditEmail" method="post" class="text-clr2">
                    @csrf
                    <div class="mb-3">
                        <p class="m-0 text-secondary">Before</p>
                        <p class="m-0 text-dark">{{ $user['user_email'] }}</p>
                    </div>
                    <div class="">
                        <label class="ms-2" for="user_email">New email</label>
                        <input name="user_email" type="text" class="input-effect rounded-s border-clr2 bg-clrsec he-35 w-100 px-3 fsz-11" autocomplete="off" placeholder="Your email"
                        value="{{ old('user_email') }}">
                        @error('user_email')
                            <div class="ms-2 mt-1 fsz-10 text-danger lh-1 d-flex"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-clr2" onclick="submitEditEmailForm()">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditPass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-light rounded-m">
            <div class="modal-header bg-clr2 text-light">
                <h3 class="modal-title fw-bold">Change password</h3>
                <button type="button" class="ms-auto hover bg-clr2 border-light text-light rounded-circle he-28 we-28" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="{{ url('edit-profile/pass') }}" id="formEditPass" method="post" class="text-clr2">
                    @csrf
                    <div class="mb-3">
                        <p class="m-0 mb-2 text-center" for="user_pass_old">Old password</p>
                        <input name="user_pass_old" type="password" class="input-effect rounded-s border-clr2 bg-clrsec he-35 w-100 px-3 fsz-11" autocomplete="off" placeholder="Password"
                        value="{{ old('user_pass_old') }}">
                        @error('user_pass_old')
                            <div class="ms-2 mt-1 fsz-10 text-danger lh-1 d-flex"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="password-container">
                    <p class="m-0 mb-1 text-center">New password</p>
                        <div class="mb-1 position-relative">
                            <div class="w-100 d-flex justify-content-center" style="top:-2px"><div class="pass-indicator-container mb-1" style="width:95%;"><div id="charPassIndicator" class="pass-indicator"></div></div></div>
                            <input id="user_pass" name="user_pass" type="password" autocomplete="off" class="password w-100 rounded-s input-effect he-35 bg-clrsec px-3 fsz-11" placeholder="Password"
                            value="{{ old('user_pass') }}">
                        </div>
                        <div class="">
                            <input name="user_pass_confirmation" type="password" autocomplete="off" class="password w-100 rounded-s input-effect he-35 bg-clrsec px-3 fsz-11" placeholder="Confirm password"
                            value="{{ old('user_pass_confirmation') }}">
                            <div class="mx-2 mt-1 fsz-10 text-secondary lh-1 d-flex">Enter 8-20 characters. Combine letters, numbers, and symbols.</div>
                        </div>
                        @error('user_pass')
                            <div class="mx-2 mt-1 fsz-10 text-danger lh-1 d-flex"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                        <div class="form-check mt-2 mx-2">
                            <input class="form-check-input border-clr1 rounded-circle cursor-pointer show-password" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label text-dark cursor-pointer fsz-11" for="flexCheckDefault">Show password</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-clr2" onclick="submitEditPassForm()">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditPhoto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-light rounded-m">
            <div class="modal-header bg-clr2 text-light">
                <h3 class="modal-title fw-bold">Change photo</h3>
                <button type="button" class="ms-auto hover bg-clr2 border-light text-light rounded-circle he-28 we-28" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="{{ url('edit-profile/photo') }}" id="formEditPhoto" method="post" enctype="multipart/form-data" class="text-clr2">
                    @csrf
                    <div class="">
                        <label class="ms-2" for="user_photo">New photo</label>
                        <input name="user_photo" type="file" class="input-effect cursor-pointer rounded-s border-clr2 bg-clrsec he-35 w-100 px-3 fsz-11"
                        accept="img">
                        @error('user_photo')
                            <div class="ms-2 mt-1 fsz-10 text-danger lh-1 d-flex"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-clr2" onclick="submitEditPhotoForm()">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditName" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-light rounded-m">
            <div class="modal-header bg-clr2 text-light">
                <h3 class="modal-title fw-bold">Change name</h3>
                <button type="button" class="ms-auto hover bg-clr2 border-light text-light rounded-circle he-28 we-28" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="{{ url('edit-profile/name') }}" id="formEditName" method="post" class="text-clr2">
                @csrf
                    <div class="mb-3">
                        <label class="ms-2" for="user_username">Username</label>
                        <input name="user_username" type="text" class="input-effect rounded-s border-clr2 bg-clrsec he-35 w-100 px-3 fsz-11" autocomplete="off" placeholder="..."
                        value="{{ old('user_username', $user['user_username']) }}">
                        @error('user_username')
                            <div class="ms-2 mt-1 fsz-10 text-danger lh-1 d-flex"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label class="ms-2" for="user_fullname">Full name</label>
                        <input name="user_fullname" type="text" class="input-effect rounded-s border-clr2 bg-clrsec he-35 w-100 px-3 fsz-11" autocomplete="off" placeholder="..."
                        value="{{ old('user_fullname', $user['user_fullname']) }}">
                        @error('user_fullname')
                            <div class="ms-2 mt-1 fsz-10 text-danger lh-1 d-flex"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-clr2" onclick="submitEditNameForm()">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditDescription" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-lg modal-dialog-centered modal-dialog-scrollable" style="width:100%;">
        <div class="modal-content border-light rounded-m">
            <div class="modal-header bg-clr2 text-light">
                <h3 class="modal-title fw-bold">Change description</h3>
                <button type="button" class="ms-auto hover bg-clr2 border-light text-light rounded-circle he-28 we-28" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="{{ url('edit-profile/desc') }}" id="formEditDescription" method="post" class="text-clr2">
                    @csrf
                    <div class="mb-3">
                        <div class="">
                            <textarea name="user_desc" class="d-inline input-effect rounded-s border-clr2 bg-clrsec w-100 p-3 fsz-11 m-0" autocomplete="off" placeholder="..." style="height:180px;">{{ old('user_desc', $user['user_desc']) }}</textarea>
                            @error('user_desc')
                                <div class="ms-2 mt-1 fsz-10 text-danger lh-1 d-flex">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-clr2" onclick="submitEditDescForm()">Submit</button>
            </div>
        </div>
    </div>
</div>

<style>
.username-indicator-container { height: 0.5px; background: #fff; overflow: hidden; } .username-indicator { height: 100%; width: 0%; background: blue; transition: width 0.3s ease, background 0.3s ease; }
.pass-indicator-container { height: 0.5px; background: #fff; overflow: hidden; } .pass-indicator { height: 100%; width: 0%; background: blue; transition: width 0.3s ease, background 0.3s ease; }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    @if(session()->has('errors') && (session('errors')->has('user_email')))
        var myModal = new bootstrap.Modal(document.getElementById('modalEditEmail'));
        myModal.show();
    @endif
    @if(session()->has('errors') && (session('errors')->has('user_pass_old') || session('errors')->has('user_pass')))
        var myModal = new bootstrap.Modal(document.getElementById('modalEditPass'));
        myModal.show();
    @endif
    @if(session()->has('errors') && (session('errors')->has('user_photo')))
        var myModal = new bootstrap.Modal(document.getElementById('modalEditPhoto'));
        myModal.show();
    @endif
    @if(session()->has('errors') && (session('errors')->has('user_username') || session('errors')->has('user_fullname')))
        var myModal = new bootstrap.Modal(document.getElementById('modalEditName'));
        myModal.show();
    @endif
    @if(session()->has('errors') && (session('errors')->has('user_desc')))
        var myModal = new bootstrap.Modal(document.getElementById('modalEditDescription'));
        myModal.show();
    @endif
});

function submitEditEmailForm() { document.getElementById('formEditEmail').submit(); }
function submitEditPassForm() { document.getElementById('formEditPass').submit(); }
function submitEditPhotoForm() { document.getElementById('formEditPhoto').submit(); }
function submitEditNameForm() { document.getElementById('formEditName').submit(); }
function submitEditDescForm() { document.getElementById('formEditDescription').submit(); }

function updatePassIndicator() {
    const passMaxLength = 20;
    const passMinLength = 8;
    const passInputField = document.getElementById("user_pass");
    if (!passInputField) return;
    const passInputLength = passInputField.value.length;
    const passPercentage = Math.min((passInputLength / passMaxLength) * 100, 100);
    const passIndicator = document.getElementById("charPassIndicator");
    if (passIndicator) {
        if (passInputLength < passMinLength) {
            passIndicator.style.background = "orange";
        } else if (passInputLength > passMaxLength) {
            passIndicator.style.background = "red";
        } else {
            passIndicator.style.background = "blue";
        }
        passIndicator.style.width = passPercentage + "%";
    }
}
document.addEventListener("DOMContentLoaded", function () {
    const passField = document.getElementById("user_pass");
    if (passField) {
        passField.addEventListener("input", updatePassIndicator);
        updatePassIndicator();
    }
});
</script>

