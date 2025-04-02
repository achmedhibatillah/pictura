<div class="row m-0 p-0">
    <div class="col-md-7 m-0 p-0 pe-1">
        <div class="card m-0 p-3">
            <p class="m-0">New post</p>
            <hr>
            @if($slides->isNotEmpty())
            hi 
            @else
                <p class="text-secondary m-0 fsz-12">No images added yet.</p>
            @endif
            <div class="d-flex mt-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalAddImage" class="btn btn-clr1 btn-sm">Add image<i class="fas fa-image ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAddImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-light rounded-m">
            <div class="modal-header bg-clr2 text-light">
                <h3 class="modal-title fw-bold">Add image</h3>
                <button type="button" class="ms-auto hover bg-clr2 border-light text-light rounded-circle he-28 we-28" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="{{ url('new-post/image/add') }}" method="post" id="formEditPhoto">
                    @csrf 
                    <input type="file" name="slide_image" id="slide_image">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-clr2" onclick="submitAddImageForm()">Add</button>
            </div>
        </div>
    </div>
</div>

<script>
@if(session()->has('errors') && (session('errors')->has('slide_image')))
    var myModal = new bootstrap.Modal(document.getElementById('modalAddImage'));
    myModal.show();
@endif

function submitAddImageForm() { document.getElementById('formEditPhoto').submit(); }
</script>