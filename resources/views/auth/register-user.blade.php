<div class="d-flex flex-column gap-2 justify-content-center align-items-center" style="min-height:100vh;padding:100px 0;">
    <div class="card bg-clr1 m-0 p-0 shadow-m-2" style="width:300px;">
        <img src="{{ asset('assets/img/logo-white-text.png') }}" class="mx-3 my-2">
    </div>
    <div class="card bg-light m-0 py-3 shadow-m-2" style="width:300px;">
        <h5 class="text-clr1 text-center m-0 mx-3 fw-bold">Create a new account</h5>
        <hr>
        <form action="{{ url('register') }}" method="post" class="">
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
            <div class="d-flex mx-3 mt-3">
                <button type="submit" class="w-100 he-40 btn btn-clr1">Sign Up</button>
            </div>
        </form>
        <hr>
        <div class="d-flex flex-column mx-3">
            <p class="text-center m-0 fsz-12 text-secondary">Already have an account? <a href="{{ url('login') }}" class="td-hover">Log In here</a></p>
        </div>
    </div>
</div>


<style>
.username-indicator-container { height: 0.5px; background: #fff; overflow: hidden; } .username-indicator { height: 100%; width: 0%; background: blue; transition: width 0.3s ease, background 0.3s ease; }
.pass-indicator-container { height: 0.5px; background: #fff; overflow: hidden; } .pass-indicator { height: 100%; width: 0%; background: blue; transition: width 0.3s ease, background 0.3s ease; }
</style>

<script>
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
