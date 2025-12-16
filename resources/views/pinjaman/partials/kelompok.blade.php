@php
    use App\Models\PinjamanKelompok;

    $selected = false;
@endphp
<div class="row">
    <div class="col-md-8">
        <div class="position-relative mb-3">
            <select class="js-example-basic-single form-select" name="kelompok" id="kelompok" style="width:100%">
                @foreach ($kelompok as $kel)
                    @php
                        $pinjaman = 'N';
                        if ($kel->pinjaman_count > 0) {
                            $status = $kel->pinjaman->status;
                            $pinjaman = $status;
                        }

                        $select = false;
                        if (!($pinjaman == 'P' || $pinjaman == 'V' || $pinjaman == 'W') && !$selected) {
                            $select = true;
                            $selected = true;
                        }

                        if ($id_kel > 0) {
                            $select = false;
                        }

                        if ($kel->id == $id_kel) {
                            $select = true;
                        }
                    @endphp
                    <option {{ $select ? 'selected' : '' }} value="{{ $kel->id }}">
                        @if (isset($kel->d))
                            [{{ $pinjaman }}] [{{ $kel->kd_kelompok }}] {{ $kel->nama_kelompok }}
                            [{{ $kel->d->nama_desa }}]
                            [{{ $kel->ketua }}]
                        @else
                            [{{ $pinjaman }}] [{{ $kel->kd_kelompok }}] {{ $kel->nama_kelompok }} []
                            [{{ $kel->ketua }}]
                        @endif
                    </option>
                @endforeach
            </select>
            <small class="text-danger" id="msg_kelompok"></small>
        </div>
    </div>

        <a href="/database/kelompok/register_kelompok" class="btn btn-info btn-sm" style="width: 300px; height: 35px;">Register Kelompok</a>
</div>

<script>
    $('.js-example-basic-single').select2({
        theme: 'bootstrap-5'
    });
</script>
