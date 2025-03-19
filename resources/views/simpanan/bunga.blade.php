@extends('layouts.base')

@section('content')

<div class="app-main__inner">   
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fa fa-bank"></i>
                </div>
                <div><b>Kalkulasi Perhitungan Bunga dan Biaya</b>
                    <div class="page-title-subheading">
                         {{ Session::get('nama_lembaga') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Bulan -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bulan">Bulan</label>
                                        <select name="bulan" id="bulan" class="form-control">
                                            @foreach ([
                                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                            ] as $key => $value)
                                                <option value="{{ $key }}" {{ date('m') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Tahun -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-control">
                                            @for ($i = 2025; $i <= 2028; $i++)
                                                <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <!-- CIF -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cif">CIF</label>
                                        <input type="text" name="cif" id="cif" class="form-control" placeholder="Masukkan CIF">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Proses Kalkulasi</button>
                        </form>
                    </div> 
                </div> 
            </div>
        </div>
    </div> 
</div> 

@endsection

@section('script')
<script>

$(document).ready(function() {
    var currentDate = new Date();
    var currentMonth = currentDate.getMonth() + 1;
    var currentYear = currentDate.getFullYear();

    $('#bulan').val(currentMonth);
    $('#tahun').val(currentYear);

    tableTransaksi(currentMonth, currentYear);

    function tableTransaksi(bulan, tahun) {
        $.get('/simpanan/get-transaksi', {
            cif: '{{ $nia->id }}',
            bulan: bulan,
            tahun: tahun
        }, function(result) {
            $('#transaksi-container').html(result);
        }).fail(function(xhr, status, error) {
            console.error("Error loading transactions:", error);
            $('#transaksi-container').html('<p>Error loading transactions. Please try again.</p>');
        });
    }

    $('#bulan, #tahun').change(function() {
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        tableTransaksi(bulan, tahun);
    });

    $('#simpanTransaksi').click(function() {
        var jenisMutasi = $('input[name="jenis_mutasi"]:checked').val();
        var tglTransaksi = $('#tgl_transaksi').val();
        var jumlah = $('#jumlah').val();
        var nomorRekening = $('#nomor_rekening').val();
        var namaDebitur = $('#nama_debitur').val();
        var nia = '{{ $nia->id }}';

        if (!jenisMutasi || !tglTransaksi || !jumlah) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Mohon lengkapi semua field.',
            });
            return;
        }

        Swal.fire({
            title: 'Mohon menunggu',
            text: 'Sedang memproses transaksi...',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            },
        });

        $.ajax({
            url: '/simpanan/simpan-transaksi',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                jenis_mutasi: jenisMutasi,
                tgl_transaksi: tglTransaksi,
                jumlah: jumlah,
                nomor_rekening: nomorRekening,
                nama_debitur: namaDebitur,
                nia: nia
            },
            success: function(response) {
                if (response.success) {
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Transaksi ' + (jenisMutasi == '1' ? 'setor' : 'tarik') + ' berhasil disimpan',
                        confirmButtonText: 'Oke'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            refreshTransaksiContainer();
                            resetForm();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menyimpan transaksi: ' + response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan: ' + error,
                });
            }
        });
    });

    function refreshTransaksiContainer() {
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        tableTransaksi(bulan, tahun);
    }

    function resetForm() {
        $('input[name="jenis_mutasi"]').prop('checked', false);
        $('#tgl_transaksi').val('');
        $('#jumlah').val('');
    }
});
</script>
@endsection
