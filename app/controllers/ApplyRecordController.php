<?php
class ApplyRecordController extends BaseController
{
    /**
    * Instantiate a new ApplyRecordController instance.
    */
    public function __construct()
    {
        // C:create, R:read, U:update, D:delete
        $CUD = ['only' => ['store', 'update', 'destroy']];
        $UD  = ['only' => ['update', 'destroy']];
        $R   = ['only' => ['index', 'show']];

        $this->beforeFilter('auth', $CUD);
        $this->beforeFilter('check_record_apply_perm', $CUD);
        $this->beforeFilter('check_record_manage_perm', $UD);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = ApplyRecord::orderBy('created_at', 'desc')
                            ->orderBy('id', 'desc');

        if (Input::has('columns')) {
            $list = explode(',', Input::get('columns'));
            $query->select($list);
            $query->addSelect(['id', 'board_id', 'user_id', 'event_type']);
        }

        if (Input::has('ids')) {
            $list = explode(',', Input::get('ids'));
            $query->whereIn('id', $list);
        }

        if (Input::has('users')) {
            $list = explode(',', Input::get('users'));
            $query->whereIn('user_id', $list);
        }

        if (Input::has('boards')) {
            $list = explode(',', Input::get('boards'));
            $list = Board::unified2Id($list);

            $query->whereIn('board_id', $list);
        }

        if (Input::has('types')) {
            $list = explode(',', Input::get('types'));
            $query->whereIn('event_type', $list);
        }

        if (Input::has('from') and Input::has('end')) {
            $from = Input::get('from', date('Y-m-d'));
            $end  = Input::get('end', date('Y-m-d'));
            $query->whereInterDateRange($from, $end);
        }

        if (Input::has('dates')) {
            $list = explode(',', Input::get('dates'));
            $query->orWhereInDates($list);
        }

        if (Input::has('limit')) {
            $limit   = Input::get('limit');
            $offset  = Input::get('offset', 0);
            $records = $query->skip($offset)->take($limit)->get();
        } else {
            $records = $query->get();
        }

        foreach ($records as $key => $record) {
            $board = Board::find($record->board_id);
            $user  = User::find($record->user_id);
            $type_mapping = Config::get('poster.name_mapping.event_types');

            $record->event_type = $type_mapping[$record->event_type];
            $record->board_code = $board->code;
            $record->username   = $user->username;
            $record->user_title = $user->title;
        }

        return Response::json($records);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        # Config
        $event_types  = Config::get('poster.event_types');
        $days         = Config::get('poster.days');

        # Form Validation
        $rules = [
            'code'     => 'required|exists:boards,code',
            'program'  => 'required|between:3,32',
            'type'     => 'required|in:' . implode(',', $event_types),
            'from'     => 'required|date_format:Y-m-d',
            'end'      => 'required|date_format:Y-m-d',
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'messages' => $validator->errors(),
            ];

            return Response::json($response);
        }

        $from = Input::get('from');
        $end  = Input::get('end');

        if ($from > $end) {
            $response = [
                'success' => false,
                'messages' => 'Begin date is later than end date.',
            ];

            return Response::json($response);
        }

        # Poster Status Validation
        $board     = Board::whereCode(Input::get('code'))->first();
        $day_time  = 24 * 60 * 60;
        $time_diff = strtotime($end) - strtotime($from);
        $days_diff = round($time_diff / $day_time);

        if ($board->getUsingStatus($from, $end)) {
            $response = [
                'success' => false,
                'messages' => 'Board has been applied.',
            ];

            return Response::json($response);
        }

        # Days Validation
        if ($board->type == 'large' and $days_diff > $days['large_poster']) {
            $limit    = $days['large_poster'];
            $response = [
                'success' => false,
                'messages' => "You can't applied over $limit days!",
            ];

            return Response::json($response);
        }

        if ($days_diff > $days[Input::get('type')]) {
            $limit = $days[Input::get('type')];
            $response = [
                'success' => false,
                'messages' => "You can't applied over $limit days!",
            ];

            return Response::json($response);
        }

        # Times Validation
        $boards  = Board::where('type', $board->type)->lists('id');
        $amount  = ApplyRecord::where('user_id', Auth::id())
                              ->whereIn('board_id', $boards)
                              ->whereInterDateRange($from, $end)
                              ->count();
        $quota   = Config::get('poster.meanwhile_quota')[$board->type];

        if ($amount >= $quota) {
            $response = [
                'success' => false,
                'messages' => "You can't apply more than $quota times " .
                              "in the same time.",
            ];

            return Response::json($response);
        }

        # Continuously Validation
        if ($board->type != 'stairs') {
            $cold_down = Config::get('poster.cold_down');
            $from_cd = date('Y-m-d', strtotime("$from - $cold_down days"));
            $end_cd  = date('Y-m-d', strtotime("$end + $cold_down days"));

            $record_cd = ApplyRecord::where('board_id', $board->id)
                                    ->whereInterDateRange($from_cd, $end_cd)
                                    ->where('user_id', Auth::id())
                                    ->count();

            if ($cold_down != 0 and 0 < $record_cd) {
                $response = [
                    'success' => false,
                    'messages' => "You can't apply the same board " .
                                  "continuously.",
                ];

                return Response::json($response);
            }
        }

        # Create
        ApplyRecord::create([
            'board_id'      => $board->id,
            'user_id'       => Auth::id(),
            'event_name'    => Input::get('program'),
            'event_type'    => Input::get('type'),
            'post_from'     => $from,
            'post_end'      => $end,
        ]);

        $response = [
            'success' => true,
            'messages' => 'Create successfully!',
        ];

        return Response::json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $query = ApplyRecord::find($id);
        return Response::json($query);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        # Validaiton
        $rules = [
            'program' => 'required|between:3,32',
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator ->fails()) {
            $response = [
                'success' => false,
                'messages' => $validator->errors(),
            ];

            return Response::json($response);
        }

        # Update
        $update = ['event_name' => Input::get('program')];
        ApplyRecord::find($id)->update($update);

        $response = [
            'success' => true,
            'messages' => 'Updated successfully!',
        ];

        return Response::json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        ApplyRecord::destroy($id);

        $response = [
            'success' => true,
            'messages' => 'Delete successfully!',
        ];

        return Response::json($response);
    }
}
