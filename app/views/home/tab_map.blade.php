<style type="text/css">
  .unit.full {
      background-color: rgba(255,0,0,0.6);
  }

  .unit.empty {
      background-color: rgba(0,0,255,0.6);
  }
</style>

<div id="tab_map" class="container tab-pane active">
  <div class="row">
    <div class="col-md-12">
      <div class="container filter">
        <div class="col-md-4 text-right">
          <select id="map_form" class="form-control" style="height: 40px;" /
            data-toggle="tooltip" data-placement="top" title="本功能尚未開放">
            <option>國立中興大學圓廳</option>
          </select>
        </div>
        <div class="col-md-8 text-left ">
          <form id="map_date_form" class="form" accept-charset="utf-8">
            <span>從</span>
            <input type="date" name="begin_date" value="{{date('Y-m-d')}}" class="form_input" /
              data-toggle="tooltip" data-placement="top" title="開始日期" />
            <span>到</span>
            <input type="date" name="end_date" value="{{date('Y-m-d')}}" class="form_input" /
              data-toggle="tooltip" data-placement="top" title="結束日期" />
            <button type="submit" class="btn btn-default" name="submit" /
                    data-toggle="tooltip" data-placement="top" /
                    title="會查詢與選擇日期有交集的範圍">查詢</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      @include('home.map.nchu');
    </div>
  </div>
</div>
