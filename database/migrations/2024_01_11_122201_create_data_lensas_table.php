<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataLensasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_lensas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('nama_alat');
            $table->integer('harga24');
            $table->integer('harga12');
            $table->integer('harga6');
            $table->string('gambar')->default('noimage.jpg'); // Ubah tipe kolom menjadi string
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_lensas');
    }
}
