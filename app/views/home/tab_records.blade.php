<div id="tab_records" class="container tab-pane">
  <div class="row">
    <div class="col-md-12">
      <div class="container filter">
        <form id="records_form" class="form" accept-charset="utf-8">
          <div class="col-md-4 text-right">
            <select name="code" class="form-control" style="height: 40px;" /
              data-toggle="tooltip" data-placement="top" title="選擇你要查詢的欄位">
              <option value="all" selected="selected">All</option>
              <optgroup label="Normal">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
                <option value="F">F</option>
                <option value="G">G</option>
                <option value="H">H</option>
                <option value="I">I</option>
                <option value="J">J</option>
                <option value="K">K</option>
                <option value="L">L</option>
              </optgroup>
              <optgroup label="Large">
                <option value="W">W</option>
                <option value="X">X</option>
                <option value="Y">Y</option>
                <option value="Z">Z</option>
              </optgroup>
              <optgroup label="Stairs">
                <option value="S">Stairs</option>
              </optgroup>
            </select>
          </div>
          <div class="col-md-8 text-left">
            <span>From</span>
            <input type="date" name="begin_date" value="" class="form_input" /
              data-toggle="tooltip" data-placement="top" title="開始日期，若無則預設為今日" />
            <span>To</span>
            <input type="date" name="end_date" value="" class="form_input" /
              data-toggle="tooltip" data-placement="top" title="結束日期，若無則預設為今日" />
            <button type="submit" class="btn btn-default" name="submit" /
                    data-toggle="tooltip" data-placement="top" /
                    title="若是日期皆沒選擇，即為查詢全部日期範圍">Search</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-hover">
        <thead>
          <tr>
            <td>No.</td>
            <td>Applicant</td>
            <td>Program</td>
            <td>Type</td>
            <td>Board</td>
            <td>Post Date</td>
            <td>Created At</td>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
