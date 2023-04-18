<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->unsignedBigInteger('nik');
            $table->string('nama_pemilik');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nama_kendaraan');
            $table->string('nomor_kendaraan');
            $table->integer('nomor_rangka');
            $table->integer('nomor_mesin');
            $table->string('kapasitas_mesin');
            $table->string('poto_kendaraan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kendaraans');
    }
};

