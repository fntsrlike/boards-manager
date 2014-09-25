<?php

class Board extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'boards';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	protected $fillable = array('type', 'code', 'description');

	public function isUsing($from='', $end='') 
    {
		if ( empty($from) or empty($end) ) {
            $from = $end = date("Y-m-d") ;
        }

		$record = ApplyRecord::where('board_id', '=', $this->id)
							->whereRaw(" (`post_from` <= $from AND `post_end` >= $from ) OR " .
									   " (`post_from` <= $end AND `post_from` >= $end )   OR " .
									   " (`post_from` >= $from AND `post_from` <= $end ) ")	
							->first();
		return !is_null($record);
	}

    public function scopreIsUsing($query, $from='', $end='') 
    {
        if ( empty($from) or empty($end) ) {
            $from = $end = date("Y-m-d") ;
        }

        return $query->where('board_id', '=', $this->id)
                     ->whereRaw(" (`post_from` <= $from AND `post_end` >= $from ) OR " .
                                " (`post_from` <= $end AND `post_from` >= $end )   OR " .
                                " (`post_from` >= $from AND `post_from` <= $end ) ") ;
                            
    }
}
