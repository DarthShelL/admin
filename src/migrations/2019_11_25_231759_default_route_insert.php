<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DefaultRouteInsert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('admin_items')->insert([
            [
                'label' => 'dashboard',
                'parent' => null,
                'type' => 0,
                'method' => 'get',
                'route' => 'admin/index',
                'controller' => 'DarthShelL\Admin\AdminController',
                'action' => 'index',
                'visible' => 1
            ]
        ]);
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
