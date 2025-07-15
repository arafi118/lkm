<form action="/pengaturan/kustomisasi_calk/{{ $kec->id }}" method="post" id="FormCalk">
    @csrf
    @method('PUT')

    <textarea name="editor_calk" id="editor_calk">{!! json_decode($kec->custom_calk, true) !!}</textarea>
    <textarea name="custom_calk" id="custom_calk" class="d-none"></textarea>
</form>

<div class="d-flex justify-content-end mt-3">
    <button type="button" data-bs-toggle="modal" data-bs-target="#keyword" class="btn btn-info btn-sm">
        Kata Kunci
    </button>
    <button type="button" id="SimpanCalk" data-target="#FormCalk" class="btn btn-sm btn-dark ms-2 mb-0 btn-simpan ">
        Simpan Perubahan
    </button>
</div>
