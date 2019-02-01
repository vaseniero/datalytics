<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersLicense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_license', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('key')->nullable();
            $table->date('expires_at')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        /**
         * Insert default data
         */
        DB::table('users_license')->insert(
            array(
                'email' => 'admin@datalytics.com',
                'key' => 'ADMINUSERLINCENSEKEY00001',
                'expires_at' => '2019-12-31',
                'status' => true,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_file');
    }
}
