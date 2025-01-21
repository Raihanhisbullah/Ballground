<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lapangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lapangan');
            $table->text('alamat');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->json('area_coordinates');
            $table->decimal('area_size', 10, 2)->comment('in square meters');
            $table->enum('status', ['aktif', 'nonaktif']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lapangan');
    }
};
