<div class="bg-clrw row m-0 p-0 justify-content-center w-100">
    <div class="col-11 col-md-10 col-xl-8 m-0 px-3 pt-3 pb-5 bg-clrsec" style="max-width:1200px;min-height:100vh;">
        <div class="bg-clr1 d-flex align-items-center rounded shadow-m">
            <div class="bg-clrsec rounded">
                <img src="{{ asset('assets/img/logo.png') }}" class="we-50 m-1 rounded">
            </div>
            <p class="m-0 text-light ms-2">Pictura Super User Page</p>
            <div class="dropdown ms-auto me-1">
                <div class="rounded-circle overflow-hidden flex-shrink-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="height:40px;width:40px;">
                    @if($user['user_photo'] !== null)
                        <img src="{{ asset($user['user_photo']) }}" class="img-cover img-death">
                    @else
                        <img src="{{ asset('assets/img/icons/blank-profile.png') }}" class="img-cover img-death">
                    @endif
                </div>

                <ul class="dropdown-menu dropdown-menu-end mt-2 border-radius-none" style="width:240px;">
                    <li>
                        <div class="mx-3 my-2">
                            <p class="m-0">Super user :</p>
                            <p class="m-0 fw-bold text-clr1"><i class="font-rounded fst-normal">@</i>{{ $user->user_username }}</p>
                            <p class="m-0 text-secondary">{{ $user->user_fullname }}</p>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-clr1" href="{{ url('/') }}">Back to my user page <i class="fas fa-user"></i></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="{{ url('d') }}">Log out <i class="fas fa-sign-out-alt"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="pt-4">
            @include('templates/flashdata')
        </div>
        <div class="mt-4">
            <a href="#" data-bs-toggle="modal" data-bs-target="#modalCreateAccount" class="btn btn-clr1">Create account</a>
        </div>
        <div class="pt-2 overflow-x-scroll scrollbar-hidden w-100">
            <table class="table">
                <thead>
                    <th>No.</th>
                    <th>Profile</th>
                    <th>Joined</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    @foreach($users as $x)
                        <tr>
                            <td>{{ $i }}</td>
                            <td class="">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle overflow-hidden flex-shrink-0" style="height:40px;width:40px;">
                                        @if($x['user_photo'] !== null)
                                            <img src="{{ asset($x['user_photo']) }}" class="img-cover img-death">
                                        @else
                                            <img src="{{ asset('assets/img/icons/blank-profile.png') }}" class="img-cover img-death">
                                        @endif
                                    </div>
                                    <div class="ms-4">
                                        <a href="{{ url('usr/' . $x['user_username']) }}" target="__blank" data-bs-toggle="tooltip" title="Show profile" class="td-hover text-clr1"><h5 class="m-0 mb-1 fw-bold"><i class="font-rounded fst-normal me-1">@</i>{{ $x['user_username'] }}</h5></a>
                                        <p class="m-0 mb-1">{{ $x['user_fullname'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $x['created_at'] }}</td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <a href="{{ url('manage-users/edit/' . $x['user_id']) }}" class="btn btn-sm btn-warning lh-1" style="width:90px;">Edit <i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger lh-1" style="width:90px;" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $x['user_username'] }}">Delete <i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php $i++ ?>
                    <!-- Modal -->
                    <div class="modal fade" id="modalDelete{{ $x['user_username'] }}" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm">
                            <div class="modal-body modal-content border-light border-radius-none">
                                <div class="modal-body p-0 border-radius-none">
                                    <button type="button" class="position-absolute bg-transparent border-none" style="top:0;right:0;" data-bs-dismiss="modal" aria-label="Close">x</button>
                                    <form action="{{ url('manage-users/del') }}" method="post">
                                        @csrf 
                                        <input type="hidden" name="user_id" value="{{ $x['user_id'] }}">
                                        <p class="me-3">Are you sure you want to delete this user?</p>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle overflow-hidden flex-shrink-0" style="height:40px;width:40px;">
                                                @if($x['user_photo'] !== null)
                                                    <img src="{{ asset($x['user_photo']) }}" class="img-cover img-death">
                                                @else
                                                    <img src="{{ asset('assets/img/icons/blank-profile.png') }}" class="img-cover img-death">
                                                @endif
                                            </div>
                                            <div class="ms-4">
                                                <h5 class="m-0 mb-1 fw-bold text-clr1"><i class="font-rounded fst-normal me-1">@</i>{{ $x['user_username'] }}</h5>
                                                <p class="m-0 mb-1">{{ $x['user_fullname'] }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                            <button type="submit" class="btn btn-sm btn-danger">Delete <i class="fas fa-trash"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach 
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCreateAccount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-light rounded-m">
            <div class="modal-header bg-clr2 text-light">
                <h3 class="modal-title fw-bold">Create account</h3>
                <button type="button" class="ms-auto hover bg-clr2 border-light text-light rounded-circle he-28 we-28" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="{{ url('manage-users/add') }}" id="formCreateUser" method="post" class="text-clr2">
                    @csrf
                    <div class="mb-2 mx-3">
                        <input name="user_email" type="text" autocomplete="off" class="w-100 rounded input-effect bg-light he-40 px-3 no-space no-capital" placeholder="Email"
                        value="{{ old('user_email') }}">
                        @error('user_email')
                            <div class="ms-2 mt-1 fsz-10 text-danger lh-1 d-flex"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2 mx-3">
                        <input name="user_fullname" type="text" autocomplete="off" class="w-100 rounded input-effect bg-light he-40 px-3" placeholder="Full Name"
                        value="{{ old('user_fullname') }}">
                        @error('user_fullname')
                            <div class="ms-2 mt-1 fsz-10 text-danger lh-1 d-flex"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <hr>
                    <p class="m-0 mx-3 text-clr1 fw-bold mb-2">Account</p>
                    <div class="mb-2 mx-3 position-relative">
                        <div class="w-100 d-flex justify-content-center"><div class="username-indicator-container mb-1" style="width:95%;"><div id="charUsernameIndicator" class="username-indicator"></div></div></div>
                        <input name="user_username" id="user_username" type="text" autocomplete="off" class="w-100 rounded input-effect bg-light he-40 px-3 no-space no-capital no-symbol" placeholder="Username"
                        value="{{ old('user_username') }}">
                        <div class="ms-2 mt-1 fsz-10 text-secondary lh-1 d-flex">Enter 5-20 characters.</div>
                        @error('user_username')
                            <div class="ms-2 mt-1 fsz-10 text-danger lh-1 d-flex"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="password-container mb-2">
                        <div class="mb-1 mx-3 position-relative">
                            <div class="w-100 d-flex justify-content-center" style="top:-2px"><div class="pass-indicator-container mb-1" style="width:95%;"><div id="charPassIndicator" class="pass-indicator"></div></div></div>
                            <input id="user_pass" name="user_pass" type="password" autocomplete="off" class="password w-100 rounded input-effect bg-light he-40 px-3" placeholder="Password"
                            value="{{ old('user_pass') }}">
                        </div>
                        <div class="mx-3">
                            <input name="user_pass_confirmation" type="password" autocomplete="off" class="password w-100 rounded input-effect bg-light he-40 px-3" placeholder="Confirm password"
                            value="{{ old('user_pass_confirmation') }}">
                            <div class="ms-2 mt-1 fsz-10 text-secondary lh-1 d-flex">Enter 8-20 characters. Combine letters, numbers, and symbols.</div>
                        </div>
                        @error('user_pass')
                            <div class="mx-3">
                                <div class="ms-2 mt-1 fsz-10 text-danger lh-1 d-flex"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            </div>
                        @enderror
                        <div class="form-check mt-2 mb-3 mx-4">
                            <input class="form-check-input border-clr1 rounded-circle cursor-pointer show-password" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label fsz-11" for="flexCheckDefault">Show password</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-clr2" onclick="submitCreateUserForm()">Submit</button>
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
    @if(session()->has('errors'))
        var myModal = new bootstrap.Modal(document.getElementById('modalCreateAccount'));
        myModal.show();
    @endif
});
function submitCreateUserForm() { document.getElementById('formCreateUser').submit(); }

function updateUsernameIndicator() {
    const usernameMaxLength = 20;
    const usernameMinLength = 6;
    const usernameInputField = document.getElementById("user_username");
    if (!usernameInputField) return;
    const usernameInputLength = usernameInputField.value.length;
    const usernamePercentage = Math.min((usernameInputLength / usernameMaxLength) * 100, 100);
    const usernameIndicator = document.getElementById("charUsernameIndicator");
    if (usernameIndicator) {
        if (usernameInputLength < usernameMinLength) {
            usernameIndicator.style.background = "orange";
        } else if (usernameInputLength > usernameMaxLength) {
            usernameIndicator.style.background = "red";
        } else {
            usernameIndicator.style.background = "blue";
        }
        usernameIndicator.style.width = usernamePercentage + "%";
    }
}
document.addEventListener("DOMContentLoaded", function () {
    const usernameField = document.getElementById("user_username");
    if (usernameField) {
        usernameField.addEventListener("input", updateUsernameIndicator);
        updateUsernameIndicator();
    }
});

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