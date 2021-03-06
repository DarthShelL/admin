<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label', 100);
            $table->integer('parent')->nullable();
            $table->tinyInteger('type');
            $table->enum('method', ['get', 'post', 'put', 'delete', 'options', 'patch'])->nullable();
            $table->string('route')->nullable();
            $table->string('controller');
            $table->string('action', 100);
            $table->string('middleware')->nullable();
            $table->tinyInteger('visible')->default(1);
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
        Schema::dropIfExists('admin_items');
    }
}
