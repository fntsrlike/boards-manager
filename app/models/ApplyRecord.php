<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ApplyRecord extends Eloquent
{
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
    protected $hidden = [];

    protected $fillable = ['board_id', 'user_id', 'event_name', 'event_type',
                           'post_from', 'post_end'];

    # Is this user id same as record applicant
    public function isApplicant($user_id)
    {
        return ($this->user_id == $user_id);
    }

    # Which record's date range intersect with this date range
    public function scopeWhereInterDateRange($query, $from = '', $end = '')
    {
        if (empty($from) or empty($end)) {
            $from = date("Y-m-d");
            $end  = date("Y-m-d");
        }

        $query->where(function($query) use ($from, $end) {
            $query->orWhereBetweenCols($from, ['post_from', 'post_end'])
                  ->orWhereBetweenCols($end,  ['post_from', 'post_end'])
                  ->orWhereInDateRange($from, $end);
        });

        return $query;
    }

    # Which record's date include this date range
    public function scopeWhereInDateRange($query, $from = '', $end = '')
    {
        if (empty($from) or empty($end)) {
            $from = date("Y-m-d");
            $end  = date("Y-m-d");
        }

        $query->whereRaw("`post_from` >= '$from' AND '$end' <= `post_end`");

        return $query;
    }

    # Similar as scopeWhereInDateRange()
    public function scopeOrWhereInDateRange($query, $from = '', $end = '')
    {
        $query->orWhere(function($query) use ($from, $end) {
            $query->whereInDateRange($from, $end);
        });

        return $query;
    }

    # Which record's date include all of these dates
    public function scopeWhereInDates($query, $dates)
    {
        foreach ($dates as $date) {
            if (strtotime($date)) {
                $date = date('Y-m-d', strtotime($date));
                $query->whereBetweenCols($date, ['post_from', 'post_end']);
            }
        }

        return $query;
    }

    # Which record's date include one of these dates
    public function scopeOrWhereInDates($query, $dates)
    {
        $query->where(function($query) use ($dates) {
            foreach ($dates as $date) {
                if (strtotime($date)) {
                    $date = date('Y-m-d', strtotime($date));
                    $cols = ['post_from', 'post_end'];
                    $query->orWhereBetweenCols($date, $cols);
                }
            }
        });

        return $query;
    }

    public function scopeWhereBetweenCols($query, $value, $cols)
    {
        $query->whereRaw("('$value' between `{$cols[0]}` AND `{$cols[1]}`)");

        return $query;
    }

    public function scopeOrWhereBetweenCols($query, $value, $cols)
    {
        $query->orWhere(function($query) use ($value, $cols) {
            $query->whereBetweenCols($value, $cols);
        });

        return $query;
    }
}
