<?php

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
            $table->foreignId('formateur_id')->nullable()->after('id');
            $table->foreign('formateur_id')->references('id')->on('formateurs')->nullOnDelete();

            $table->foreignId('niveau_id')->nullable()->after('id');
            $table->foreign('niveau_id')->references('id')->on('niveaux')->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['formateur_id']);
            $table->dropForeign(['niveau_id']);

            $table->dropColumn('formateur_id');
            $table->dropColumn('niveau_id');
        });
    }
};
