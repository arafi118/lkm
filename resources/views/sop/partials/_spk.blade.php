<form action="/pengaturan/spk/{{ $kec->id }}" method="post" id="FormSPK">
    @csrf
    @method('PUT')

    <div id="editor">
        <p>1.</p>
        <p><br /></p>
      </div>

      <textarea name="spk" id="spk" class="d-none"></textarea>

</form><br>

<div class="d-flex justify-content-end">
    <button type="button" id="SimpanSPK" data-target="#FormSPK" class="btn btn-sm btn-dark mb-0 btn-simpan ">
        Simpan Perubahan
    </button>
</div>

<script>
    var quill = new Quill('#editor', {
            theme: 'snow'
        });
  </script>