<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQqUserBasicInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qq_user_basic_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
            $table->string('school', 50);
            $table->integer('offical')->nullable();
            $table->integer('sex')->default(1);
            $table->text('des')->nullable();
            $table->string('tag')->nullable();
            $table->integer('level');
            $table->date('last_actived_at');
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
        Schema::dropIfExists('qq_user_basic_info');
    }
}
