<form action="/pengaturan/spk/{{ $kec->id }}" method="post" id="FormSPK">
    @csrf
    @method('PUT')

    <textarea name="editor_spk" id="editor_spk">{!! json_decode($kec->redaksi_spk, true) !!}</textarea>
    <textarea name="spk" id="spk" class="d-none"></textarea>
</form>

<div class="d-flex justify-content-end">
    <button type="button" id="SimpanSPK" data-target="#FormSPK" class="btn btn-sm btn-dark mb-0 btn-simpan ">
        Simpan Perubahan
    </button>
</div>
