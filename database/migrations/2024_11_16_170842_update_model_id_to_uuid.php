<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateModelIdToUuid extends Migration
{
    public function up()
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->string('model_id', 36)->change(); // Ubah tipe kolom menjadi string 36 karakter
        });

        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->string('model_id', 36)->change(); // Ubah tipe kolom menjadi string 36 karakter
        });
    }

    public function down()
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id')->change(); // Kembalikan ke tipe sebelumnya
        });

        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id')->change(); // Kembalikan ke tipe sebelumnya
        });
    }
}
