<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username')->nullable();
			$table->string('email')->nullable();
			$table->string('password')->nullable();
			$table->boolean('active')->default(0);
			$table->string('remember_token')->nullable();
			$table->string('code')->nullable();
			$table->boolean('banned')->default(0);
			$table->string('fullname')->nullable();
			$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP')); $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->string('avatar', 45)->nullable();
			$table->string('background', 45)->nullable();
			$table->text('about', 65535)->nullable();
			$table->string('role', 45)->default('user');
			$table->softDeletes();
			$table->string('location')->nullable();
			$table->boolean('showmail')->default(0);
			$table->integer('background_position')->default(0);
			$table->string('facebook_id')->nullable();
			$table->string('twitter_id')->nullable();
			$table->string('google_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
