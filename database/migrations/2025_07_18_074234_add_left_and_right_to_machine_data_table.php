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
        Schema::table('machine_data', function (Blueprint $table) {
            //
            $table->boolean('left_status')->default(false);
            $table->timestamp('timestamp')->useCurrent();
            $table->integer('rpm');
            $table->float('load_kn');
            $table->bigInteger('total_revs');
            $table->boolean('alarm')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('machine_data', function (Blueprint $table) {
            //
        });
    }
};
