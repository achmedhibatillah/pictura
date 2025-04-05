<div class="row m-0 p-0 mt-5">
    <div class="col-md-8 row justify-content-center m-0 p-0">

                @if($posts->isNotEmpty())
                    <div class="row m-0 p-0">
                        @foreach($posts as $x)
                        <div class="card m-0 mb-4 p-3">
                            <div class="row m-0 p-0 mb-3">
                                <div class="col-md-6 post m-0 p-0 square overflow-hidden">
                                    <div class="w-100 bg-clrsec slick-container" id="containerSlide{{ $x->post_public_id }}">
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
                                            @if($x->user->user_photo !== null)
                                                <img src="{{ asset($x->user->user_photo) }}" class="img-cover img-death">
                                            @else
                                                <img src="{{ asset('assets/img/icons/blank-profile.png') }}" class="img-cover img-death">
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ url('usr/' . $x->user->user_username) }}" class="td-hover text-clr1"><p class="fst-normal text-clr1 fw-bold m-0"><i class="font-rounded fst-normal">@</i>{{ $x->user->user_username }}</p></a>
                                            <p class="text-secondary m-0 fsz-10">{{ $x->user->user_fullname }}</p>
                                        </div>
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
                        @endforeach
                    </div>
                    @push('scripts')
                    <script>
                        $(document).ready(function(){
                            $('[id^=containerSlide]').each(function(){
                                const $slider = $(this);
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
                    @endpush
                    <script>
                        window.addEventListener('load', function () {
                            $('[id^=containerSlide]').each(function(){
                                const $slider = $(this);
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
                @else 
                    <p class="text-secondary text-center m-0">No posts available.</p>
                @endif
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
                                            if (isLiked) {
                                                likeButton.html('<i class="fa-regular fa-heart"></i>');
                                            } else {
                                                likeButton.html('<i class="fa-solid fa-heart"></i>');
                                            }

                                            likeCount.text(response.likes_count);
                                        }
                                    });
                                });
                            });
                        likeButton.html('<i class="fa-solid fa-heart"></i>');
                    }

                    likeCount.text(response.likes_count);
                }
            });
        });
    });
</script>