<div id="tab_records" class="container tab-pane">
  <div class="row">
    <div class="col-md-12">
      <div class="container filter">
        <form id="records_form" class="form" accept-charset="utf-8">
          <div class="col-md-4 text-right">
            <select name="code" class="form-control" style="height: 40px;" /
              data-toggle="tooltip" data-placement="top" title="選擇你要查詢的欄位">
              <option value="all" selected="selected">全部欄位</option>
              <optgroup label="大型佈告欄位">
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
              <optgroup label="大掛報">
                <option value="W">W</option>
                <option value="X">X</option>
                <option value="Y">Y</option>
                <option value="Z">Z</option>
              </optgroup>
              <optgroup label="樓梯欄位">
                <option value="S">樓梯欄位</option>
              </optgroup>
            </select>
          </div>
          <div class="col-md-8 text-left">
            <span>從</span>
            <input type="date" name="begin_date" value="" class="form_input" /
              data-toggle="tooltip" data-placement="top" title="開始日期，若無則預設為今日" />
            <span>到</span>
            <input type="date" name="end_date" value="" class="form_input" /
              data-toggle="tooltip" data-placement="top" title="結束日期，若無則預設為今日" />
            <button type="submit" class="btn btn-default" name="submit" /
                    data-toggle="tooltip" data-placement="top" /
                    title="若是日期皆沒選擇，即為查詢全部日期範圍">查詢</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table">
        <thead>
          <tr>
            <td>No.</td>
            <td>Unit</td>
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
