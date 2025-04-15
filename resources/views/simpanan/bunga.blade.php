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
                        <form method="POST">
                            @csrf
                            <div class="row">
                                <!-- CIF -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cif">CIF</label>
                                        <input type="text" name="cif" id="cif" class="form-control" placeholder="Semua CIF">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="alert alert-info d-flex align-items-center" role="alert" style="background-color: #e7f3fe; color: #31708f; border: 1px solid #bce8f1;">
                                        <i class="fas fa-info-circle" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                        <span>
                                            Proses Hitung Bunga ini akan menghitung bunga dari tanggal 3 hingga tanggal 2025-02-28, jika tanggal kurang sesuai, silakan atur di Pengaturan SOP atau bisa menghubungi TS Simpanan (+62 881 3756 007)

                                            Biarkan CIF kosong untuk memproses semua CIF. Jika hanya ingin memproses beberapa CIF tertentu, silakan masukkan dalam format: CIF1, CIF2, CIF3, dan seterusnya. (misal : 1, 2, 4, 34, dsb)
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <button id="simpanBunga"  type="button" class="btn btn-primary mt-3">Proses Kalkulasi</button>
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
            function prosesKalkulasi() {
                var cif = $('#cif').val();

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
                    url: '/bunga/simpan-transaksi',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cif: cif
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.close();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Transaksi berhasil disimpan',
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
            }

            // Klik tombol proses
            $('#simpanBunga').click(function() {
                prosesKalkulasi();
            });

            // Enter pada input CIF
            $('#cif').keypress(function(event) {
                if (event.which === 13) { // 13 adalah keycode untuk Enter
                    event.preventDefault(); // Mencegah form submit secara default
                    prosesKalkulasi();
                }
            });
        });

    </script>
@endsection
