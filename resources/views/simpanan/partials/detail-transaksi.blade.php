@php
$sum = 0;
@endphp

<div class="table-responsive">
    <table class="table table-striped align-items-center mb-0" width="100%">
        <thead>
            <tr class="bg-dark text-white">
                <th>#</th>
                <th>Tgl transaksi</th>
                <th>Keterangan</th>
                <th>IDT</th>
                <th>Debit (Tarik)</th>
                <th>Kredit (Setor)</th>
                <th>Saldo</th>
                <th>P</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @forelse($real as $index => $trx)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->tgl_transaksi)->format('d/m/Y') }}</td>
                    <td>{{ $trx->transaksi->keterangan_transaksi ?? '-' }}</td>
                    <td>{{ $trx->idt ?? '-' }}</td>
                    <td>{{ number_format($trx->real_d, 0, ',', '.') }}</td>
                    <td>{{ number_format($trx->real_k, 0, ',', '.') }}</td>
                    <td>{{ number_format($trx->sum, 0, ',', '.') }}</td>
                    <td>{{ $trx->id_user ?? '-' }}</td>
                    <td>
                        <!-- Tombol Print -->
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada transaksi di periode ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
