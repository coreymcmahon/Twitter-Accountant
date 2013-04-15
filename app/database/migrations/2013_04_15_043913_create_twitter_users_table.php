<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwitterUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('twitter_users', function(Blueprint $table)
		{
			$table->increments('id');

            $table->string('username', 25);
            $table->integer('twitter_id');
            $table->boolean('is_following_you');
            $table->boolean('is_followed_by_you');
            $table->timestamp('last_update');
			$table->timestamps();

            $table->index('twitter_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('twitter_users');
	}

}
