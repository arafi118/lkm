<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\DataPemanfaat;
use App\Models\Desa;
use App\Models\JenisaJasa;
use App\Models\JenisProdukPinjaman;
use App\Models\JenisSimpanan;
use App\Models\Kecamatan;
use App\Models\Keluarga;
use App\Models\kode;
use App\Models\PinjamanIndividu;
use App\Models\Rekening;
use App\Models\RealAngsuranI;
use App\Models\RealSimpanan;
use App\Models\RencanaAngsuranI;
use App\Models\Simpanan;
use App\Models\SistemAngsuran;
use App\Models\StatusPinjaman;
use App\Models\Transaksi;
use App\Models\User;
use App\Utils\Keuangan;
use App\Utils\Pinjaman;
use App\Utils\Tanggal;
use DNS1D;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use PDF;
use Session;
use Yajra\DataTables\DataTables;

class SimpananController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $simpanan = Simpanan::with(['anggota', 'js'])
                ->orderBy('id', 'DESC');
            return DataTables::of($simpanan)
                ->addColumn('nama_anggota', function ($row) {
                    return $row->anggota->namadepan ?? '-';
                })
                ->addColumn('jenis_simpanan', function ($row) {
                    return $row->js->nama_js ?? '-';
                })
                ->addColumn('status', function ($row) {
                    $status = '<span class="badge bg-secondary">-</span>';
                    if ($row->status) {
                        $badge = $row->status == 'A' ? 'success' : 'danger';
                        $status = '<span class="badge bg-' . $badge . '">' . ($row->status == 'A' ? 'Aktif' : 'Non-Aktif') . '</span>';
                    }
                    return $status;
                })
                ->addColumn('status', function ($row) {
                    $status = '<span class="badge bg-secondary">-</span>';
                    if ($row->status) {
                        $badge = $row->status == 'A' ? 'success' : 'danger';
                        $status = '<span class="badge bg-' . $badge . '">' . ($row->status == 'A' ? 'Aktif' : 'Non-Aktif') . '</span>';
                    }
                    return $status;
                })
                ->editColumn('jumlah', function ($row) {
                    return 'Rp ' . number_format($row->jumlah, 0, ',', '.');
                })
                ->editColumn('tgl_buka', function ($row) {
                    return date('d/m/Y', strtotime($row->tgl_buka));
                })
                ->rawColumns(['status'])
                ->make(true);
        }
        $title = 'Daftar Simpanan';
        return view('simpanan.index')->with(compact('title'));
    }
    
    public function getTransaksi() {
        $bulan = request()->input('bulan');
        $tahun = request()->input('tahun');
        $cif = request()->input('cif');

        $transaksiQuery = Transaksi::where('id_simp', "$cif");

        if ($tahun != 0) {
            $transaksiQuery->whereYear('tgl_transaksi', $tahun);
        }

        if ($bulan != 0) {
            $transaksiQuery->whereMonth('tgl_transaksi', $bulan);
        }

        $transaksi = $transaksiQuery->with('realSimpanan')->orderBy('tgl_transaksi', 'asc')->get();

        $transaksi->each(function ($item) {
            $item->ins = User::where('id', $item->id_user)->value('ins');
        });

        $bulankop = $bulan;
        $tahunkop = $tahun;
        
    $startDate = \Carbon\Carbon::createFromDate(
        $tahunkop, 
        $bulankop == 0 ? 1 : $bulankop, 
        1
    )->startOfMonth();

    $last_sum = RealSimpanan::where('cif', $cif)
        ->where('tgl_transaksi', '<', $startDate)
        ->orderBy('tgl_transaksi', 'desc')
        ->orderBy('id', 'desc')
        ->value('sum') ?? 0;

    return view('simpanan.partials.detail-transaksi', compact('transaksi', 'bulankop', 'tahunkop', 'cif', 'last_sum'));
}


    public function detailAnggota($id)
    {
        $nia = Simpanan::where('id', $id)->with(['anggota'])->first();
        $title = 'Simpanan $nia->anggota->namadepan';
        return view('simpanan.partials.detail')->with(compact('title', 'nia'));
    }


    public function create()
    {
        $id_angg = request()->get('id_angg');
        $title = 'Registrasi Pinjaman Individu';
        return view('simpanan.create')->with(compact('title', 'id_angg'));
    }

    public function register($id_angg)
    {
        $anggota = Anggota::where('id', $id_angg)->with([
            'pinjaman' => function ($query) {
                $query->orderBy('tgl_proposal', 'DESC');
            },
            'pinjaman.sts'
        ])->first();
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();
        $sistem_angsuran = SistemAngsuran::all();
        $js = JenisSimpanan::where(function ($query) use ($kec) {
            $query->where('lokasi', '0')
                ->orWhere(function ($query) use ($kec) {
                    $query->where('kecuali', 'NOT LIKE', "%-{$kec['id']}-%")
                        ->where('lokasi', 'LIKE', "%-{$kec['id']}-%");
                });
        })->get();

        $js_dipilih = $anggota->jenis_produk_pinjaman;

        return view('simpanan.partials.register')->with(compact('anggota', 'kec', 'sistem_angsuran', 'js', 'js_dipilih'));
    }

    public function jenis_simpanan($id, Request $request)
    {
        $nia = $request->input('nia');
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();
        $urutan = Simpanan::where('nia', $nia)->count();
        $anggota = Anggota::where('id', $nia)->first();
        $hubungan = Keluarga::orderBy('kekeluargaan', 'ASC')->get();

        $hubungan_dipilih = 0;

        if ($kec && $anggota) {
            
            $hubungan_dipilih = $kec->hubungan;
            $kec_id = str_pad($kec->id, 3, '0', STR_PAD_LEFT);
            $anggota_id = str_pad($anggota->id, 3, '0', STR_PAD_LEFT);
            $urutan = 1 + $urutan;
            $urutan_formatted = str_pad($urutan, 2, '0', STR_PAD_LEFT);
            $nomor_rekening = "{$id}-{$kec_id}.{$anggota_id}-{$urutan_formatted}";
        } else {
            $nomor_rekening = 'Data tidak valid';
        }
        $fromkuasa = [
            [
                'id' => '1',
                'nama' => 'Pribadi',
            ],
            [
                'id' => '2',
                'nama' => 'Lembaga',
            ],
        ];
        return response()->json([
            'success' => true,
            'view' => view('simpanan.partials.simpanan', compact('id', 'kec', 'anggota', 'nomor_rekening', 'fromkuasa', 'hubungan', 'hubungan_dipilih'))->render()
        ]);
    }

    public function Kuasa($id)
    {
        return response()->json([
            'success' => true,
            'view' => view('simpanan.partials.fromkuasa')->with(compact('id'))->render()
        ]);
    }
    public function show(Simpanan $simpanan)
    {
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();
        $desa = Desa::where('kd_kec', $kec->kd_kec)->with('sebutan_desa')->get();
        $hubungan = Keluarga::orderBy('kekeluargaan', 'ASC')->get();

        $nia = $simpanan->where('id', $simpanan->id)->with(['anggota', 'js'])->first();
        $title = ucwords($simpanan->anggota->namadepan);
        return view('simpanan.partials.detail')->with(compact('nia', 'title', 'hubungan'));
    }


    public function kop(Simpanan $simpanan)
    {
        $simpanan = $simpanan->where('id', $simpanan->id)->with(['anggota', 'js'])->first();
        $title = 'Cetak KOP buku ' . $simpanan->anggota->namadepan;
        return view('simpanan.partials.cetak_kop')->with(compact('title', 'simpanan'));
    }
    public function koran(Simpanan $simpanan)
    {
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();
        $simpanan = $simpanan->where('id', $simpanan->id)->with(['anggota', 'js'])->first();
        $title = 'Cetak Rekening Koran' . $simpanan->anggota->namadepan;
        dd($simpanan);
        return view('simpanan.partials.cetak_koran')->with(compact('title', 'simpanan', 'kec'));
    }

    
    public function cetakKwitansi($idt)
    {
        $transaksi = Transaksi::where('idt', $idt)->first();
        $user = auth()->user();
        $userTransaksi = User::find($transaksi->id_user);
    
        // Logika untuk menentukan user yang ditampilkan
        $userDisplay = ($user->id == $userTransaksi->id) 
            ? $user->ins 
            : $user->ins . ' / ' . $userTransaksi->ins;

        $user = $userDisplay;
        // Menentukan kode berdasarkan jenis rekening
    
        $kode=substr($transaksi->id_simp, 0, 1);

            $title = 'Cetak Pada Kwitansi '.$transaksi->id_simp;

        return view('simpanan.partials.cetak_pada_kwitansi', compact(
            'transaksi',
            'user',
            'title',
            'kode'
        ));
    }

    public function cetakPadaBuku($idt)
    {
        $saldo = 0;
        $transaksi = Transaksi::where('idt', $idt)->with('realSimpanan')->orderBy('tgl_transaksi', 'asc')->first();
        $transaksiCount = Transaksi::where('id_simp', $transaksi->id_simp)
                                   ->where('idt', '<=', $idt)
                                   ->count();
        $user = auth()->user();
        $userTransaksi = User::find($transaksi->id_user);
    
        // Logika untuk menentukan user yang ditampilkan
        $userDisplay = ($user->id == $userTransaksi->id) 
            ? $user->ins 
            : $user->ins . ' / ' . $userTransaksi->ins;
        $user = $userDisplay;
        $kode=substr($transaksi->id_simp, 0, 1);
                        if(in_array(substr($transaksi->id_simp, 0, 1), ['1', '2', '5'])) {
                            $debit = 0;
                            $kredit = $transaksi->jumlah;
                            $saldo += $transaksi->jumlah;
                        } elseif(in_array(substr($transaksi->id_simp, 0, 1), ['3', '4', '6', '7'])) {
                            $debit = $transaksi->jumlah;
                            $kredit = 0;
                            $saldo -= $transaksi->jumlah;
                        } else {
                            $debit = 0;
                            $kredit = 0;
                        }

            $title = 'Cetak Pada Buku '.$transaksi->id_simp;
            return view('simpanan.partials.cetak_pada_buku')->with(compact('title','transaksi', 'transaksiCount', 'kode', 'user', 'debit', 'kredit',  'saldo'));
     }

    public function simpanTransaksi(Request $request)
    {
        $jenisMutasi = $request->jenis_mutasi;
        $tglTransaksi = $request->tgl_transaksi;
        $jumlah = $request->jumlah;
        $nomorRekening = $request->nomor_rekening;
        $lembaga = $request->lembaga;
        $jabatan = $request->jabatan;
        $catatan_simpanan = $request->catatan_simpanan;
        $namaDebitur = $request->nama_debitur;
        $cif = $request->nia;

        $simpanan = Simpanan::where('id', $cif)->first();
        $jenisSimpanan = JenisSimpanan::where('id', $simpanan->jenis_simpanan)->first();
        
        $transaksi = new Transaksi();
        $transaksi->tgl_transaksi = Tanggal::tglNasional($tglTransaksi);













        $transaksi->rekening_debit = $jenisMutasi == '1' ? $jenisSimpanan->rek_kas : $jenisSimpanan->rek_simp;
        $transaksi->rekening_kredit = $jenisMutasi == '1' ? $jenisSimpanan->rek_simp : $jenisSimpanan->rek_kas;
        $transaksi->idtp = 0;
        $transaksi->id_pinj = 0;
        $transaksi->id_pinj_i = 0;
        $transaksi->id_simp = $cif;
        $transaksi->keterangan_transaksi = $jenisMutasi == '1' ? "Setor Tunai Rekening {$nomorRekening}" : "Tarik Tunai Rekening {$nomorRekening}";
        $transaksi->relasi = $namaDebitur;
        $transaksi->jumlah = str_replace(',', '', str_replace('.00', '', $jumlah));
        $transaksi->urutan = 0;
        $transaksi->id_user = auth()->user()->id;
        
        $kode = ($jenisMutasi == 1) ? 2 : 3;
        $real = RealSimpanan::where('cif', $cif)->latest('tgl_transaksi')->orderBy('id', 'DESC')->first();
        
        $jumlahBersih = str_replace(',', '', str_replace('.00', '', $jumlah));

        $sumSebelumnya = $real ? $real->sum : 0;
        $sumBaru = ($jenisMutasi == 1) 
            ? $sumSebelumnya + $jumlahBersih 
            : $sumSebelumnya - $jumlahBersih;

        if ($transaksi->save()) {
                $maxIdt = Transaksi::max('idt');

                RealSimpanan::create([
                    'cif' => $cif,
                    'idt' => $maxIdt,
                    'kode' => $kode,
                    'tgl_transaksi' => Tanggal::tglNasional($tglTransaksi),
                    'real_d' => ($jenisMutasi == 2) ? $jumlahBersih : 0,
                    'real_k' => ($jenisMutasi == 1) ? $jumlahBersih : 0,
                    'sum' => $sumBaru,
                    'lu' => date('Y-m-d H:i:s'),
                    'id_user' => auth()->user()->id,
                ]);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan transaksi']);
        }

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_rekening' => 'required', 
            'jenis_simpanan' => 'required',
            'nia' => 'required',
            'setoran_awal' => 'required|numeric',
            'tgl_buka_rekening' => 'required',
            'tgl_minimal_tutup_rekening' => 'required',
            'bunga' => 'required|numeric',
            'pajak_bunga' => 'required|numeric',
            'admin' => 'required|numeric',
            'kuasa' => 'required',
            'ahli_waris' => 'required',
            'hubungan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $simpanan = new Simpanan();
        $simpanan ->nomor_rekening = $request->nomor_rekening;
        $simpanan ->lembaga = $request->lembaga;
        $simpanan ->jabatan = $request->jabatan;
        $simpanan ->catatan_simpanan = $request->catatan_simpanan;
        $simpanan ->jenis_simpanan = $request->jenis_simpanan;
        $simpanan ->nia = $request->nia;
        $simpanan ->jumlah = $request->setoran_awal;
        $simpanan ->tgl_buka = Tanggal::tglNasional($request->tgl_buka_rekening);
        $simpanan ->tgl_tutup = Tanggal::tglNasional($request->tgl_minimal_tutup_rekening);
        $simpanan ->bunga = $request->bunga;
        $simpanan ->pajak = $request->pajak_bunga;
        $simpanan ->admin = $request->admin;
        $simpanan ->status = 'A';
        $simpanan ->sp = $request->kuasa;
        $simpanan ->pengampu = $request->ahli_waris;
        $simpanan ->hubungan = $request->hubungan;
        $simpanan ->user_id = auth()->id();
        $simpanan ->lu = date('Y-m-d H:i:s');
        $simpanan ->save();

        $maxId = Simpanan::max('id');

        $js = JenisSimpanan::where('id', $request->jenis_simpanan)->first();
        $anggota = Anggota::where('id', $request->nia)->first();


        //setoran awal
        Transaksi::create([
            'tgl_transaksi' => Tanggal::tglNasional($request->tgl_buka_rekening),
            'rekening_debit' => $js->rek_kas,
            'rekening_kredit' =>  $js->rek_simp,
            'idtp' => '0',
            'id_pinj' => '0',
            'id_pinj_i' => '0',
            'id_simp' => $maxId,
            'keterangan_transaksi' => 'Setoran Awal ' . $js->nama_js . ' ' . $anggota->namadepan . '',
            'relasi' => $anggota->namadepan . '[' . $request->nia . ']',
            'jumlah' => str_replace(',', '', str_replace('.00', '', $request->setoran_awal)),
            'urutan' => '0',
            'id_user' => auth()->user()->id,
        ]);
        $maxIdt = Transaksi::max('idt');
        
        //admin register
        Transaksi::create([
            'tgl_transaksi' => Tanggal::tglNasional($request->tgl_buka_rekening),
            'rekening_debit' => $js->rek_kas,
            'rekening_kredit' =>  $js->rek_adm,
            'idtp' => '0',
            'id_pinj' => '0',
            'id_pinj_i' => '0',
            'id_simp' => '0',
            'keterangan_transaksi' => 'Pendapatan Admin Simpanan ' . $js->nama_js . ' ' . $anggota->namadepan . '',
            'relasi' => $anggota->namadepan . '[' . $request->nia . ']',
            'jumlah' => str_replace(',', '', str_replace('.00', '', $request->admin_register)),
            'urutan' => '0',
            'id_user' => auth()->user()->id,
        ]);
        
        //real setoran awalx
        RealSimpanan::create([
            'cif' => $maxId,
            'idt' => $maxIdt,
            'kode' => 1,
            'tgl_transaksi' => Tanggal::tglNasional($request->tgl_buka_rekening),
            'real_d' =>  '0',
            'real_k' => str_replace(',', '', str_replace('.00', '', $request->setoran_awal)),
            'sum' => str_replace(',', '', str_replace('.00', '', $request->setoran_awal)),
            'lu' => date('Y-m-d H:i:s'),
            'id_user' => auth()->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data simpanan berhasil disimpan',
            'id' => $simpanan->id
        ]);
    }

    public function bunga()
    {
        $id_angg = request()->get('id_angg');
        $title = 'Perhitungan Bunga & Biaya';
        return view('simpanan.bunga')->with(compact('title', 'id_angg'));
    }

    public function simpanTransaksiBunga(Request $request)
    {
        $tglTransaksi = now(); 
        $cifInput = $request->cif; // Bisa kosong atau berisi daftar CIF (misal: "2,3,12,34")
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();
    
        if (empty($cifInput)) {
            $simpananList = Simpanan::where('status', 'A')
                                    ->with('anggota')
                                    ->get();
        } else {
            $cifArray = explode(',', $cifInput);
            $simpananList = Simpanan::where('status', 'A')
                                    ->whereIn('id', $cifArray)
                                    ->with('anggota')
                                    ->get();
        }
        foreach ($simpananList as $simpanan) {

            $cif = $simpanan->id;
            $nomorRekening = $simpanan->no_rekening;
            $namaDebitur = $simpanan->anggota->namadepan;
            $simpanan = Simpanan::where('id', $cif)->first();
            $jenisSimpanan = JenisSimpanan::where('id', $simpanan->jenis_simpanan)->first();

            
            $real = RealSimpanan::where('cif', $cif)->latest('tgl_transaksi')->first();
            $sumSebelumnya = $real ? $real->sum : 0;
            if($sumSebelumnya>=$kec->min_bunga){

            }
            $bunga = 10000;
            $pajak = 10000;
            $admin = 10000;

            $transaksi = new Transaksi();
            $transaksi->tgl_transaksi = Tanggal::tglNasional($tglTransaksi);
            $transaksi->rekening_debit = ($jenisMutasi == '1') ? $jenisSimpanan->rek_kas : $jenisSimpanan->rek_simp;
            $transaksi->rekening_kredit = ($jenisMutasi == '1') ? $jenisSimpanan->rek_simp : $jenisSimpanan->rek_kas;
            $transaksi->idtp = 0;
            $transaksi->id_pinj = 0;
            $transaksi->id_pinj_i = 0;
            $transaksi->id_simp = $cif;
            $transaksi->keterangan_transaksi = ($jenisMutasi == '1') ? "Setor Tunai Rekening {$nomorRekening}" : "Tarik Tunai Rekening {$nomorRekening}";
            $transaksi->relasi = $namaDebitur;
            $transaksi->jumlah = str_replace(',', '', str_replace('.00', '', $jumlah));
            $transaksi->urutan = 0;
            $transaksi->id_user = auth()->user()->id;
        
            $maxIdt = Transaksi::where('id_simp', $cif)->max('idt');
            $sumBaru = ($jenisMutasi == 1) 
                ? $sumSebelumnya + $jumlahBersih 
                : $sumSebelumnya - $jumlahBersih;

                $jm = ($jenisMutasi == 1) ? 2 : 3;
            $kode   = kode::where('def', $jm);

            RealSimpanan::create([
                'cif' => $cif,
                'idt' => $maxIdt,
                'kode' => ($jenisMutasi == 1) ? 2 : 3,
                'tgl_transaksi' => Tanggal::tglNasional($tglTransaksi),
                'real_d' => ($jenisMutasi == 2) ? $jumlahBersih : 0,
                'real_k' => ($jenisMutasi == 1) ? $jumlahBersih : 0,
                'sum' => $sumBaru,
                'lu' => now(),
                'id_user' => auth()->user()->id,
            ]);

            $transaksi->save();
        }

        return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan']);
    }



}
