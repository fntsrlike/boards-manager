<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ApplyRecord extends Eloquent {

	use SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'apply_records';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	protected $fillable = array('board_id', 'user_id', 'event_name', 'event_type', 'post_from', 'post_end');

}
