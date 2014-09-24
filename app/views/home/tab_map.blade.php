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
          <select class="form-control" style="height: 40px;">
            <option>國立中興大學圓廳</option>
          </select>
        </div>
        <div class="col-md-8 text-left ">
          <form class="form" accept-charset="utf-8">
            <span>從</span>
            <input type="date" name="begin_date" value="2014-09-23" class="form_input">
            <span>到</span>
            <input type="date" name="end_date" value="2014-09-23" class="form_input">
            <button type="submit" class="btn btn-default" name="submit">查詢</button>
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
