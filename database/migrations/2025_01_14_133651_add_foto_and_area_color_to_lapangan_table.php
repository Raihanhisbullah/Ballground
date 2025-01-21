<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('lapangan', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('alamat');
            $table->string('area_color')->default('#3388ff')->after('area_size');
        });
    }

    public function down()
    {
        Schema::table('lapangan', function (Blueprint $table) {
            $table->dropColumn(['foto', 'area_color']);
        });
    }
};
