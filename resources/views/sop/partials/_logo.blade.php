<div class="row">
    <div class="col-md-8"><br><br><br><br>
        <div class="card mt-4 border" data-animation="true">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <a class="d-block blur-shadow-image">
                    <img src="{{ asset('storage/logo/' . Session::get('logo')) }}" alt="img-blur-shadow"
                        class="img-fluid shadow border-radius-lg" id="previewLogo" style="width: 200px; height: auto;">
                </a>
                <div class="colored-shadow"
                    style="background-image: url(&quot;{{ asset('storage/logo/' . Session::get('logo')) }}&quot;);">
                </div>
            </div>
            <div class="card-body text-center pb-0">
                <div class="d-flex mt-n6 justify-content-end">
                    <!-- Menggunakan justify-content-end untuk posisi kanan -->
                    <button class="btn btn-sm btn-dark" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-original-title="Edit" id="EditLogo">
                        <i class="fa fa-edit text-lg"></i>&nbsp;Edit Logo
                    </button>
                </div>
            </div><br>
        </div>
    </div>
</div>
<form action="/pengaturan/logo/{{ $kec->id }}" method="post" enctype="multipart/form-data" id="FormLogo">
    @csrf
    @method('PUT')

    <input type="file" name="logo_kec" id="logo_kec" class="d-none">
</form>
