<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('name',100)->unique(); 
            $table->string('email',100)->unique();            
           // $table->timestamp('email_verified_at')->nullable();
            $table->text('password');
            $table->string('profile_photo');
            $table->string('type')->default(1);
            $table->string('phone',20)->nullable();; 
            $table->string('address',300)->nullable(); 
            $table->string('date_of_birth')->nullable();
            $table->integer('created_user_id');
            $table->integer('updated_user_id');
            $table->integer('deleted_user_id')->nullable();
            

            $table->rememberToken();
            $table->softDeletes();
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
}
