<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id');
			$table->string('title', 45);
			$table->text('description', 65535)->nullable();
			$table->string('image', 45)->nullable();
			$table->string('lat', 45)->nullable();
			$table->string('lng', 45)->nullable();
			$table->string('time', 45)->nullable();
			$table->date('date')->nullable();
			$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP')); $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->boolean('guestCanInvite')->default(1);
			$table->boolean('guestCanPublish')->default(1);
			$table->integer('cover_position')->nullable();
			$table->string('type', 45)->default('public');
			$table->string('city', 45)->nullable();
			$table->string('country', 45)->nullable();
			$table->softDeletes();
			$table->string('slug')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('events');
	}

}
