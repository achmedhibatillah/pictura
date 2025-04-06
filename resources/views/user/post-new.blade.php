<div class="row m-0 p-0">
    <div class="col-md-7 m-0 p-0">
        <div class="card m-0 p-3">
            <p class="m-0">New post</p>
            <div class="my-3">
                <form action="{{ url('new-post/desc/edit') }}" method="post" id="formDesc">
                    @csrf 
                    <input type="hidden" name="post_id" id="post_id" value="{{ $post->post_id }}">
                    <textarea name="post_desc" id="post_desc" class="w-100 input-effect rounded px-2 py-1 fsz-12" 
                        style="height:80px;" placeholder="Description" oninput="autoSave()">{{ $post->post_desc }}</textarea>
                </form>
                <p id="saveStatus" class="text-muted fsz-10"></p>
            </div>
            <div class="d-flex mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalAddImage" class="btn btn-clr1 btn-sm">Add image<i class="fas fa-image ms-1"></i></a>
            </div>
            @if($slides->isNotEmpty())
                @foreach($slides as $x)
                    <div class="d-flex align-items-center mb-2">
                        <div class="me-4 text-center">
                            <p class="m-0 fsz-10 text-secondary">Slide</p>
                            <p class="m-0 text-clr1 fw-bold">{{ $x->slide_order }}</p>
                        </div>
                        <div class="me-2 bg-secondary square we-60 overflow-hidden">
                            <img src="{{ asset($x->slide_image) }}" class="w-100">
                        </div>
                        <div class="d-flex gap-1">
                            <!-- Button Up (Hanya tampil jika bukan slide pertama) -->
                            @if($x->slide_order > $slides->min('slide_order'))
                                <form action="{{ url('new-post/image/up') }}" method="post">
                                    @csrf 
                                    <input type="hidden" name="slide_id" value="{{ $x->slide_id }}">
                                    <input type="hidden" name="post_id" value="{{ $x->post_id }}">
                                    <button type="submit" class="btn btn-outline-primary btn-sm fsz-9"><i class="fas fa-arrow-up"></i></button>
                                </form>
                            @else
                                <div class="btn text-secondary btn-sm fsz-9"><i class="fas fa-arrow-up"></i></div>
                            @endif

                            <!-- Button Down (Hanya tampil jika bukan slide terakhir) -->
                            @if($x->slide_order < $slides->max('slide_order'))
                                <form action="{{ url('new-post/image/down') }}" method="post">
                                    @csrf 
                                    <input type="hidden" name="slide_id" value="{{ $x->slide_id }}">
                                    <input type="hidden" name="post_id" value="{{ $x->post_id }}">
                                    <button type="submit" class="btn btn-outline-primary btn-sm fsz-9"><i class="fas fa-arrow-down"></i></button>
                                </form>
                            @else
                                <div class="btn text-secondary btn-sm fsz-9"><i class="fas fa-arrow-down"></i></div>
                            @endif

                            <!-- Delete Button -->
                            <form action="{{ url('new-post/image/del') }}" method="post">
                                @csrf 
                                <input type="hidden" name="slide_id" value="{{ $x->slide_id }}">
                                <input type="hidden" name="post_id" value="{{ $x->post_id }}">
                                <button type="submit" class="btn btn-danger btn-sm fsz-9"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-secondary m-0 fsz-12">No images added yet.</p>
            @endif
            @if($slides->isNotEmpty())
                <hr>
                <form action="{{ url('new-post/share') }}" method="post">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->post_id }}">
                    <button type="submit" class="td-hover fw-bold text-primary btn btn-transparent p-0">Share now</button>
                </form>
                <div class="">
                    <a href="#" class="td-hover fw-bold text-primary btn btn-transparent p-0" data-bs-toggle="modal" data-bs-target="#modalDelete">Delete</a>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modalDelete" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm">
                        <div class="modal-body modal-content border-light border-radius-none">
                            <div class="modal-body p-0 border-radius-none">
                            <button type="button" class="position-absolute bg-transparent border-none" style="top:0;right:0;" data-bs-dismiss="modal" aria-label="Close">x</button>
                            <form action="{{ url('del-post') }}" method="post">
                                @csrf 
                                <input type="hidden" name="post_public_id" value="{{ $post->post_public_id }}">
                                <input type="hidden" name="redirect" value="new-post">
                                <p class="me-3">Are you sure you want to delete this post?</p>
                                <div class="mt-3">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button type="submit" class="btn btn-sm btn-danger">Delete <i class="fas fa-trash"></i></button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-5 m-0 p-0 pt-3 pt-md-0 ps-0 ps-md-1">
        <div class="card m-0 p-3">
            @if($posts->isNotEmpty())
                <p class="m-0 mb-2">Draft</p>
                @foreach($posts as $x)
                    <div class="d-flex align-items-center overflow-hidden mb-2">
                        <div class="me-2">
                            @if(isset($x->slides[1]))
                                <div class="we-20 position-relative">
                                    <img src="{{ asset($x->slides[1]->slide_image) }}" class="we-15">
                                    <img src="{{ asset($x->slides[0]->slide_image) }}" class="we-15 position-absolute" style="right:0;bottom:0;">
                                </div>
                            @elseif(isset($x->slides[0])) 
                                <img src="{{ asset($x->slides[0]->slide_image) }}" class="we-20">
                            @else
                                <div class="we-20 fsz-6 text-center lh-1">No img</div>
                            @endif
                        </div>
                        <p class="m-0 fsz-9"><a href="{{ url('new-post/' . $x->post_public_id) }}" class="td-hover word-break">{{ $x->post_public_id }}</a> <br>{{ $x->post_id }} {!! ($x->post_id == $post->post_id) ? '<i class="text-secondary">now</i>' : '' !!}</p>
                    </div>
                @endforeach
            @else
                <p class="text-secondary m-0 fsz-12">No draft yet.</p>
            @endif
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let timeout = null;

    function autoSave() {
        clearTimeout(timeout); // Reset timeout untuk menghindari request berlebihan

        timeout = setTimeout(() => {
            let post_id = $("#post_id").val();
            let post_desc = $("#post_desc").val();

            $.ajax({
                url: "{{ url('new-post/desc/edit') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    post_id: post_id,
                    post_desc: post_desc
                },
                beforeSend: function() {
                    $("#saveStatus").text("Saving...");
                },
                success: function(response) {
                    $("#saveStatus").text("Saved ✔️");
                    setTimeout(() => $("#saveStatus").text(""), 2000);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $("#saveStatus").text("Failed to save ❌");
                }
            });
        }, 1000); // Kirim request setelah user berhenti mengetik selama 1 detik
    }
</script>


<!-- Tambahkan Cropper.js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<!-- Modal -->
<div class="modal fade" id="modalAddImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-light rounded-m">
            <div class="modal-header bg-clr2 text-light">
                <h3 class="modal-title fw-bold">Add Image</h3>
                <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('new-post/image/add') }}" method="post" id="formEditPhoto" enctype="multipart/form-data">
                    @csrf 
                    <input type="hidden" name="post_id" value="{{ $post->post_id }}">

                    <input type="file" name="slide_image" id="slide_image" class="form-control input-effect rounded-m" accept="image/*">

                    <div class="mt-3 text-center">
                        <img id="cropImage" src="#" class="d-none img-fluid rounded shadow-sm">
                    </div>
                    @error('slide_image')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror

                    <input type="hidden" name="slide_image_cropped" id="slide_image_cropped">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-clr2" id="crop-btn" disabled>Crop & Upload</button>
            </div>
        </div>
    </div>
</div>

<script>
let cropper;
document.getElementById('slide_image').addEventListener('change', function(event) {
    let file = event.target.files[0];

    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            let cropImage = document.getElementById('cropImage');
            cropImage.src = e.target.result;
            cropImage.classList.remove('d-none');

            // Hapus instance cropper sebelumnya jika ada
            if (cropper) {
                cropper.destroy();
            }

            // Inisialisasi Cropper.js
            cropper = new Cropper(cropImage, {
                aspectRatio: 1, // 1:1 untuk 1080x1080
                viewMode: 2,
                minContainerWidth: 300,
                minContainerHeight: 300,
                scalable: false,
                zoomable: false
            });

            document.getElementById('crop-btn').disabled = false; // Aktifkan tombol Crop
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('crop-btn').addEventListener('click', function() {
    if (cropper) {
        let canvas = cropper.getCroppedCanvas({
            width: 1080,
            height: 1080
        });

        canvas.toBlob(function(blob) {
            let reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                document.getElementById('slide_image_cropped').value = reader.result;

                document.getElementById('formEditPhoto').submit();
            };
        }, 'image/jpeg', 0.9);
    }
});


@if(session()->has('errors') && session('errors')->has('slide_image'))
    var myModal = new bootstrap.Modal(document.getElementById('modalAddImage'));
    myModal.show();
@endif
</script>
