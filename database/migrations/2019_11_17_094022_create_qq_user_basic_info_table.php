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
            $table->string('qq_nick_name');
            $table->string('qq_avatar_url');
            $table->string('name', 20);
            $table->string('school');
            $table->integer('offical')->nullable();
            $table->integer('sex')->nullable();
            $table->text('des')->nullable();
            $table->string('tags')->nullable();
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
