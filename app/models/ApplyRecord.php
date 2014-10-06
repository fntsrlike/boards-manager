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

	public function isApplicant($user_id) {
		return $this->user_id == $user_id;
	}

	public function scopeDate($query, $from='', $end='')
	{
		if ( empty($from) or empty($end) ) {
			$from = $end = date("Y-m-d") ;
		}

		$query->where(function($query) use ($from, $end) {
			$query->orWhereRaw("'$from' between `post_from` AND `post_end`")
				  ->orWhereRaw("'$end'  between `post_from` AND `post_end`")
				  ->orWhereRaw("'$from' <= `post_from` AND `post_end` <= '$end'");
		});

		return $query;

	}

}
