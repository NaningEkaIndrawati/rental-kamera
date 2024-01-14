<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DataLensas extends Migration
{
    public function up()
    {
        Schema::create('data_lensas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lensa');
            $table->decimal('harga_lensa', 10, 3);
            $table->string('gambar_lensa');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->boolean('status_ketersediaan')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_lensas');
    }
}

