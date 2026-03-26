<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tablesAll = [ //ini tabel2 yg belum punya apa2
        'transaksi_',
        'transaksi_109',
        'transaksi_177',
        'transaksi_2',
        'transaksi_206',
        'transaksi_212',
        'transaksi_217',
        'transaksi_220',
        'transaksi_238',
        'transaksi_242',
        'transaksi_250',
        'transaksi_263',
        'transaksi_277',
        'transaksi_279',
        'transaksi_280',
        'transaksi_287',
        'transaksi_313',
        'transaksi_318',
        'transaksi_351',
        'transaksi_352',
        'transaksi_353',
        'transaksi_354',
        'transaksi_362',
        'transaksi_428',
        'transaksi_433',
    ];

    protected array $tablesOnlyDeletedAt = [//ini udah tapi kurang deleted_at
        'transaksi_15',
        'transaksi_6',
        'transaksi_80',
        'transaksi_95',
        'transaksi_98',
    ];

    public function up(): void
    {
        foreach ($this->tablesAll as $tabel) {
            Schema::table($tabel, function (Blueprint $table) {
                $table->timestamps();
                $table->softDeletes();
            });
        }

        foreach ($this->tablesOnlyDeletedAt as $tabel) {
            Schema::table($tabel, function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tablesAll as $tabel) {
            Schema::table($tabel, function (Blueprint $table) {
                $table->dropSoftDeletes();
                $table->dropTimestamps();
            });
        }

        foreach ($this->tablesOnlyDeletedAt as $tabel) {
            Schema::table($tabel, function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
