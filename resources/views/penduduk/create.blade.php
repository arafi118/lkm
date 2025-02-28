<style>
    .select2-container .select2-selection--single .select2-selection__rendered {
        font-size: 14px;
        /* Default font size */
    }
</style>

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="fa fa-user-plus"></i>
            </div>
            <div><b>Form Register Pelanggan</b>
                <div class="page-title-subheading">
                    {{ Session::get('nama_lembaga') }}
                </div>
            </div>
        </div>
    </div>
</div>
<form action="/database/penduduk" method="post" id="Penduduk">
    @csrf

    <div class="row">
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="nik">NIK</label>
                <input autocomplete="off" maxlength="16" type="text" name="nik" id="nik"
                    class="form-control" value="{{ $nik }}">
                <small class="text-danger" id="msg_nik"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="nama_lengkap">Nama lengkap</label>
                <input autocomplete="off" type="text" name="nama_lengkap" id="nama_lengkap" class="form-control">
                <small class="text-danger" id="msg_nama_lengkap"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="nama_pangilan">Nama Panggilan</label>
                <input autocomplete="off" type="text" name="nama_pangilan" id="nama_pangilan" class="form-control">
                <small class="text-danger" id="msg_nama_pangilan"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input autocomplete="off" type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                    value="">
                <small class="text-danger" id="msg_tempat_lahir"></small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="position-relative mb-3">
                <label for="tgl_lahir">Tgl Lahir</label>
                <input autocomplete="off" type="text" name="tgl_lahir" id="tgl_lahir" class="form-control date"
                    value="{{ date('d/m/Y') }}">
                <small class="text-danger" id="msg_tgl_lahir"></small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="position-relative mb-3">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="createselect2 form-control" name="jenis_kelamin" id="jenis_kelamin">
                    <option>Pilih Jenis Kelamin</option>
                    <option {{ $jk_dipilih == 'L' ? 'selected' : '' }} value="L">Laki Laki</option>
                    <option {{ $jk_dipilih == 'P' ? 'selected' : '' }} value="P">Perempuan</option>
                </select>
                <small class="text-danger" id="msg_jenis_kelamin"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="no_kk">No. KK</label>
                <input autocomplete="off" type="text" name="no_kk" id="no_kk" class="form-control"
                    value="{{ substr($nik, 0, 6) }}">
                <small class="text-danger" id="msg_no_kk"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="alamat">Alamat KTP</label>
                <input autocomplete="off" type="text" name="alamat" id="alamat" class="form-control"
                    value="">
                <small class="text-danger" id="msg_alamat"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="domisi">Domisili saat ini</label>
                <input autocomplete="off" type="text" name="domisi" id="domisi" class="form-control">
                <small class="text-danger" id="msg_domisi"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="jenis_usaha" for="desa">Desa/Kelurahan</label>
                <select class="createselect2 form-control" name="desa" id="desa">
                    <option>Pilih Desa/Kelurahan</option>
                    @foreach ($desa as $ds)
                        <option {{ $desa_dipilih == $ds->kd_desa ? 'selected' : '' }} value="{{ $ds->kd_desa }}">
                            {{ $ds->sebutan_desa }} {{ $ds->nama_desa }} - {{ $ds->nama_kec }}
                        </option>
                    @endforeach
                </select>
                <small class="text-danger" id="msg_desa"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="no_telp">No. Telp</label>
                <input autocomplete="off" type="text" name="no_telp" id="no_telp" class="form-control"
                    value="08">
                <small class="text-danger" id="msg_no_telp"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="pendidikan">Pendidikan</label>
                <select class="createselect2 form-control" name="pendidikan" id="pendidikan">
                    <option value="">Pilih Pendidikan</option>
                    <option value="sd_mi">SD/MI</option>
                    <option value="smp_mts">SMP/MTs</option>
                    <option value="sma_smk_ma">SMA/SMK/MA</option>
                    <option value="diploma_1">Diploma 1 (D1)</option>
                    <option value="diploma_2">Diploma 2 (D2)</option>
                    <option value="diploma_3">Diploma 3 (D3)</option>
                    <option value="sarjana">Sarjana (S1)</option>
                    <option value="magister">Magister (S2)</option>
                    <option value="doktor">Doktor (S3)</option>
                </select>
                <small class="text-danger" id="msg_pendidikan"></small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="position-relative mb-3">
                <label for="agama">Agama</label>
                <select class="createselect2 form-control" name="agama" id="agama" class="form-control">
                    <option value="">Pilih Agama</option>
                    <option value="islam">Islam</option>
                    <option value="kristen_protestan">Kristen Protestan</option>
                    <option value="kristen_katolik">Kristen Katolik</option>
                    <option value="hindu">Hindu</option>
                    <option value="buddha">Buddha</option>
                    <option value="konghucu">Konghucu</option>
                </select>
                <small class="text-danger" id="msg_agama"></small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="position-relative mb-3">
                <label for="status_pernikahan">Status Pernikahan</label>
                <select class="createselect2 form-control" name="status_pernikahan" id="status_pernikahan"
                    class="form-control">
                    <option value="">Pilih Status</option>
                    <option value="lajang">Lajang</option>
                    <option value="menikah">Menikah</option>
                    <option value="cerai hidup">Cerai Hidup</option>
                    <option value="cerai mati">Cerai Mati</option>
                </select>
                <small class="text-danger" id="msg_status_pernikahan"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="nama_ibu">Nama Ibu Kandung</label>
                <input autocomplete="off" type="text" name="nama_ibu" id="nama_ibu" class="form-control">
                <small class="text-danger" id="msg_nama_ibu"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="tempat_kerja">Alamat Tempat Kerja</label>
                <input autocomplete="off" type="text" name="tempat_kerja" id="tempat_kerja"
                    class="form-control">
                <small class="text-danger" id="msg_tempat_kerja"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="jenis_usaha">Jenis Usaha</label>
                <input autocomplete="off" type="text" name="jenis_usaha" id="jenis_usaha" class="form-control">
                <small class="text-danger" id="msg_jenis_usaha"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="nik_penjamin">NIK Penjamin</label>
                <input autocomplete="off" type="text" name="nik_penjamin" id="nik_penjamin" class="form-control"
                    value="{{ substr($nik, 0, 6) }}" maxlength="16" minlength="16">
                <small class="text-danger" id="msg_nik_penjamin"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="penjamin">Penjamin</label>
                <input autocomplete="off" type="text" name="penjamin" id="penjamin" class="form-control">
                <small class="text-danger" id="msg_penjamin"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="hubungan">Hubungan</label>
                <select class="createselect2 form-control" name="hubungan" id="hubungan">
                    @foreach ($hubungan as $hb)
                        <option {{ $hubungan_dipilih == $hb->id ? 'selected' : '' }} value="{{ $hb->id }}">
                            {{ $hb->kekeluargaan }}
                        </option>
                    @endforeach
                </select>
                <small class="text-danger" id="msg_hubungan"></small>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="font-icon-wrapper">
            <p>
            <p><b>Catatan : </b> ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )</p>
            </p>
        </div>
    </div>
    <button type="submit" class="btn btn-github btn-sm float-end btn-dark mb-0" id="SimpanPenduduk">Simpan
        Penduduk</button>
</form>

<script>
    $(document).ready(function() {
        $('.createselect2').select2({
            theme: 'bootstrap4',
        });
    });

    // Function to set font size
    function setFontSize(size) {
        $('.select2-container .select2-selection--single .select2-selection__rendered').css('font-size', size + 'px');
    }

    $('.date').datepicker({
        dateFormat: 'dd/mm/yy'
    });
</script>
