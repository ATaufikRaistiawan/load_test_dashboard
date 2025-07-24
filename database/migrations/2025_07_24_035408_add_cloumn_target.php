<?php

use App\Models\MachineLeftData;
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
        Schema::table('machine_left_data', function(Blueprint $table){
            $table->integer('rpm_target');
            $table->integer('load_kn_target');
            $table->integer('total_revs_target');
            $table->boolean('isRunning');
        });

        Schema::table('machine_right_data', function(Blueprint $table){
            $table->integer('rpm_target');
            $table->integer('load_kn_target');
            $table->integer('total_revs_target');
            $table->boolean('isRunning');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('machine_left_data', function (Blueprint $table) {
            $table->dropColumn('rpm_target');
            $table->dropColumn('load_kn_target');
            $table->dropColumn('total_revs_target');
            $table->dropColumn('isRunning');
        });
        
        Schema::table('machine_right_data', function (Blueprint $table) {
            $table->dropColumn('rpm_target');
            $table->dropColumn('load_kn_target');
            $table->dropColumn('total_revs_target');
            $table->dropColumn('isRunning');
        });
    }
};
