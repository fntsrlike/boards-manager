<div id="tab_boards" class="container tab-pane">
  <div class="row">
    <div class="col-md-12">
      <div class="container filter">
        <div class="col-md-4 text-right">
          <select id="map_form" class="form-control" style="height: 40px;" /
            data-toggle="tooltip" data-placement="top" title="本功能尚未開放">
            <option>Activity Center of NCHU</option>
          </select>
        </div>
        <div class="col-md-8 text-left ">
          <form id="boards_form" class="form" accept-charset="utf-8">
            <span>From</span>
            <input type="date" name="begin_date" value="{{date('Y-m-d')}}" class="form_input" /
              data-toggle="tooltip" data-placement="top" title="開始日期" />
            <span>To</span>
            <input type="date" name="end_date" value="{{date('Y-m-d')}}" class="form_input" /
              data-toggle="tooltip" data-placement="top" title="結束日期" />
            <button type="submit" class="btn btn-default" name="submit" /
                    data-toggle="tooltip" data-placement="top" /
                    title="會查詢與選擇日期有交集的範圍">Search</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table">
        <thead>
          <tr>
            <th data-sort="string">Code</th>
            <th data-sort="string">Type</th>
            <th data-sort="string">Desciption</th>
            <th data-sort="string">Status</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
