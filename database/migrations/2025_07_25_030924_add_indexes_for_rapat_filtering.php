<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rapat', function (Blueprint $table) {
            $table->index('waktu_mulai');
        });

        Schema::table('rapat_undangan_internal', function (Blueprint $table) {
            $table->index(['asal', 'id_pegawai']);
            $table->index(['asal', 'id_tamu']);
            $table->index('rapat_id');
        });

        Schema::table('jenis_rapat', function (Blueprint $table) {
            $table->index(['jenis_id', 'rapat_id']);
        });

        Schema::table('event_site_contents', function (Blueprint $table) {
            $table->index('rapat_id');
        });
    }

    public function down(): void
    {
        Schema::table('rapat', function (Blueprint $table) {
            $table->dropIndex(['waktu_mulai']);
        });

        Schema::table('rapat_undangan_internal', function (Blueprint $table) {
            $table->dropIndex(['asal', 'id_pegawai']);
            $table->dropIndex(['asal', 'id_tamu']);
            $table->dropIndex(['rapat_id']);
        });

        Schema::table('jenis_rapat', function (Blueprint $table) {
            $table->dropIndex(['jenis_id', 'rapat_id']);
        });

        Schema::table('event_site_contents', function (Blueprint $table) {
            $table->dropIndex(['rapat_id']);
        });
    }
};
