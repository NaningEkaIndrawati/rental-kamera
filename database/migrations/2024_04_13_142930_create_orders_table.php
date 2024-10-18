<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alat_id')->references('id')->on('alats')->onDelete('cascade');
            $table->foreignId('penyewa_id')->constrained('penyewas')->onDelete('cascade');
            $table->foreignId('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->integer('durasi');
            $table->dateTime('starts');
            $table->dateTime('ends');
            $table->integer('harga');
            //! denda
            $table->boolean('is_denda')->default(false)->nullable();
            $table->integer('jumlah_denda')->default(0)->nullable();
            $table->dateTime('tanggal_denda')->nullable();
            $table->integer('status_denda')->default(1);
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
        Schema::dropIfExists('orders');
    }
}
