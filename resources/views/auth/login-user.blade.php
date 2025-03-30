<div class="d-flex flex-column gap-2 justify-content-center align-items-center" style="min-height:100vh;padding:100px 0;">
    <div class="card bg-clr1 m-0 p-0 shadow-m-2" style="width:300px;">
        <img src="{{ asset('assets/img/logo-white-text.png') }}" class="mx-3 my-2">
    </div>
    <div class="card bg-light m-0 py-3 shadow-m-2" style="width:300px;">
        <h5 class="text-clr1 text-center m-0 mx-3 fw-bold">Log In to Pictura</h5>
        <hr>
        <div class="mx-3">
            @include('templates/flashdata')
        </div>
        <form action="{{ url('login') }}" method="post" class="mt-1 mb-2 mx-3">
            @csrf
            <div class="mb-2">
                <input name="user_identification" type="text" autocomplete="off" class="w-100 rounded input-effect bg-light he-40 px-3" placeholder="Username or Email"
                value="{{ old('user_identification') }}">
                @error('user_identification')
                    <div class="ms-2 mt-1 fsz-10 text-danger lh-1 d-flex"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>
            <div class="password-container">
                <div class="mb-2">
                    <input name="user_pass" id="user_pass" type="password" autocomplete="off" class="password w-100 rounded input-effect bg-light he-40 px-3" placeholder="Password"
                    value="{{ old('user_pass') }}">
                    @error('user_pass')
                        <div class="ms-2 mt-1 fsz-10 text-danger lh-1 d-flex"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check mt-2 mb-3 mx-1">
                    <input class="form-check-input border-clr1 rounded-circle cursor-pointer show-password" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label fsz-11" for="flexCheckDefault">Show password</label>
                </div>
            </div>
            <div class="d-flex mt-3">
                <button type="submit" class="w-100 he-40 btn btn-clr1">Log In<i class="fas fa-sign-in-alt ms-1"></i></button>
            </div>
        </form>
        <hr>
        <div class="d-flex flex-column mx-3">
            <p class="text-center mb-1 fsz-12 text-secondary">Don't have an account?</p>
            <a href="{{ url('register') }}" class="w-100 he-40 btn btn-clr4">Create Account</a>
        </div>
    </div>
</div>