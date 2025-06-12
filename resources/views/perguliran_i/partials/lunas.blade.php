@php
    $is_dir =
        (auth()->user()->jabatan == '1' && auth()->user()->level == '1') ||
        (auth()->user()->jabatan == '3' &&
            auth()->user()->level == '1' &&
            in_array($kec->id, ['98', '351', '352', '353', '354']));

    $saldo_pokok = max(0, $ra->target_pokok - $real->sum_pokok);
    $saldo_jasa = max(0, $ra_real->target_jasa - $real->sum_jasa);

    $keterangan1 = $saldo_pokok == 0 ? 'Lunas' : 'Belum Lunas';
    $keterangan2 = $saldo_jasa == 0 ? 'Lunas' : 'Belum Lunas';
@endphp

@extends('layouts.base')

@section('content')
    <div class="app-main__inner">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5><b>Atas Nama {{ $perguliran_i->anggota->namadepan }} Loan ID. {{ $perguliran_i->id }}
                        {{ $perguliran_i->jpp->nama_jpp }} {{ $kec->nama_lembaga_sort }}</b></h5>
                <div>
                    <span class="badge btn badge-light-reed">{{ $perguliran_i->anggota->nik }}</span>
                    <span class="badge btn badge-light-reed">{{ $perguliran_i->anggota->alamat }}</span>
                    <span class="badge btn badge-light-reed">
                        {{ $perguliran_i->anggota->d->sebutan_desa->sebutan_desa }}
                        {{ $perguliran_i->anggota->d->nama_desa }}
                    </span>
                </div>
                <hr>
                <h5>Dengan mempertimbangkan SOP yang berlaku, saya selaku {{ $kec->sebutan_level_1 }},
                    {{ $kec->nama_lembaga_sort }} menyatakan bahwa:</h5>
                <table class="table mb-3">
                    <tr>
                        <td>Nama Pemanfaat</td>
                        <td>: {{ $perguliran_i->anggota->namadepan }}</td>
                        <td>Alokasi</td>
                        <td>: {{ number_format($perguliran_i->alokasi) }}</td>
                    </tr>
                    <tr>
                        <td>Desa</td>
                        <td>: {{ $perguliran_i->anggota->d->nama_desa }}</td>
                        <td>Jasa</td>
                        <td>: {{ $perguliran_i->pros_jasa }}%</td>
                    </tr>
                    <tr>
                        <td>Jenis Pinjaman</td>
                        <td>: {{ $perguliran_i->jpp->nama_jpp }}</td>
                        <td>Sistem</td>
                        <td>: {{ $perguliran_i->jangka }} bulan / {{ $perguliran_i->sis_pokok->nama_sistem }}</td>
                    </tr>
                </table>
                <h5>REKAPITULASI ANGSURAN</h5>
                <table class="table table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Target</th>
                            <th>Realisasi</th>
                            <th>Saldo</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Pokok</td>
                            <td>{{ number_format($ra->target_pokok) }}</td>
                            <td>{{ number_format($real->sum_pokok) }}</td>
                            <td>{{ number_format($saldo_pokok) }}</td>
                            <td>{{ $keterangan1 }}</td>
                        </tr>
                        <tr>
                            <td>Jasa</td>
                            <td>{{ number_format($ra_real->target_jasa) }}</td>
                            <td>{{ number_format($real->sum_jasa) }}</td>
                            <td>{{ number_format($saldo_jasa) }}</td>
                            <td>{{ $keterangan2 }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row mt-2">
                    <div class="col-sm-4">
                        <img src="/assets/img/lunas.png">
                    </div>
                    <div class="col-sm-8">
                        <div class="form-check">
                            <input id="checkboxLunaskan" type="checkbox" class="form-check-input custom-checkbox" />
                            <label class="form-check-label" for="checkboxLunaskan">
                                Pinjaman di atas telah dinyatakan LUNAS dan SPK nomor {{ $perguliran_i->spk_no }} tanggal
                                {{ Tanggal::tglLatin($perguliran_i->tgl_cair) }} dinyatakan selesai beserta seluruh hak dan
                                kewajibannya.
                            </label>
                        </div>
                        <div class="d-flex justify-content-end" style="gap: .5em;">
                            <button class="btn btn-warning btn-sm"
                                onclick="window.open('/cetak_keterangan_lunas_i/{{ $perguliran_i->id }}')" type="button">
                                <i class="fa fa-print"></i> Cetak Keterangan Pelunasan
                            </button>
                            @if ($is_dir)
                                <button class="btn btn-danger btn-sm" type="button" id="TombolLunaskan" disabled>
                                    <i class="fa fa-gavel"></i> Validasi Lunas
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="/perguliran_i/{{ $perguliran_i->id }}" method="post" id="FormPelunasan">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="L">
        </form>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <a href="/perguliran_i?status=L" class="btn btn-primary float-end">
                    <i class="fa fa-reply-all"></i> <b>KEMBALI</b>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '.form-check', function() {
            $('#TombolLunaskan').prop('disabled', !$('#checkboxLunaskan').is(':checked'));
        });

        $(document).on('click', '#TombolLunaskan', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Peringatan',
                text: 'Anda akan melakukan validasi pelunasan untuk kelompok {{ $perguliran_i->anggota->nama_kelompok }} dengan Loan ID. {{ $perguliran_i->id }}. Setelah klik tombol Lunaskan data tidak dapat diubah kembali',
                showCancelButton: true,
                confirmButtonText: 'Lunaskan',
                cancelButtonText: 'Batal',
                icon: 'warning'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post($('#FormPelunasan').attr('action'), $('#FormPelunasan').serialize(), function(
                        result) {
                        Swal.fire('Berhasil', result.msg, 'success').then(() => {
                            window.location.href = '/perguliran_i'
                        })
                    });
                }
            })
        });
    </script>
@endsection
