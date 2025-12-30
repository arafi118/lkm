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

        <div class="card card-body p-2 pb-0 mb-3">
                <div class="d-grid">
                    <button type="button" id="BtnTambahPemanfaat" data-bs-toggle="modal"
                        data-bs-target="#TambahPemanfaat" class="btn btn-success btn-sm mb-2 btn-shadow me-3">
                        Tambah Pemanfaat
                    </button>
                </div>
        </div>

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
                                <th>Catatan</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $proposal = 0;
                            @endphp
                            @foreach ($perguliran->pinjaman_anggota as $pinjaman_anggota)
                                @php
                                    $proposal += $pinjaman_anggota->proposal;

                                    $class1 = '';
                                    $class2 = '';
                                    if (in_array('tahapan_perguliran.proposal.edit_proposal', Session::get('tombol'))) {
                                        $class1 = 'idpa_proposal';
                                    }

                                    if (
                                        in_array(
                                            'tahapan_perguliran.proposal.simpan_rekom_verifikator',
                                            Session::get('tombol'),
                                        )
                                    ) {
                                        $class2 = 'idpa';
                                    }
                                @endphp
                                <tr>
                                    <td align="center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ ucwords($pinjaman_anggota->anggota->namadepan) }}
                                        ({{ $pinjaman_anggota->nia }})
                                    </td>
                                    <td>
                                        <input type="text" id="{{ $pinjaman_anggota->id }}"
                                            name="idpa_proposal[{{ $pinjaman_anggota->id }}]"
                                            class="form-control money {{ $class1 }}"
                                            value="{{ number_format($pinjaman_anggota->proposal, 2) }}">
                                    </td>
                                    <td>
                                        <input type="text" name="idpa[{{ $pinjaman_anggota->id }}]"
                                            class="form-control money {{ $class2 }} idpa-{{ $pinjaman_anggota->id }}"
                                            value="{{ number_format($pinjaman_anggota->proposal, 2) }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="catatan[{{ $pinjaman_anggota->id }}]" value="">
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" id="{{ $pinjaman_anggota->id }}"
                                                class="btn btn-icon btn-sm btn-danger HapusPinjamanAnggota">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Jumlah</th>
                                <th id="jumlah">
                                    {{ number_format($proposal, 2) }}
                                </th>
                                <th>
                                    <span id="_verifikasi">{{ number_format($proposal, 2) }}</span>
                                    <input type="hidden" name="__verifikasi" id="__verifikasi"
                                        value="{{ $proposal }}">
                                </th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    <div class="card card-body p-2 pb-0 mb-3">
        <div class="d-grid">
            <button type="button" data-bs-toggle="modal" data-bs-target="#CetakDokumenProposal"
                class="btn btn-info btn-sm mb-2 btn-shadow me-3">Cetak Dokumen Proposal</button>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Input Rekom Verifikator</h5>
                    <input type="hidden" name="_id" id="_id" value="{{ $perguliran->id }}">
                    <input type="hidden" name="status" id="status" value="V">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="DOMContentLoaded position-relative mb-3">
                                <label for="tgl_verifikasi" class="form-label">Tgl Verifikasi</label>
                                <input autocomplete="off" type="text" name="tgl_verifikasi" id="tgl_verifikasi"
                                    class="form-control date" value="{{ date('d/m/Y') }}">
                                <small class="text-danger" id="msg_tgl_verifikasi"></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative mb-3">
                                <label for="verifikasi" class="form-label">Verifikasi Rp.</label>
                                <input autocomplete="off" type="text" name="verifikasi" id="verifikasi"
                                    class="form-control money" value="{{ number_format($perguliran->proposal, 2) }}">
                                <small class="text-danger" id="msg_verifikasi"></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative mb-3">
                                <label for="jangka" class="form-label">Jangka</label>
                                <input autocomplete="off" type="number" name="jangka" id="jangka"
                                    class="form-control" value="{{ $perguliran->jangka }}">
                                <small class="text-danger" id="msg_jangka"></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative mb-3">
                                <label for="pros_jasa" class="form-label">Prosentase Jasa (%)</label>
                                <input autocomplete="off" type="number" name="pros_jasa" id="pros_jasa"
                                    class="form-control" value="{{ $perguliran->pros_jasa }}">
                                <small class="text-danger" id="msg_pros_jasa"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="position-relative mb-3">
                                <label for="jenis_jasa" class="form-label">Jenis Jasa</label>
                                <select class="selectproposal form-control" name="jenis_jasa" id="jenis_jasa">
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
                                <select class="selectproposal form-control" name="sistem_angsuran_pokok"
                                    id="sistem_angsuran_pokok">
                                    @foreach ($sistem_angsuran as $sa)
                                        <option {{ $sa->id == $perguliran->sistem_angsuran ? 'selected' : '' }}
                                            value="{{ $sa->id }}">
                                            {{ $sa->nama_sistem }} ({{ $sa->deskripsi_sistem }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-danger" id="msg_sistem_angsuran_pokok"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative mb-3">
                                <label for="sistem_angsuran_jasa" class="form-label">Sistem Ang. Jasa</label>
                                <select class="selectproposal form-control" name="sistem_angsuran_jasa"
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
                        <button id="Simpan" class="btn btn-primary float-end flex-grow-1 me-2">
                            SIMPAN REKOM VERIFIKATOR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $('.date').datepicker({
        dateFormat: 'dd/mm/yy'
    });
    
    var formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    })

    $('.selectproposal').select2({
        theme: 'bootstrap4'
    });

    $(".money").maskMoney();

    $('.idpa_proposal').change(function(e) {

        var idpa = $(this).attr('id')
        var value = $(this).val()

        $.ajax({
            url: '/pinjaman_anggota/' + idpa,
            type: 'post',
            data: {
                '_method': 'PUT',
                'idpa': idpa,
                'proposal': value,
                'status': 'P',
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
                $('#verifikasi').val(result.jumlah)
                $('#_verifikasi').html(result.jumlah)
                $('#__verifikasi').val(result.jumlah)
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

            console.log(value);
            value = parseFloat(value)

            total += value
        })

        $('#__verifikasi').val(total)
        $('#_verifikasi').html(formatter.format(total))
        $('#verifikasi').val(formatter.format(total))
    })

    $(document).on('click', '#Simpan', async function(e) {
        e.preventDefault()
        $('small').html('')

        var verifikasi = parseInt($('#verifikasi').val().split(',').join('').split('.00').join(''))
        var __verifikasi = parseInt($('#__verifikasi').val())

        var lanjut = true;
        if ('{{ $perguliran->jenis_pp }}' != '3') {
            if (verifikasi != __verifikasi) {
                lanjut = await Swal.fire({
                    title: 'Peringatan',
                    text: 'Jumlah verifikasi Anggota dan Kelompok Berbeda. Tetap lanjutkan?',
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
        }

        if (lanjut) {
            var form = $('#FormInput')
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
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
</script>
