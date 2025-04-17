<?php

namespace App\Http\Controllers\Kabupaten;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Wilayah;
use App\Utils\Keuangan;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        $url = request()->getHost();
        $kab = Rekap::where('web_rekap', $url)->first();

            $nama_kab = ' Rekap ' . ucwords(strtolower($kab->nama_rekap));

        return view('rekap.auth.login')->with(compact('nama_kab'));
    }

    public function login(Request $request)
    {
        $url = $request->getHost();
        $data = $request->only([
            'username', 'password'
        ]);

        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $kab = Rekap::where('web_rekap', $url)->first();
        $login_kab = Rekap::where('username', $data['username'])->first();
        if ($login_kab) {
            if ($login_kab->password == $kab->password && $login_kab->password === $data['password']) {
                if (Auth::guard('kab')->loginUsingId($login_kab->id)) {
                    $request->session()->regenerate();
                    
                        $lokasiIds = array_filter(explode(',', $kab->lokasi));
                        $kdKecList = Kecamatan::whereIn('id', $lokasiIds)->pluck('kd_kec');
                        $kecamatan = Wilayah::whereIn('kode', $kdKecList)
                                                ->whereRaw('LENGTH(kode) = 8')
                                                ->orderBy('nama', 'ASC')
                                                ->get();
                    session([
                        'nama_kab' => ucwords(strtolower($login_kab->nama_rekap)),
                        'kecamatan' => $kecamatan,
                        'kd_kab' => "",
                        'kd_prov' => "",
                    ]);

                    return redirect('/rekap/dashboard')->with([
                        'pesan' => 'Login Kabupaten ' . ucwords(strtolower($login_kab->nama_kab)) . ' Berhasil'
                    ]);
                }
            }
        }

        $error = 'Username atau Password Salah';
        return redirect()->back()->with('error', $error);
    }

    public function logout(Request $request)
    {
        $user = auth()->guard('kab')->user()->nama_kab;
        Auth::guard('kab')->logout();

        return redirect('/rekap')->with('pesan', 'Terima Kasih');
    }
}
