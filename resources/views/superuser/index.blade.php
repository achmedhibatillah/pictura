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
        <div class="pt-4 overflow-x-scroll w-100">
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
                            <td class="d-flex align-items-center">
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