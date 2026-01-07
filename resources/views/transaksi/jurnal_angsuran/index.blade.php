@extends('layouts.base')

@section('content')
    <div class="app-main__inner">
        <div class="tab-content">
            <div class="row">
                <div class="col-12" id="notif">

                </div>
                <div class="col-md-8 mb-3">
                    <div class="card mb-3">
                        <div class="card-body py-2">
                            <form action="/transaksi/angsuran_kelompok" method="post" id="FormAngsuranKelompok">
                                @csrf

                                <input type="hidden" name="id" id="id"
                                    value="{{ Request::get('pinkel') ?: 0 }}">
                                <input type="hidden" name="_pokok" id="_pokok">
                                <input type="hidden" name="_jasa" id="_jasa">
                                <input type="hidden" name="tgl_pakai_aplikasi" id="tgl_pakai_aplikasi"
                                    value="{{ $kec->tgl_pakai }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="tgl_transaksi">Tgl Transaksi </label>
                                            <input autocomplete="off" type="text" name="tgl_transaksi" id="tgl_transaksi"
                                                class="form-control date" value="{{ date('d/m/Y') }}">
                                            <small class="text-danger" id="msg_tgl_transaksi"></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="position-relative mb-3">
                                            <label for="Tujuan">Tujuan</label>
                                            <select class="form-control js-example-basic-single" name="tujuan"
                                                id="tujuan">
                                                @foreach ($rekening as $rek)
                                                    <option value="{{ $rek->kode_akun }}">
                                                        {{ $rek->kode_akun }}. {{ $rek->nama_akun }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger" id="msg_tujuan"></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="position-relative mb-3">
                                            <label for="pokok">Pokok </label>
                                            <input autocomplete="off" type="text" name="pokok" id="pokok"
                                                class="form-control">
                                            <small class="text-danger" id="msg_pokok"></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="position-relative mb-3">
                                            <label for="jasa">Jasa </label>
                                            <input autocomplete="off" type="text" name="jasa" id="jasa"
                                                class="form-control">
                                            <small class="text-danger" id="msg_jasa"></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="position-relative mb-3">
                                            <label for="denda">Denda </label>
                                            <input autocomplete="off" type="text" name="denda" id="denda"
                                                class="form-control">
                                            <small class="text-danger" id="msg_denda"></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="position-relative mb-3">
                                            <label for="total">Total Bayar </label>
                                            <input autocomplete="off" readonly disabled type="text" name="total"
                                                id="total" class="form-control">
                                            <small class="text-danger" id="msg_total"></small>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="d-flex justify-content-end">
                                <button type="button"class="btn btn-warning btn-sm me-3" style="color: white;">
                                    Loan id
                                    <span class="badge badge-info" id="loan-id" style="font-size: 16px;">
                                    </span>
                                </button>
                                <button type="button" id="btnAngsuranAnggota" class="btn btn-info btn-sm me-3">
                                    Angsuran Anggota
                                </button>
                                <button type="button" id="SimpanAngsuran"
                                    class="btn btn-github btn-sm btn btn-sm btn-dark mb-0">Posting</button>
                            </div>
                        </div>
                    </div>

                    <div class="card card-body p-2 pb-0 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <div class="d-grid">
                                    <a id="cetakKartuAngsuran" class="btn btn-success btn-sm mb-2">Kartu</a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-grid">
                                    <button class="btn btn-danger btn-sm mb-2" id="btnDetailAngsuran">Detail</button>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-grid">
                                    <button class="btn btn-info btn-sm mb-2" id=cetakLPP>LPP per bulan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="nav-wrapper position-relative end-0">
                        <div class="d-flex justify-content-between p-1" role="tablist">
                            <button class="btn btn-outline-primary flex-fill me-1 active" data-bs-toggle="tab"
                                data-bs-target="#Pokok" role="tab" aria-controls="Pokok" aria-selected="true">
                                Pokok
                            </button>
                            <button class="btn btn-outline-warning flex-fill" data-bs-toggle="tab" data-bs-target="#Jasa"
                                role="tab" aria-controls="Jasa" aria-selected="false">
                                Jasa
                            </button>
                        </div>

                        <div class="tab-content mt-3">
                            <div class="tab-pane fade show active" id="Pokok" role="tabpanel"
                                aria-labelledby="Pokok">
                                <div class="card card-body p-2">
                                    <canvas id="chartP"></canvas>
                                    <div class="d-flex justify-content-between mt-3 mb-1 mx-3 text-sm fw-bold">
                                        <span>Alokasi</span>
                                        <span id="alokasi_pokok"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Jasa" role="tabpanel" aria-labelledby="Jasa">
                                <div class="card card-body p-2">
                                    <canvas id="chartJ"></canvas>
                                    <div class="d-flex justify-content-between mt-3 mb-1 mx-3 text-sm fw-bold">
                                        <span>Jasa</span>
                                        <span id="alokasi_jasa"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="DetailAngsuran" tabindex="-1" aria-labelledby="DetailAngsuranLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="DetailAngsuranLabel">

                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="LayoutDetailAngsuran"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-sm" id="cetakBuktiAngsuran">Cetak Bukti
                        Angsuran</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="BuktiAngsuran" tabindex="-1" aria-labelledby="BuktiAngsuranLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="BuktiAngsuranLabel">

                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="LayoutBuktiAngsuran"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="tutupBuktiAngsuran">Tutup</button>
                    <button type="button" class="btn btn-primary btn-sm" id="BtnCetakBkm">Cetak BKM</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AngsuranAnggota" tabindex="-1" aria-labelledby="AngsuranAnggotaLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="AngsuranAnggotaLabel">
                        Angsuran Anggota
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="LayoutAngsuranAnggota"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <form action="/transaksi/hapus_angsuran_kelompok" method="post" id="formHapus">
        @csrf

        <input type="hidden" name="del_idt" id="del_idt">
        <input type="hidden" name="del_idtp" id="del_idtp">
        <input type="hidden" name="del_id_pinj" id="del_id_pinj">
    </form>
@endsection

@section('script')
    <script>
        var pinkel = '{{ Request::get('pinkel') ?: 0 }}'

        if (pinkel != 0) {
            $('#id').val(pinkel)
        }

        var formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })

        $(".date").flatpickr({
            dateFormat: "d/m/Y"
        })

        $('.js-example-basic-single').select2({
            theme: 'bootstrap4'
        });

        $("#pokok, #jasa, #denda").maskMoney({
            allowNegative: true
        });

        var chartP;
        var chartJ;

        $(document).on('change', '#id', function(e) {
            var id = $(this).val()
            if (id == '' || id == '0') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silahkan pilih Kelompok terlebih dahulu!',
                })
            } else {
                $.get('/transaksi/detail/' + id, function(result) {
                    if (result.status == 'success') {
                        $('#loan-id').html(result.perguliran.id)
                        $('#_pokok').val(result.alokasi_pokok)
                        $('#_jasa').val(result.alokasi_jasa)

                        $('#alokasi_pokok').html('Rp. ' + formatter.format(result.alokasi_pokok))
                        $('#alokasi_jasa').html('Rp. ' + formatter.format(result.alokasi_jasa))

                        if (typeof chartP != "undefined") {
                            chartP.destroy();
                        }
                        if (typeof chartJ != "undefined") {
                            chartJ.destroy();
                        }

                        var ctxP = document.getElementById('chartP').getContext('2d');
                        chartP = new Chart(ctxP, {
                            type: 'doughnut',
                            data: {
                                labels: ['Pokok', 'Sisa'],
                                datasets: [{
                                    label: 'Rp. ',
                                    data: [result.real_pokok, result.alokasi_pokok - result.real_pokok],
                                    backgroundColor: [
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 99, 132)',
                                    ],
                                    hoverOffset: 4
                                }]
                            },
                        });

                        var ctxJ = document.getElementById('chartJ').getContext('2d');
                        chartJ = new Chart(ctxJ, {
                            type: 'doughnut',
                            data: {
                                labels: ['Jasa', 'Sisa'],
                                datasets: [{
                                    label: 'Rp. ',
                                    data: [result.real_jasa, result.alokasi_jasa - result.real_jasa],
                                    backgroundColor: [
                                        'rgb(255, 205, 86)',
                                        'rgb(255, 99, 132)',
                                    ],
                                    hoverOffset: 4
                                }]
                            },
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: result.msg,
                        })
                    }
                })
            }
        })

        $(document).on('change', '#pokok, #jasa, #denda', function(e) {
            var pokok = parseFloat($('#pokok').val().split(',').join(''))
            var jasa = parseFloat($('#jasa').val().split(',').join(''))
            var denda = parseFloat($('#denda').val().split(',').join(''))

            if (isNaN(pokok)) {
                pokok = 0
            }
            if (isNaN(jasa)) {
                jasa = 0
            }
            if (isNaN(denda)) {
                denda = 0
            }

            var total = pokok + jasa + denda
            $('#total').val(formatter.format(total))
        })

        $(document).on('click', '#SimpanAngsuran', function(e) {
            e.preventDefault()
            $('small').html('')

            var form = $('#FormAngsuranKelompok')
            var btn = $(this)
            btn.prop('disabled', true)

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire('Berhasil', result.msg, 'success')

                        $('#notif').html(result.notif)
                        $('#pokok').val('')
                        $('#jasa').val('')
                        $('#denda').val('')
                        $('#total').val('')

                        $('#id').trigger('change')

                        if (result.notif_wa) {
                            $.each(result.notif_wa, function(key, val) {
                                sendMsg(val.hp, val.nama, val.msg)
                            })
                        }
                    } else {
                        Swal.fire('Error', result.msg, 'error')
                    }
                    btn.prop('disabled', false)
                },
                error: function(result) {
                    const respons = result.responseJSON;

                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error')
                    $.map(respons, function(res, key) {
                        $('#msg_' + key).html(res)
                    })
                    btn.prop('disabled', false)
                }
            })
        })

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault()

            var idt = $(this).attr('data-idt')
            $.get('/transaksi/data/' + idt, function(result) {

                $('#del_idt').val(result.idt)
                $('#del_idtp').val(result.idtp)
                $('#del_id_pinj').val(result.id_pinj)
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Setelah menekan tombol Hapus Transaksi dibawah, maka transaksi ini akan dihapus dari aplikasi secara permanen.',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus Transaksi',
                    cancelButtonText: 'Batal',
                    icon: 'warning'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('#formHapus')
                        $.ajax({
                            type: form.attr('method'),
                            url: form.attr('action'),
                            data: form.serialize(),
                            success: function(result) {
                                if (result.success) {
                                    Swal.fire('Berhasil!', result.msg, 'success')
                                        .then(() => {
                                            $('#DetailAngsuran').modal('hide')
                                            $('#id').trigger('change')
                                        })
                                }
                            }
                        })
                    }
                })
            })
        })

        $(document).on('click', '#cetakKartuAngsuran', function(e) {
            e.preventDefault()
            var id_pinj = $('#id').val()

            open_window('/perguliran/dokumen/kartu_angsuran/' + id_pinj)
        })

        $(document).on('click', '#cetakLPP', function(e) {
            e.preventDefault()
            var id_pinj = $('#id').val()

            open_window('/transaksi/angsuran/lpp/' + id_pinj)
        })

        $(document).on('click', '#btnDetailAngsuran', function(e) {
            var id = $('#id').val()

            $.get('/transaksi/angsuran/detail_angsuran/' + id, function(result) {
                $('#DetailAngsuran').modal('show')

                $('#DetailAngsuranLabel').html(result.label)
                $('#LayoutDetailAngsuran').html(result.view)

                $('#BuktiAngsuranLabel').html(result.label_cetak)
                $('#LayoutBuktiAngsuran').html(result.cetak)
            })
        })

        $(document).on('click', '#cetakBuktiAngsuran, #tutupBuktiAngsuran', function(e) {
            e.preventDefault()

            $('#BuktiAngsuran').modal('toggle');
        })

        $(document).on('click', '#BtnCetakBkm', function(e) {
            e.preventDefault()

            $('#FormCetakBuktiAngsuran').attr('action', '/transaksi/angsuran/cetak_bkm');
            $('#FormCetakBuktiAngsuran').submit();
        })

        $(document).on('click', '#btnAngsuranAnggota', function(e) {
            e.preventDefault()
            
            var id = $('#id').val()
            if (id == '' || id == '0') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silahkan pilih Kelompok terlebih dahulu!',
                })
                return false
            }

            $.get('/transaksi/angsuran/angsuran_anggota/' + id, function(result) {
                $('#AngsuranAnggota').modal('show')
                $('#LayoutAngsuranAnggota').html(result.view)
            })
        })

        $(document).on('click', '.btn-link', function(e) {
            var action = $(this).attr('data-action')

            open_window(action)
        })

        $(document).on('click', '.btn-struk', function(e) {
            e.preventDefault()

            var idtp = $(this).attr('data-idtp')
            Swal.fire({
                title: "Cetak Kuitansi Angsuran",
                showDenyButton: true,
                confirmButtonText: "Biasa",
                denyButtonText: "Dot Matrix",
                confirmButtonColor: "#3085d6",
                denyButtonColor: "#3085d6",
            }).then((result) => {
                if (result.isConfirmed) {
                    open_window('/transaksi/angsuran/struk/' + idtp)
                } else if (result.isDenied) {
                    open_window('/transaksi/angsuran/struk_matrix/' + idtp)
                }
            });
        })

        function sendMsg(number, nama, msg, repeat = 0) {
            $.ajax({
                type: 'post',
                url: '{{ $api }}/send-text',
                timeout: 0,
                headers: {
                    "Content-Type": "application/json"
                },
                xhrFields: {
                    withCredentials: true
                },
                data: JSON.stringify({
                    token: "{{ auth()->user()->ip }}",
                    number: number,
                    text: msg
                }),
                success: function(result) {
                    if (result.status) {
                        MultiToast('success', 'Pesan untuk Nasabah ' + nama + ' berhasil dikirim')
                    } else {
                        if (repeat < 1) {
                            setTimeout(function() {
                                sendMsg(number, nama, msg, repeat + 1)
                            }, 1000)
                        } else {
                            MultiToast('error', 'Pesan untuk Nasabah ' + nama + ' gagal dikirim')
                        }
                    }
                },
                error: function(result) {
                    if (repeat < 1) {
                        setTimeout(function() {
                            sendMsg(number, nama, msg, repeat + 1)
                        }, 1000)
                    } else {
                        MultiToast('error', 'Pesan untuk Nasabah ' + nama + ' gagal dikirim')
                    }
                }
            })
        }

        // Trigger change on page load if pinkel exists
        if (pinkel != 0) {
            $('#id').trigger('change')
        }
    </script>
@endsection
