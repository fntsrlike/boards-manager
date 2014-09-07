<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplyRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('apply_records', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('board_id');	// Apply Board
			$table->integer('user_id');		// Applicants
			$table->string('event_name');   // Name of event
			$table->string('event_type');	// To decide the maximum days could apply.
			$table->date('post_from');		// From
			$table->date('post_end');		// To
			$table->softDeletes();
			$table->timestamps();
			$table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');;
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('records');
	}

}
