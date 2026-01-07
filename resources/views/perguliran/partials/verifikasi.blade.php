<form action="/perguliran/{{ $perguliran->id }}" method="post" id="FormInput">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-12">
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
    </div>

    <div class="row">
        <div class="col-md-12">
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
                            @endphp
                            @foreach ($perguliran->pinjaman_anggota as $pinjaman_anggota)
                                @php
                                    $proposal += $pinjaman_anggota->proposal;
                                    $verifikasi += $pinjaman_anggota->verifikasi;
                                @endphp
                                <tr>
                                    <td align="center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ ucwords($pinjaman_anggota->anggota->namadepan) }}
                                        ({{ $pinjaman_anggota->nia }})
                                    </td>
                                    <td>
                                        <input type="text" disabled readonly
                                            class="form-control money"
                                            value="{{ number_format($pinjaman_anggota->proposal, 2) }}">
                                    </td>
                                    <td>
                                        <input type="text" id="{{ $pinjaman_anggota->id }}"
                                            name="idpa_proposal[{{ $pinjaman_anggota->id }}]"
                                            class="form-control money idpa_proposal"
                                            value="{{ number_format($pinjaman_anggota->verifikasi, 2) }}">
                                    </td>
                                    <td>
                                        <input type="text" name="idpa[{{ $pinjaman_anggota->id }}]"
                                            class="form-control money idpa idpa-{{ $pinjaman_anggota->id }}"
                                            value="{{ number_format($pinjaman_anggota->verifikasi, 2) }}">
                                        <input type="hidden" name="catatan[{{ $pinjaman_anggota->id }}]"
                                            value="{{ $perguliran->catatan_verifikasi }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Jumlah</th>
                                <th>
                                    {{ number_format($proposal, 2) }}
                                </th>
                                <th id="jumlah">
                                    {{ number_format($verifikasi, 2) }}
                                </th>
                                <th>
                                    <span id="_alokasi">{{ number_format($verifikasi, 2) }}</span>
                                    <input type="hidden" name="__alokasi" id="__alokasi"
                                        value="{{ $verifikasi }}">
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Input Keputusan Pendanaan</h5>
                        <input type="hidden" name="_id" id="_id" value="{{ $perguliran->id }}">
                        <input type="hidden" name="status" id="status" value="W">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="tgl_cair" class="form-label">Tgl Cair</label>
                                    <input name="tgl_cair" id="tgl_cair" type="text"
                                        class="form-control date" placeholder="dd/mm/yyyy"
                                        value="{{ Tanggal::tglIndo($perguliran->tgl_cair) }}">
                                    <small class="text-danger" id="msg_tgl_cair"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="alokasi" class="form-label">Alokasi</label>
                                    <input type="text" class="form-control money" name="alokasi" id="alokasi"
                                        value="{{ number_format($perguliran->verifikasi, 2) }}">
                                    <small class="text-danger" id="msg_alokasi"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="jangka" class="form-label">Jangka (Bulan)</label>
                                    <input type="number" class="form-control" name="jangka" id="jangka"
                                        value="{{ $perguliran->jangka }}">
                                    <small class="text-danger" id="msg_jangka"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="pros_jasa" class="form-label">Prosentase Jasa (%)</label>
                                    <input type="number" step="0.01" class="form-control" name="pros_jasa"
                                        id="pros_jasa" value="{{ $perguliran->pros_jasa }}">
                                    <small class="text-danger" id="msg_pros_jasa"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="jenis_jasa" class="form-label">Jenis Jasa</label>
                                    <select class="selectverifikasi form-control" name="jenis_jasa"
                                        id="jenis_jasa">
                                        @foreach ($jenis_jasa as $jj)
                                            <option {{ $jj->id == $perguliran->jenis_jasa ? 'selected' : '' }}
                                                value="{{ $jj->id }}">
                                                {{ $jj->nama_jj }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="msg_jenis_jasa"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="sistem_angsuran_pokok" class="form-label">Sistem Ang. Pokok</label>
                                    <select class="selectverifikasi form-control" name="sistem_angsuran_pokok"
                                        id="sistem_angsuran_pokok">
                                        @foreach ($sistem_angsuran as $sa)
                                            <option {{ $sa->id == $perguliran->sa_pokok ? 'selected' : '' }}
                                                value="{{ $sa->id }}">
                                                {{ $sa->nama_sistem }} ({{ $sa->deskripsi_sistem }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="msg_sistem_angsuran_pokok"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="sistem_angsuran_jasa" class="form-label">Sistem Ang. Jasa</label>
                                    <select class="selectverifikasi form-control" name="sistem_angsuran_jasa"
                                        id="sistem_angsuran_jasa">
                                        @foreach ($sistem_angsuran as $sa)
                                            <option {{ $sa->id == $perguliran->sa_jasa ? 'selected' : '' }}
                                                value="{{ $sa->id }}">
                                                {{ $sa->nama_sistem }} ({{ $sa->deskripsi_sistem }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="msg_sistem_angsuran_jasa"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="position-relative mb-3">
                                    <label for="catatan_verifikasi" class="form-label">Catatan Verifikasi</label>
                                    <textarea class="form-control" name="catatan_verifikasi" id="catatan_verifikasi" rows="3"
                                        placeholder="Catatan" spellcheck="false">{{ $perguliran->catatan_verifikasi }}</textarea>
                                    <small class="text-danger" id="msg_catatan_verifikasi"></small>
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
                                    Simpan Keputusan Pendanaan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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

    $('.selectverifikasi').select2({
        theme: 'bootstrap4'
    });

    $(".money").maskMoney();

    $(".date").flatpickr({
        dateFormat: "d/m/Y"
    })

    $('.idpa_proposal').change(function(e) {

        var idpa = $(this).attr('id')
        var value = $(this).val()

        $.ajax({
            url: '/pinjaman_anggota/' + idpa,
            type: 'post',
            data: {
                '_method': 'PUT',
                'idpa': idpa,
                'verifikasi': value,
                'status': 'V',
                '_token': $('[name=_token]').val()
            },
            success: function(result) {
                var total = 0;
                $('.idpa_proposal').map(function() {
                    var idpa = $(this).attr('id')
                    var value = $(this).val()

                    $('.idpa-' + idpa).val(value)

                    value = value.split(',').join('')
                    value = value.split('.00').join('')
                    value = parseFloat(value)

                    total += value

                })

                $('#jumlah').html(result.jumlah)
                $('#alokasi').val(result.jumlah)
                $('#_alokasi').html(result.jumlah)
                $('#__alokasi').val(result.jumlah)
            }
        })
    })

    $(document).on('change', '.idpa', function(e) {
        var total = 0;
        $('.idpa').map(function() {
            var value = $(this).val()
            if (value == '') {
                value = 0
            } else {
                value = value.split(',').join('')
                value = value.split('.00').join('')
            }

            value = parseFloat(value)

            total += value
        })

        $('#__alokasi').val(total)
        $('#_alokasi').html(formatter.format(total))
        $('#alokasi').val(formatter.format(total))
    })

    $(document).on('click', '#Simpan', async function(e) {
        e.preventDefault()
        $('small').html('')

        var alokasi = parseInt($('#alokasi').val().split(',').join('').split('.00').join(''))
        var __alokasi = parseInt($('#__alokasi').val())

        var lanjut = true;
        if (alokasi != __alokasi) {
            lanjut = await Swal.fire({
                title: 'Peringatan',
                text: 'Jumlah alokasi Anggota dan Kelompok Berbeda. Tetap lanjutkan?',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Batal',
                icon: 'warning'
            }).then((result) => {
                if (result.isConfirmed) {
                    return true;
                }

                return false
            })
        }

        if (lanjut) {
            var form = $('#FormInput')
            $.ajax({
                type: 'POST',
                url: form.attr('action') + '?save=true',
                data: form.serialize(),
                success: function(result) {
                    Swal.fire('Berhasil', result.msg, 'success').then(() => {
                        window.location.href = '/detail/' + result.id
                    })
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
