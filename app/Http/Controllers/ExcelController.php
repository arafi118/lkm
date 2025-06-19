<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;

class ExcelController extends Controller
{
    public function index()
    {
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
                    $aruskas[] = [
                        'id' => $nomor,
                        'nama_akun' => 'NULL',
                        'parent_id' => $child_parent_id,
                        'debit' => $value['debit'],
                        'kredit' => $value['kredit'],
                        'aktif' => 'Y'
                    ];
                    $nomor++;
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
