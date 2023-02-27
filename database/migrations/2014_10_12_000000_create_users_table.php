<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('u_name',50);
            $table->string('u_level_id',11)->nullable();
            $table->string('title_name_id',11);
            $table->string('branch_id',11)->nullable();
            $table->string('fname_TH',50);
            $table->string('lname_TH',50);
            $table->string('fname_EN',50)->nullable();
            $table->string('lname_EN',50)->nullable();
            $table->string('email')->nullable();
            $table->string('tel',11)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('active',[0,1]);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
