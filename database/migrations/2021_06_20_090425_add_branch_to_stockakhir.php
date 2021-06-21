<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchToStockakhir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stockakhir', function (Blueprint $table) {
            $table->bigInteger('branchId')->after('activeCash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stockakhir', function (Blueprint $table) {
            $table->dropColumn(['branchId']);
        });
    }
}
