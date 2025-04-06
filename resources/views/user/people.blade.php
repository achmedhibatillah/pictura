<div class="row m-0 p-0 mt-5">
    <div class="col-md-8 m-0 p-0">
        <div class="card m-0 mb-3 p-3" style="height: min-content;">
            <form action="{{ url('find-people') }}" method="get" class="">
                @csrf 
                <label for="" class="ms-2 fsz-11">Find people</label>
                <div class="position-relative">
                    <i class="fas fa-search position-absolute translate-center fsz-10 text-secondary" style="top:52%;left:16px;"></i>
                    <input name="k" type="text" autocomplete="off" class="fsz-11 m-0 rounded-s input-effect bg-light he-28 pe-2 no-space no-capital w-100" style="padding-left:27px;" placeholder="Search">
                </div>
            </form>    
        </div>
        <div class="card m-0 p-3" id="people-result">
            @include('user/people-data')
        </div>
    </div>
    <div class="col-md-4 m-0 p-0 ps-0 ps-md-3">
        <div class="card m-0 mt-3 mt-md-0 p-3">
            <h5>Recommended people to connect</h5>
            <p class="m-0 text-secondary fsz-11">Connect more people to get updates from them.</p>
            <hr>
            @if(!empty($recommended))
                @foreach($recommended['users'] as $x)
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
                            <form action="{{ url('req/connect') }}" method="post" class="mt-2">
                                @csrf
                                <input type="hidden" name="user_id_dst" value="{{ $x->user_id }}">
                                <button type="submit" class="btn btn-sm btn-clr1 rounded-s px-3 lh-1 fsz-11">Connect</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @elseif($recommended == null) 
                <p class="m-0 text-secondary">No users are suggested.</p>
            @endif 
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('input[name="k"]').on('input', function(){
        let keyword = $(this).val();

        $.ajax({
            url: "{{ url('find-people') }}",
            method: 'GET',
            data: { k: keyword },
            success: function(response){
                $('#people-result').html(response);
            }
        });
    });
});
</script>
