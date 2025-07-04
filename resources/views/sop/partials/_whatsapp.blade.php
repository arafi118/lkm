@php
    $pesan_wa = json_decode($kec->whatsapp, true);
@endphp

<form action="/pengaturan/pesan_whatsapp/{{ $kec->id }}" method="post" id="FormScanWhatsapp">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="position-relative mb-3">
                <label class="form-label" for="tagihan">Pesan Tagihan</label>
                <textarea class="form-control" name="tagihan" id="tagihan" cols="20" rows="10">{!! $pesan_wa['tagihan'] !!}</textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="position-relative mb-3">
                <label class="form-label" for="angsuran">Pesan Angsuran</label>
                <textarea class="form-control" name="angsuran" id="angsuran" cols="20" rows="10">{!! $pesan_wa['angsuran'] !!}</textarea>
            </div>
        </div>
    </div>
</form>


<div class="d-flex justify-content-end">
    @if (auth()->user()->level == '1' && auth()->user()->jabatan == '1')
        <button type="button" id="ScanWA" class="btn btn-sm btn-info mb-0">
            Scan Whatsapp
        </button>
    @endif
    &nbsp;
    <button type="button" id="SimpanWhatsapp" data-target="#FormScanWhatsapp"
        class="btn btn-sm btn-dark mb-0 btn-simpan">
        Simpan Perubahan
    </button>
</div>
