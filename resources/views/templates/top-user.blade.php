<div class="d-flex flex-column w-100 overflow-hidden m-0 p-0" style="height:100vh;">
    <div class="bg-clrw row m-0 p-0 justify-content-center w-100">
        <div class="col-11 col-md-10 col-xl-8 m-0 p-0" style="max-width:1200px;">
            <div class="d-flex align-items-center my-2">
                <img src="{{ asset('assets/img/logo-purple-text.png') }}" class="he-25 img-death">
                <form action="{{ url('search') }}" method="post" class="ms-auto">
                    @csrf 
                    <div class="position-relative" style="width:220px;">
                        <i class="fas fa-search position-absolute translate-center fsz-10 text-secondary" style="top:52%;left:16px;"></i>
                        <input name="k" type="text" autocomplete="off" class="fsz-11 m-0 rounded-s input-effect bg-light he-28 pe-2 no-space no-capital w-100" style="padding-left:27px;" placeholder="Search">
                    </div>
                </form>            
            </div>
        </div>
    </div>
    <div class="bg-clrsec flex-grow-1 overflow-scroll row m-0 p-0 justify-content-center w-100">
        <div class="col-11 col-md-10 col-xl-8 m-0 p-0 pt-3 pb-5" style="max-width:1200px;">