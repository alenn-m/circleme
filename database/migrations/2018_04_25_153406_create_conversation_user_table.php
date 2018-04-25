<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConversationUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conversation_user', function(Blueprint $table)
		{
			$table->integer('conversation_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->boolean('opened')->default(0);
			$table->primary(['conversation_id','user_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('conversation_user');
	}

}
