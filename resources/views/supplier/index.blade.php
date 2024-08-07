@extends('layouts.base')

@section('content')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div><b>Data Supplier</b>
                    <div class="page-title-subheading">
                         {{ Session::get('nama_lembaga') }} Kecamatan {{ $kec->nama_kec }}
                    </div>
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#RegisterSupplier"
                    class="btn btn-info btn-sm mb-2" onclick="replaceContent()"><i class="fa fa-shopping-cart"></i> &nbsp; &nbsp;Register Supplier</button>
                </div>
            </div>
            
        </div>
    </div>    
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <div class="table-responsive">
                            <table class="mb-0 table table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>KD Supplier</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Brand</th>
                                        <th>No HP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade bd-example-modal-lg" id="EditSupplier" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="RegisterSupplier" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        
    </div>
</div>
@endsection

@section('script')
<script>
    var table = $('.table-hover').DataTable({
        language: {
            paginate: {
                previous: "&laquo;",
                next: "&raquo;"
            }
        },
        processing: true,
        serverSide: true,
        ajax: "/database/supplier",
        columns: [{
                data: 'kd_supplier',
                name: 'kd_supplier'
            },
            {
                data: 'supplier',
                name: 'supplier'
            },
            {
                data: 'alamat',
                name: 'alamat'
            },
            {
                data: 'brand',
                name: 'brand'
            },
            {
                data: 'nohp',
                name: 'nohp'
            }
        ]
    });

    $.get('/database/supplier/create', function(result) {
            $('#RegisterSupplier .modal-dialog').html(result)
        })

        $(document).on('keyup', '#id', function(e) {
            e.preventDefault()

            var id = $(this).val()
            if (id.length == 16) {
                $.get('/database/supplier/create?id=' + id, function(result) {
                    $('#RegisterSupplier .modal-dialog').html(result)
                })
            }
        })

        $(document).on('click', '#SimpanSupplier', function(e) {
            e.preventDefault()
            $('small').html('')

            var form = $('#FormRegisterSupplier')
            $.ajax({
                type: 'post',
                url: form.attr('action'),
                data: form.serialize(),
                success: function(result) {
                    Swal.fire('Berhasil', result.msg, 'success').then(() => {
                        Swal.fire({
                            title: 'Tambah supplier Baru?',
                            text: "",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Tidak'
                        }).then((res) => {
                            if (res.isConfirmed) {
                                $.get('/database/supplier/create', function(result) {
                                    $('#RegisterSupplier  .modal-dialog').html(result)
                                })
                            } else {
                                window.location.href = '/database/supplier'
                            }
                        })
                    })
                },
                error: function(result) {
                    const respons = result.responseJSON;

                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error')
                    $.map(respons, function(res, key) {
                        $('#' + key).parent('.input-group.input-group-static').addClass(
                            'is-invalid')
                        $('#msg_' + key).html(res)
                    })
                }
            })
        })



    $('.table').on('click', 'tbody tr', function (e) {
        var data = table.row(this).data();

        $.get('/database/supplier/' + data.id + "/edit", function (result) {
            $('#EditSupplier .modal-dialog').html(result)
            $('#EditSupplier').modal('show')
        })

    })

    $(document).on('click', '#simpanEditSupplier', function (e) {
        e.preventDefault()

        var form = $('#FormEditSupplier')
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            success: function (result) {
                Swal.fire('Berhasil', result.msg, 'success').then(async (result) => {
                    await $('#EditSupplier').modal('toggle')
                    table.ajax.reload();
                })
            },
            error: function (result) {
                const respons = result.responseJSON;

                Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error')
                $.map(respons, function (res, key) {
                    $('#' + key).parent('.input-group').addClass('is-invalid')
                    $('#msg_' + key).html(res)
                })
            }
        })

    })

    function replaceContent() {
    console.log("replaceContent dipanggil");
        // Anda bisa menambahkan logika tambahan di sini jika perlu
    }


</script>
@endsection
