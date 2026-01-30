<form action="/perguliran/{{ $perguliran->id }}" method="post" id="FormInput">
    @csrf
    @method('PUT')

    @if ($pinj_a['jumlah_pinjaman'] > 0)
        <div class="alert border border-danger text-danger" role="alert">
            <span class="text-sm">
                <b>Anggota Kelompok</b>
                terdeteksi memiliki kewajiban angsuran pinjaman
            </span>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th align="center" width="10"><span class="text-danger">No</span></th>
                    <th align="center"><span class="text-danger">Nama</span></th>
                    <th><span class="text-danger">Loan ID.</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pinj_a['pinjaman'] as $pa)
                    <tr>
                        <td align="center">
                            <span class="text-danger">
                                {{ $loop->iteration }}
                            </span>
                        </td>
                        <td align="left">
                            <span class="text-danger">
                                {{ ucwords(strtolower($pa->anggota->namadepan)) }} ({{ $pa->nia }})
                            </span>
                        </td>
                        <td>
                            <a href="/detail/{{ $pa->id_pinkel }}" target="_blank"
                                class="text-danger text-gradient font-weight-bold">
                                {{ $pa->kelompok ? $pa->kelompok->nama_kelompok : '-' }} Loan ID. {{ $pa->id_pinkel }}
                            </a>.
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($pinj_a['jumlah_pemanfaat'] > 0)
        <div class="alert border border-danger text-danger" role="alert">
            <span class="text-sm">
                Salah satu anggota pemanfaat masih terdaftar pada pinjaman di kecamatan lain
            </span>
        </div>
    @endif

    @if ($pinj_a['jumlah_kelompok'] > 0)
        @foreach ($pinj_a['kelompok'] as $kel)
            <div class="alert border border-danger text-danger" role="alert">
                <span class="text-sm">
                    <b>Kelompok {{ ucwords(strtolower($kel->kelompok->nama_kelompok)) }}</b> masih memiliki kewajiban
                    angsuran pinjaman dengan
                    <a href="/detail/{{ $kel->id }}" target="_blank" class="font-weight-bold">
                        <span class="text-danger">Loan ID. {{ $kel->id }}</span>
                    </a>.
                </span>
            </div>
        @endforeach
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="card-title">Proposal</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">Tgl Pengajuan
                                            <div class="badge angka-warna-biru">
                                                {{ Tanggal::tglIndo($perguliran->tgl_proposal) }}
                                            </div>
                                        </li>
                                        <li class="list-group-item">Pengajuan
                                            <div class="badge angka-warna-biru">
                                                {{ number_format($perguliran->proposal) }}
                                            </div>
                                        </li>
                                        <li class="list-group-item">Jenis Jasa
                                            <div class="badge angka-warna-biru">
                                                {{ $perguliran->jasa->nama_jj }}
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="col">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="card-title">&nbsp;</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">Jasa
                                            <div class="badge angka-warna-biru">
                                                {{ $perguliran->pros_jasa . '% / ' . $perguliran->jangka . ' bulan' }}
                                            </div>
                                        </li>
                                        <li class="list-group-item">Angs. Pokok
                                            <div class="badge angka-warna-biru">
                                                {{ $perguliran->sis_pokok->nama_sistem }}
                                            </div>
                                        </li>
                                        <li class="list-group-item">Angs. Jasa
                                            <div class="badge angka-warna-biru">
                                                {{ $perguliran->sis_jasa->nama_sistem }}
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="card-title">Verified</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">Tgl Verifikasi
                                            <div class="badge angka-warna-merah">
                                                {{ Tanggal::tglIndo($perguliran->tgl_verifikasi) }}
                                            </div>
                                        </li>
                                        <li class="list-group-item">Verifikasi
                                            <div class="badge angka-warna-merah">
                                                {{ number_format($perguliran->verifikasi) }}
                                            </div>
                                        </li>
                                        <li class="list-group-item">Jenis Jasa
                                            <div class="badge angka-warna-merah">
                                                {{ $perguliran->jasa->nama_jj }}
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="col">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="card-title">&nbsp;</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">Jasa
                                            <div class="badge angka-warna-merah">
                                                {{ $perguliran->pros_jasa . '% / ' . $perguliran->jangka . ' bulan' }}
                                            </div>
                                        </li>
                                        <li class="list-group-item">Angs. Pokok
                                            <div class="badge angka-warna-merah">
                                                {{ $perguliran->sis_pokok->nama_sistem }}
                                            </div>
                                        </li>
                                        <li class="list-group-item">Angs. Jasa
                                            <div class="badge angka-warna-merah">
                                                {{ $perguliran->sis_jasa->nama_sistem }}
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="card-title">Waiting</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">Tgl Penetapan
                                            <div class="badge angka-warna-kuning">
                                                {{ Tanggal::tglIndo($perguliran->tgl_tunggu) }}
                                            </div>
                                        </li>
                                        <li class="list-group-item">Alokasi
                                            <div class="badge angka-warna-kuning">
                                                {{ number_format($perguliran->alokasi) }}
                                            </div>
                                        </li>
                                        <li class="list-group-item">Jenis Jasa
                                            <div class="badge angka-warna-kuning">
                                                {{ $perguliran->jasa->nama_jj }}
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="col">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="card-title">&nbsp;</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">Jasa
                                            <div class="badge angka-warna-kuning">
                                                {{ $perguliran->pros_jasa . '% / ' . $perguliran->jangka . ' bulan' }}
                                            </div>
                                        </li>
                                        <li class="list-group-item">Angs. Pokok
                                            <div class="badge angka-warna-kuning">
                                                {{ $perguliran->sis_pokok->nama_sistem }}
                                            </div>
                                        </li>
                                        <li class="list-group-item">Angs. Jasa
                                            <div class="badge angka-warna-kuning">
                                                {{ $perguliran->sis_jasa->nama_sistem }}
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (!($perguliran->jenis_pp == '3' && $perguliran->kelompok->fungsi_kelompok == '2'))
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-items-center mb-0" width="100%">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Pengajuan</th>
                                <th>Verifikasi</th>
                                <th>Alokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $proposal = 0;
                                $verifikasi = 0;
                                $alokasi = 0;
                            @endphp
                            @foreach ($perguliran->pinjaman_anggota as $pinjaman_anggota)
                                @php
                                    $proposal += $pinjaman_anggota->proposal;
                                    $verifikasi += $pinjaman_anggota->verifikasi;
                                    $alokasi += $pinjaman_anggota->alokasi;
                                @endphp
                                <tr>
                                    <td align="center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ ucwords($pinjaman_anggota->anggota->namadepan) }}
                                        ({{ $pinjaman_anggota->nia }})
                                    </td>
                                    <td>
                                        {{ number_format($pinjaman_anggota->proposal) }}
                                    </td>
                                    <td>
                                        {{ number_format($pinjaman_anggota->verifikasi) }}
                                    </td>
                                    <td>
                                        {{ number_format($pinjaman_anggota->alokasi) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Jumlah</th>
                                <th>{{ number_format($proposal) }}</th>
                                <th>{{ number_format($verifikasi) }}</th>
                                <th>{{ number_format($alokasi) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="card card-body p-2 pb-0 mb-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-grid">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#CetakDokumenProposal"
                            class="btn btn-info btn-sm mb-2">Cetak Dokumen Proposal</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-grid">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#CetakDokumenPencairan"
                            class="btn btn-info btn-sm mb-2">Cetak Dokumen Pencairan</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Input Realisasi Pencairan</h5>
            <input type="hidden" name="_id" id="_id" value="{{ $perguliran->id }}">
            <input type="hidden" name="status" id="status" value="A">
            <input type="hidden" name="debet" id="debet" value="{{ $debet }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="position-relative mb-3">
                        <label for="tgl_cair" class="form-label">Tgl Cair</label>
                        <input autocomplete="off" type="text" name="tgl_cair" id="tgl_cair"
                            class="form-control date" value="{{ Tanggal::tglIndo($perguliran->tgl_cair) }}">
                        <small class="text-danger" id="msg_tgl_cair"></small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-relative mb-3">
                        <label for="alokasi" class="form-label">Alokasi Rp.</label>
                        <input autocomplete="off" readonly type="text" name="alokasi" id="alokasi"
                            class="form-control money" value="{{ number_format($perguliran->alokasi, 2) }}">
                        <small class="text-danger" id="msg_alokasi"></small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-relative mb-3">
                        <label class="form-label" for="sumber_pembayaran">Sumber Pembayaran (Kredit)</label>
                        <select class="selectwaiting form-control" name="sumber_pembayaran" id="sumber_pembayaran">
                            @foreach ($sumber_bayar as $sb)
                                <option value="{{ $sb->kode_akun }}">
                                    {{ $sb->kode_akun }}. {{ $sb->nama_akun }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="msg_sistem_angsuran_jasa"></small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-end" style="gap: .5em;">
                    <button type="button" id="tidakLayakDicairkan" class="btn btn-danger btn-sm">
                        Tidak Layak
                    </button>

                    <button type="button" id="kembaliProposal" class="btn btn-warning btn-sm">
                        Kembalikan Ke Proposal
                    </button>

                    <button type="button" id="Simpan" class="btn btn-primary btn-sm">
                        Posting Pencairan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<form action="/perguliran/kembali_proposal/{{ $perguliran->id }}" method="post" id="formKembaliProposal">
    @csrf
</form>

<form action="/perguliran/tidak_layak_cair/{{ $perguliran->id }}?save=true" method="post"
    id="formTidakLayakDicairkan">
    @csrf
</form>

<script>
    var formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    })

    $('.selectwaiting').select2({
        theme: 'bootstrap4'
    });

    $(".money").maskMoney();

    $(".date").flatpickr({
        dateFormat: "d/m/Y"
    })

    $(document).on('click', '#Simpan', async function(e) {
        e.preventDefault()
        $('small').html('')

        var alokasi = parseInt($('#alokasi').val().split(',').join('').split('.00').join(''))
        var __alokasi = parseInt($('#__alokasi').val())

        var lanjut = true;
        lanjut = await Swal.fire({
            title: 'Peringatan',
            text: 'Anda akan melakukan Pencairan Piutang sebesar Rp. ' + $('#alokasi').val().split(
                    '.00').join('') +
                ' untuk kelompok tersebut? Setelah klik tombol Lanjutkan data tidak dapat diubah kembali !',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal',
            icon: 'warning'
        }).then((result) => {
            if (result.isConfirmed) {
                return true
            }

            return false
        })

        if (lanjut) {
            var form = $('#FormInput')
            $.ajax({
                type: 'POST',
                url: form.attr('action') + '?save=true',
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire('Berhasil', result.msg, 'success').then(() => {
                            window.location.href = '/detail/' + result.id
                        })
                    } else {
                        Swal.fire('Error', result.msg, 'error')
                    }
                },
                error: function(result) {
                    const respons = result.responseJSON;

                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error')
                    $.map(respons, function(res, key) {
                        $('#' + key).parent('.input-group.input-group-static')
                            .addClass(
                                'is-invalid')
                        $('#msg_' + key).html(res)
                    })
                }
            })
        }
    })

    $(document).on('click', '#kembaliProposal', function(e) {
        e.preventDefault()

        Swal.fire({
            title: 'Peringatan',
            text: 'Anda akan mengembalikan data ke tahap proposal',
            showCancelButton: true,
            confirmButtonText: 'Kembalikan',
            cancelButtonText: 'Batal',
            icon: 'warning'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('#formKembaliProposal')

                $.ajax({
                    type: 'post',
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(result) {
                        Swal.fire('Berhasil', result.msg, 'success').then(() => {
                            window.location.href = '/detail/' + result.id
                        })
                    }
                })
            }
        })
    })

    $(document).on('click', '#tidakLayakDicairkan', function(e) {
        e.preventDefault()

        Swal.fire({
            title: 'Peringatan',
            text: 'Anda akan menandai pinjaman ini sebagai tidak layak dicairkan',
            showCancelButton: true,
            confirmButtonText: 'Tandai',
            cancelButtonText: 'Batal',
            icon: 'warning'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('#formTidakLayakDicairkan')

                $.ajax({
                    type: 'post',
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(result) {
                        Swal.fire('Berhasil', result.msg, 'success').then(() => {
                            window.location.href = '/perguliran'
                        })
                    }
                })
            }
        })
    })
</script>
