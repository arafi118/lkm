@if ($jenis_produk == 1)
    <!-- Tidak ada yang ditampilkan jika id adalah 1 -->
@else
    <div class="row">
        <div class="col-md-4">
            <div class="position-relative mb-3">
                <label for="id_agent" class="form-label">Nama Agen</label>
                <select class="js-example-basic-single form-control" name="id_agent" id="id_agent" style="width: 100%;">
                    @foreach ($agent as $ag)
                        <option value="{{ $ag->id }}">
                            ({{ $ag->nomorid }})
                            {{ $ag->agent }}
                        </option>
                    @endforeach
                </select>
                <small class="text-danger" id="msg_id_agent"></small>
            </div>
        </div>
        <div class="col-md-8">
            <div class="position-relative mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input autocomplete="off" type="text" name="nama_barang" id="nama_barang" class="form-control">
                <small class="text-danger" id="msg_nama_barang"></small>
            </div>
        </div>
    </div>
@endif
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            theme: 'bootstrap4',
        });
    });
</script>
