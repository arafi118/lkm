
<form action="/pengaturan/simpanan/{{ $kec->id }}" method="post" id="FormSimpanan">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="position-relative mb-3">
                <label for="min_bunga" class="form-label">Minimal Saldo untuk mendapatkan Bunga (Rp.)</label>
                <input autocomplete="off" type="number" name="min_bunga" id="min_bunga" class="form-control"
                    value="{{ $kec->min_bunga }}">
                <small class="text-danger" id="msg_min_bunga"></small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="position-relative mb-3">
                <label for="min_pajak" class="form-label">Minimal Bunga untuk terkena Pajak (Rp.)</label>
                <input autocomplete="off" type="number" name="min_pajak" id="min_pajak" class="form-control"
                    value="{{ $kec->min_pajak }}">
                <small class="text-danger" id="msg_min_pajak"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="position-relative mb-3">
                <label for="def_bunga" class="form-label">Default Bunga (%)</label>
                <input autocomplete="off" type="number" name="def_bunga" id="def_bunga" class="form-control"
                    value="{{ $kec->def_bunga }}">
                <small class="text-danger" id="msg_def_bunga"></small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="position-relative mb-3">
                <label for="def_pajak" class="form-label">Default Pajak (%)</label>
                <input autocomplete="off" type="number" name="def_pajak" id="def_pajak" class="form-control"
                    value="{{ $kec->def_pajak }}">
                <small class="text-danger" id="msg_def_pajak"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="position-relative mb-3">
                <label for="def_admin_simp" class="form-label">Default Admin Bulanan (Rp.)</label>
                <input autocomplete="off" type="number" name="def_admin_simp" id="def_admin_simp" class="form-control"
                    value="{{ $kec->def_admin_simp }}">
                <small class="text-danger" id="msg_def_admin_simp"></small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="position-relative mb-3">
                <label for="def_admin_buka" class="form-label">Default Admin Buka Rekening (Rp.)</label>
                <input autocomplete="off" type="number" name="def_admin_buka" id="def_admin_buka" class="form-control"
                    value="{{ $kec->def_admin_buka }}">
                <small class="text-danger" id="msg_def_admin_buka"></small>
            </div>
        </div>
    </div>
</form>

<div class="d-flex justify-content-end">
    <button type="button" id="SimpanSimpanan" data-target="#FormSimpanan" class="btn btn-secondary mb-0 btn-simpan">
        Simpan Perubahan
    </button>
</div>
