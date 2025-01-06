<form action="/database/kelompok" method="post" id="FormRegistrasiKelompok">
    @csrf
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="desa" class="form-label">Desa/Kelurahan</label>
                <select class="form-select" name="desa" id="desa">
                    @foreach ($desa as $ds)
                        <option {{ $desa_dipilih == $ds->kd_desa ? 'selected' : '' }} value="{{ $ds->kd_desa }}">
                            {{ $ds->sebutan_desa->sebutan_desa }} {{ $ds->nama_desa }}
                        </option>
                    @endforeach
                </select>
                <small class="text-danger" id="msg_desa"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="kode_kelompok" class="form-label">Kode Kelompok</label>
                <input autocomplete="off" type="text" name="kode_kelompok" id="kode_kelompok" class="form-control"
                    readonly>
                <small class="text-danger" id="msg_kode_kelompok"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="nama_kelompok" class="form-label">Nama Kelompok</label>
                <input autocomplete="off" type="text" name="nama_kelompok" id="nama_kelompok" class="form-control">
                <small class="text-danger" id="msg_nama_kelompok"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="jenis_produk_pinjaman" class="form-label">Jenis Produk
                    Pinjaman</label>
                <select class="form-select" name="jenis_produk_pinjaman" id="jenis_produk_pinjaman">
                    @foreach ($jenis_produk_pinjaman as $jpp)
                        <option value="{{ $jpp->id }}">
                            {{ $jpp->nama_jpp }} ({{ $jpp->deskripsi_jpp }})
                        </option>
                    @endforeach
                </select>
                <small class="text-danger" id="msg_jenis_produk_pinjaman"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="alamat_kelompok" class="form-label">Alamat Kelompok</label>
                <input autocomplete="off" type="text" name="alamat_kelompok" id="alamat_kelompok"
                    class="form-control">
                <small class="text-danger" id="msg_alamat_kelompok"></small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="exampleState" class="form-label">No. HP (Aktif WA)</label>
                <input autocomplete="off" type="text" name="telpon" id="telpon" class="form-control"
                    value="628">
                <small class="text-danger" id="msg_telpon"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="position-relative mb-3">
                <label for="tgl_berdiri" class="form-label">Tgl Berdiri</label>
                <input autocomplete="off" type="text" name="tgl_berdiri" id="tgl_berdiri" class="form-control date">
                <small class="text-danger" id="msg_tgl_berdiri"></small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="position-relative mb-3">
                <label for="ketua" class="form-label">Nama Ketua</label>
                <input autocomplete="off" type="text" name="ketua" id="ketua" class="form-control">
                <small class="text-danger" id="msg_ketua"></small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="position-relative mb-3">
                <label for="sekretaris" class="form-label">Nama Sekretaris</label>
                <input autocomplete="off" type="text" name="sekretaris" id="sekretaris" class="form-control">
                <small class="text-danger" id="msg_sekretaris"></small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="position-relative mb-3">
                <label for="bendahara" class="form-label">Nama Bendahara</label>
                <input autocomplete="off" type="text" name="bendahara" id="bendahara" class="form-control">
                <small class="text-danger" id="msg_bendahara"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="position-relative mb-3">
                <label for="jenis_usaha" class="form-label">Jenis Usaha</label>
                <select class="form-select" name="jenis_usaha" id="jenis_usaha">
                    @foreach ($jenis_usaha as $ju)
                        <option value="{{ $ju->id }}">
                            {{ $ju->nama_ju }} ({{ $ju->deskripsi_ju }})
                        </option>
                    @endforeach
                </select>
                <small class="text-danger" id="msg_jenis_usaha"></small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="position-relative mb-3">
                <label for="jenis_kegiatan" class="form-label">Jenis Kegiatan</label>
                <select class="form-select" name="jenis_kegiatan" id="jenis_kegiatan">
                    @foreach ($jenis_kegiatan as $jk)
                        <option value="{{ $jk->id }}">
                            {{ $jk->nama_jk }} ({{ $jk->deskripsi_jk }})
                        </option>
                    @endforeach
                </select>
                <small class="text-danger" id="msg_jenis_kegiatan"></small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="position-relative mb-3">
                <label for="tingkat_kelompok" class="form-label">Tingkat Kelompok</label>
                <select class="form-control" name="tingkat_kelompok" id="tingkat_kelompok">
                    @foreach ($tingkat_kelompok as $tk)
                        <option value="{{ $tk->id }}">
                            {{ $tk->nama_tk }} ({{ $tk->deskripsi_tk }})
                        </option>
                    @endforeach
                </select>
                <small class="text-danger" id="msg_tingkat_kelompok"></small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="position-relative mb-3">
                <label for="fungsi_kelompok" class="form-label">Fungsi Kelompok</label>
                <select class="form-control" name="fungsi_kelompok" id="fungsi_kelompok">
                    @foreach ($fungsi_kelompok as $fk)
                        <option value="{{ $fk->id }}">
                            {{ $fk->nama_fgs }} ({{ $fk->deskripsi_fgs }})
                        </option>
                    @endforeach
                </select>
                <small class="text-danger" id="msg_fungsi_kelompok"></small>
            </div>
        </div>
    </div>
</form><br>
<button type="submit" id="SimpanKelompok" class=" btn btn-dark btn-sm">Simpan Kelompok</button>
