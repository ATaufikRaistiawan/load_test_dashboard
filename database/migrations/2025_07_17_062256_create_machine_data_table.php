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
        Schema::create('machine_data', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp')->useCurrent();  // your custom timestamp
            $table->integer('rpm');
            $table->integer('total_revs');
            $table->float('load_kn');
            $table->timestamps(); // this adds created_at + updated_at (don't add them manually!)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_data');
    }
};
