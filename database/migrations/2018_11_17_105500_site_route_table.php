<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiteRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_route', function (Blueprint $table) {
            $table->increments('system_route_id')->index();
            $table->string('system_route_code')->index()->nullable();
            $table->string('system_route_name')->index()->nullable();
            $table->string('system_route_namespace')->index()->nullable();
            $table->string('system_route_controllers')->index()->nullable();
            $table->string('system_route_function')->index()->nullable();
            $table->string('system_route_order')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
