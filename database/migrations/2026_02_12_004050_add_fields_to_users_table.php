k<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('identificador')->after('id');
            $table->string('nombre', 100)->after('name');
            $table->string('numero_celular', 9)->nullable()->after('nombre');
            $table->string('cedula', 11)->after('numero_celular');
            $table->date('fecha_nacimiento')->after('cedula');
            $table->foreignId('city_id')->after('fecha_nacimiento')->constrained()->onDelete('cascade');
            $table->boolean('is_admin')->default(false)->after('city_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn([
                'identificador',
                'nombre',
                'numero_celular',
                'cedula',
                'fecha_nacimiento',
                'city_id',
                'is_admin'
            ]);
        });
    }
};
