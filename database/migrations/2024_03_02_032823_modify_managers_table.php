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
        Schema::table('managers', function (Blueprint $table) {
            // Change column type to text
            $table->string('phoneNum')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('managers', function (Blueprint $table) {
            // Change column type to text
            $table->int('phoneNum')->change();
        });
    }
};
