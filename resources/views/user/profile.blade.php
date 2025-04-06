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
                    <p class="m-0 fsz-12">{{ $posts_count }}</p>
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
        <div class="card mb-2 m-0 p-0 py-2 px-2">
            @if($posts->isNotEmpty())
                <div class="row m-0 p-0">
                    @foreach($posts as $x)
                        <div class="col-4 m-0 p-1">
                            <div class="d-flex justify-content-center overflow-hidden rounded shadow-l-2 cursor-pointer" data-bs-toggle="modal" data-bs-target="#modalPost{{ $x->post_public_id }}">
                                <img src="{{ asset($x->slides[0]->slide_image) }}" class="w-100 img-hover">
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="modalPost{{ $x->post_public_id }}" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                            <button type="button" class="position-absolute btn btn-outline-light" style="top:20px;right:20px;" data-bs-dismiss="modal" aria-label="Close">x</button>
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                <div class="modal-content border-light border-radius-none">
                                    <div class="modal-body p-0 border-radius-none">
                                        <div class="row m-0 p-0">
                                            <div class="col-md-6 post m-0 p-0 square overflow-hidden">
                                                <div class="w-100 bg-clrsec" id="containerSlide{{ $x->post_public_id }}">
                                                    @foreach($x->slides as $y)
                                                        <div class="bg-secondary">
                                                            <img src="{{ asset($y->slide_image) }}" class="w-100">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-6 m-0 p-0 p-3 d-flex flex-column square overflow-hidden">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle overflow-hidden flex-shrink-0 me-2" style="height:30px;width:30px;">
                                                        @if($user['user_photo'] !== null)
                                                            <img src="{{ asset($user['user_photo']) }}" class="img-cover img-death">
                                                        @else
                                                            <img src="{{ asset('assets/img/icons/blank-profile.png') }}" class="img-cover img-death">
                                                        @endif
                                                    </div>
                                                    <div class="">
                                                        <p class="fst-normal text-clr1 fw-bold m-0"><i class="font-rounded fst-normal">@</i>{{ $user['user_username'] }}</p>
                                                        <p class="text-secondary m-0 fsz-10">{{ $user['user_fullname'] }}</p>
                                                    </div>
                                                    @if($ismyprofile)
                                                        <div class="dropdown ms-auto">
                                                            <div class="cursor-pointer we-30 d-flex justify-content-center" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></div>
                                                            <ul class="dropdown-menu mt-2 fsz-12 bg-clrsec">
                                                                <li><a class="dropdown-item text-secondary" href="{{ url('edit-post/' . $x->post_public_id) }}">Edit mode <i class="fas fa-edit"></i></a></li>
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#modalDeletePost{{ $x->post_public_id }}">Delete <i class="fas fa-trash"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                                <p class="mt-3 flex-grow-1 overflow-x-hidden overflow-y-scroll">{{ $x->post_desc }}</p>
                                                <div class="mt-auto">
                                                    <hr class="m-0 mb-3">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <form class="like-form" data-post-id="{{ $x->post_id }}">
                                                            @csrf 
                                                            <input type="hidden" name="post_id" value="{{ $x->post_id }}">
                                                            <button type="submit" class="btn btn-transparent p-0 text-clr1 like-button">
                                                                @if($x->likes->contains('user_id', session('user')['user_id']))
                                                                    <i class="fa-solid fa-heart"></i>
                                                                @else
                                                                    <i class="fa-regular fa-heart"></i>
                                                                @endif
                                                            </button>
                                                        </form>
                                                        <p class="m-0 like-count">{{ $x->likes_count }}</p>
                                                    </div>
                                                    <p class="text-secondary m-0 mt-2 fsz-10">{{ $x->created_at_day }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="modalDeletePost{{ $x->post_public_id }}" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm">
                                <div class="modal-content border-light border-radius-none">
                                    <div class="modal-body p-0 border-radius-none">
                                    <button type="button" class="position-absolute border-none bg-transparent" style="top:0;right:0;" data-bs-dismiss="modal" aria-label="Close">x</button>
                                    <form action="{{ url('del-post') }}" method="post">
                                        @csrf 
                                        <input type="hidden" name="post_public_id" value="{{ $x->post_public_id }}">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete <i class="fas fa-trash"></i></button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                
                        <script>
                            $(document).ready(function(){
                                $('#modalPost{{ $x->post_public_id }}').on('shown.bs.modal', function () {
                                    var $slider = $('#containerSlide{{ $x->post_public_id }}');
                                    if (!$slider.hasClass('slick-initialized')) {
                                        $slider.slick({
                                            slidesToShow: 1,
                                            slidesToScroll: 1,
                                            infinite: false,
                                            arrows: true,
                                            dots: true,
                                            swipe: true,
                                            touchMove: true,
                                            adaptiveHeight: true
                                        });
                                    }
                                });
                            });
                        </script>
                    @endforeach
                </div>
            @else 
                <p class="text-secondary text-center m-0">No posts available.</p>
            @endif
        </div>
    </div>
    <div class="col-md-4 m-0 p-0 ps-0 ps-md-2"> 
        @if($ismyprofile == true)
        <div class="card m-0 px-3 py-2">
            <div class="d-flex mt-2 mb-2 text-clr1 fw-bold">Action</div>
            <div class="m-0 cursor-pointer bg-clrw hover d-flex align-items-center he-40" onclick="window.location.href='<?= url('edit-profile') ?>'">
                <div class="we-40 d-flex justify-content-center"><img src="{{ asset('assets/img/icons/edit-profile.png') }}" class="he-20 img-death"></div>
                <p class="text-clr1 fsz-12 m-0 lh-1 text-start">Edit my profile</p>
            </div>
            <hr class="m-0">
            <div class="m-0 cursor-pointer bg-clrw hover d-flex align-items-center he-40" onclick="window.location.href='<?= url('new-post') ?>'">
                <div class="we-40 d-flex justify-content-center"><img src="{{ asset('assets/img/icons/post.png') }}" class="he-22 img-death"></div>
                <p class="text-clr1 fsz-12 m-0 lh-1 text-start">New post and my draft</p>
            </div>
            <hr class="m-0">
            <div class="m-0 text-danger cursor-pointer bg-clrw hover d-flex align-items-center he-40" onclick="window.location.href='<?= url('d') ?>'">
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

<style>
.slick-prev, .slick-next { position: absolute; top: 52%; transform: translateY(-50%); z-index: 10;  }
.slick-prev { left: 5px; }
.slick-next { right: 5px; }

.slick-dots li button:before { color: var(--clrsec); font-size: 12px; }
.slick-dots .slick-active button:before { color: var(--clrw) !important; }
.slick-dots { position: absolute; bottom: 20px; text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.8) }
.slick-dots li { width: 15px; height: 15px; margin: 0 5px; }
.slick-dots li button:before { content: "■"; text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.8); }
</style>

<script>
    $(document).ready(function () {
        $(document).on("submit", ".like-form", function (e) {
            e.preventDefault();
            
            var form = $(this);
            var postId = form.data("post-id");
            var likeButton = form.find(".like-button");
            var likeCount = form.closest(".d-flex").find(".like-count");
            var isLiked = likeButton.find("i").hasClass("fa-solid");

            $.ajax({
                url: "{{ url('post/like') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    post_id: postId,
                    like_req: isLiked ? "dislike" : "like"
                },
                success: function (response) {
                    // Toggle ikon hati
                    if (isLiked) {
                        likeButton.html('<i class="fa-regular fa-heart"></i>');
                    } else {                            $(document).ready(function () {
                                $(".like-form").submit(function (e) {
                                    e.preventDefault();
                                    
                                    var form = $(this);
                                    var postId = form.data("post-id");
                                    var likeButton = form.find(".like-button");
                                    var likeCount = form.siblings(".like-count");
                                    var isLiked = likeButton.find("i").hasClass("fa-solid");
                                    
                                    $.ajax({
                                        url: "{{ url('post/like') }}",
                                        type: "POST",
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            post_id: postId,
                                            like_req: isLiked ? "dislike" : "like"
                                        },
                                        success: function (response) {
                                            // Toggle ikon hati
                                            if (isLiked) {
                                                likeButton.html('<i class="fa-regular fa-heart"></i>'); // Ubah ke hati kosong
                                            } else {
                                                likeButton.html('<i class="fa-solid fa-heart"></i>'); // Ubah ke hati penuh
                                            }

                                            // Perbarui jumlah like
                                            likeCount.text(response.likes_count);
                                        }
                                    });
                                });
                            });
                        likeButton.html('<i class="fa-solid fa-heart"></i>'); // Ubah ke hati penuh
                    }

                    // Perbarui jumlah like hanya di post ini
                    likeCount.text(response.likes_count);
                }
            });
        });
    });
</script>
