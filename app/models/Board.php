<?php
class Board extends Eloquent
{
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
    protected $hidden   = [];
    protected $fillable = ['type', 'code', 'description'];

    # Covert code to id
    public static function unified2Id($list)
    {
        foreach ($list as $key => $value) {
            if (!is_numeric($value)) {
                $board = Board::where('code', $value)->first();

                if ($board != null) {
                    $list[$key] = $board->id;
                } else {
                    unset($list[$key]);
                }
            }
        }

        return $list;
    }

    # If board is using, return relative record id, or return false
    public function getUsingStatus($from = '', $end = '')
    {
        if (empty($from) or empty($end)) {
            $from = date("Y-m-d");
            $end  = date("Y-m-d");
        }

        if ($this->type == 'stairs') {
            if (Auth::check()) {
                $record = ApplyRecord::whereInterDateRange($from, $end)
                            ->where('board_id', $this->id)
                            ->where('user_id', Auth::id())
                            ->first();

                return is_null($record) ? false : $record->id;
            }

            return false;
        }

        $record = ApplyRecord::whereInterDateRange($from, $end)
                    ->where('board_id', '=', $this->id)
                    ->max('post_from')
                    ->first();

        return is_null($record) ? false : $record->id;
    }

    public function scopeWhereCode($query, $code)
    {
        return $query->where('code', $code);
    }

    # Fetch board(s) which is being used
    public function scopeWhereIsUsing($query, $from = '', $end = '')
    {
        if (empty($from) or empty($end)) {
            $from = date("Y-m-d");
            $end  = date("Y-m-d");
        }

        $records = ApplyRecord::whereInterDateRange($from, $end);

        $using_boards = array_unique($records->lists('board_id'));

        return $query->whereIn('id', $using_boards);
    }

    # Fetch board(s) which is not being used
    public function scopeWhereIsEmpty($query, $from = '', $end = '')
    {
        if (empty($from) or empty($end)) {
            $from = date("Y-m-d");
            $end  = date("Y-m-d");
        }

        $records = ApplyRecord::whereInterDateRange($from, $end);

        $using_boards = array_unique($records->lists('board_id'));

        return $query->whereNotIn('id', $using_boards);
    }
}
