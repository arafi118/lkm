<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use App\Models\AkunLevel2;
use App\Models\Rekening;
use App\Utils\Keuangan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Session;

class ExcelController extends Controller
{
    public function index()
    {
        $akun_level_2 = [];
        $akun_level_3 = [];
        $akun_rekening = [];

        Session::put('lokasi', '351');
        $rekening = Rekening::all();
        foreach ($rekening as $rek) {
            $kode_akun = explode('.', $rek->kode_akun);
            $kode_akun_level_2 = $kode_akun[0] . '.' . $kode_akun[1];
            $kode_akun_level_3 = $kode_akun[0] . '.' . $kode_akun[1] . '.' . str_pad($kode_akun[2], 2, '0', STR_PAD_LEFT);
            $kode_akun_rekening = $rek->kode_akun;

            $akun_level_2[$kode_akun_level_2][] = $rek;
            $akun_level_3[$kode_akun_level_3][] = $rek;
            $akun_rekening[$kode_akun_rekening][] = $rek;
        }

        $index = 0;
        $insert = [];
        $excel = (new ExcelImport)->toArray('storage/excel/arus-kas-arthamari.xlsx', null, ExcelExcel::XLSX);
        foreach ($excel[0] as $key => $value) {
            $number = $value[0];
            $nama_akun = $value[1];
            $debit = $value[4];
            $kredit = $value[5];

            if ($nama_akun || $debit || $kredit) {
                $insert[$index] = [
                    'number' => $number,
                    'nama_akun' => $nama_akun,
                    'child' => []
                ];

                if ($debit || $kredit) {
                    if (!($debit == 'Debit' || $kredit == 'Kredit')) {
                        if (str_contains($debit, ',')) {
                            $kode_debit = explode(',', $debit);
                            $kode_kredit = $kredit;

                            foreach ($kode_debit as $key => $kode) {
                                $insert[$index]['child'][] = [
                                    'debit' => trim(str_replace('.%', '', $kode)),
                                    'kredit' => trim(str_replace('.%', '', $kode_kredit))
                                ];
                            }
                        } else if (str_contains($kredit, ',')) {
                            $kode_debit = $debit;
                            $kode_kredit = explode(',', $kredit);

                            foreach ($kode_kredit as $key => $kode) {
                                $insert[$index]['child'][] = [
                                    'debit' => trim(str_replace('.%', '', $kode_debit)),
                                    'kredit' => trim(str_replace('.%', '', $kode))
                                ];
                            }
                        } else {
                            $insert[$index]['child'][] = [
                                'debit' => trim(str_replace('.%', '', $debit)),
                                'kredit' => trim(str_replace('.%', '', $kredit))
                            ];
                        }
                    }
                }
            }

            $index++;
        }

        $nomor = 1;
        $grand_parent_id = 0;
        $sub_parent_id = 0;
        $kode_debit = [];
        $kode_kredit = [];
        $aruskas = [];
        foreach ($insert as $data) {
            if ($data['number']) {
                $grand_parent_id = $nomor;
                $sub_parent_id = $nomor;
            }

            if (ctype_upper($data['nama_akun'])) {
                $sub_parent_id = $grand_parent_id;
                $grand_parent_id = $nomor;
            }

            if (substr($data['nama_akun'], 1, 1) == '.') {
                $sub_parent_id = $grand_parent_id;
            }

            $child_parent_id = $nomor;
            $aruskas[] = [
                'id' => $nomor,
                'nama_akun' => $data['nama_akun'],
                'parent_id' => ($data['number']) ? 0 : $sub_parent_id,
                'debit' => 'NULL',
                'kredit' => 'NULL',
                'aktif' => 'Y'
            ];

            if (substr($data['nama_akun'], 1, 1) == '.') {
                $sub_parent_id = $nomor;
            }

            $nomor++;
            if (count($data['child']) > 0) {
                $child = $data['child'];
                foreach ($child as $key => $value) {
                    $fixDebit = true;
                    $kode_fixed = $value['debit'];
                    $kode_loop = $value['kredit'];
                    if (Keuangan::startWith($value['kredit'], '1.1.01')) {
                        $fixDebit = false;
                        $kode_fixed = $value['kredit'];
                        $kode_loop = $value['debit'];
                    }

                    if (strlen($kode_loop) == '3') {
                        $loop = $akun_level_2[$kode_loop];
                    }

                    if (strlen($kode_loop) == '6') {
                        $loop = $akun_level_3[$kode_loop];
                    }

                    if (strlen($kode_loop) == '9') {
                        $loop = $akun_rekening[$kode_loop];
                    }

                    foreach ($loop as $rek) {


                        if ($fixDebit) {
                            if (in_array($rek->kode_akun, $kode_debit)) {
                                continue;
                            }
                            $kode_debit[] = $rek->kode_akun;
                        } else {
                            if (in_array($rek->kode_akun, $kode_kredit)) {
                                continue;
                            }
                            $kode_kredit[] = $rek->kode_akun;
                        }

                        $aruskas[] = [
                            'id' => $nomor,
                            'nama_akun' => 'NULL',
                            'parent_id' => $child_parent_id,
                            'debit' => ($fixDebit) ? $kode_fixed : $rek->kode_akun,
                            'kredit' => ($fixDebit) ? $rek->kode_akun : $kode_fixed,
                            'aktif' => 'Y'
                        ];

                        $kode_akun[] = $rek->kode_akun;
                        $nomor++;
                    }
                }
            }
        }

        foreach ($aruskas as $data) {
            $keys = array_keys($data);
            $values = array_values($data);

            $key = implode(',', $keys);
            $value = '"' . implode('","', $values) . '"';
            $value = str_replace('"NULL"', 'NULL', $value);

            $sql = "INSERT INTO arus_kas_lkm ($key) VALUES ($value);";

            echo $sql . "<br>";
        }
    }
}
