@if($user_search !== null && $user_search->count() > 0)    
    @foreach($user_search as $x)
        <div class="d-flex align-items-center m-0 px-2 py-3 bg-clrw">
            <div class="rounded-circle overflow-hidden flex-shrink-0" style="height:50px;width:50px;">
                @if($x->user_photo !== null)
                    <img src="{{ asset($x->user_photo) }}" class="img-cover img-death">
                @else
                    <img src="{{ asset('assets/img/icons/blank-profile.png') }}" class="img-cover img-death">
                @endif
            </div>
            <div class="ms-3">
                <a href="{{ url('usr/' . $x->user_username) }}" class="td-hover text-clr1">
                    <p class="m-0 mb-1 text-clr1 fw-bold lh-1 d-flex align-items-center">
                        <i class="font-rounded fst-normal">@</i> {{ $x->user_username }}
                        {!! ($x->user_id == session('user')['user_id']) ? '<i class="fst-normal fw-normal ms-1 fsz-9 border-clr1 rounded px-2">you</i>'  : '' !!}
                    </p>
                </a>
                <p class="m-0 mb-2 text-secondary lh-1">{{ $x->user_fullname }}</p>
                <p class="m-0 text-secondary lh-1 fsz-11">{{ $x->user_desc }}</p>
            </div>
            @if($x->user_id !== $user->user_id)
                <div class="ms-auto">
                    @if($x->connect_status == true)
                        <form action="{{ url('req/disconnect') }}" method="post" class="mt-2">
                            @csrf
                            <input type="hidden" name="user_id_dst" value="{{ $x->user_id }}">
                            <p class="m-0 fsz-9 text-center text-secondary">Connected <i class="fas fa-check-circle"></i></p>
                            <button type="submit" style="width:90px;" class="btn btn-sm btn-outline-clr1 rounded-s px-3 lh-1 fsz-11">Disconnect</button>
                        </form>
                    @else
                        <form action="{{ url('req/connect') }}" method="post" class="mt-2">
                            @csrf
                            <input type="hidden" name="user_id_dst" value="{{ $x->user_id }}">
                            <p class="m-0 fsz-9 text-center text-secondary">Not connected</p>
                            <button type="submit" style="width:90px;" class="btn btn-sm btn-clr1 rounded-s px-3 lh-1 fsz-11">Connect</button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    @endforeach
@elseif(request()->has('k') && request()->get('k') !== '')
    <p class="text-secondary m-0">No users found.</p>
@else
    <p class="text-secondary m-0">Type in the search field to find peoples.</p>
@endif