<div id="tab_apply" class="container tab-pane">
  <div class="row">
    <div class="col-md-12">
      <h3 class="text-center">欄位申請表單</h3>
      <div class="container" style="width:600px">
        <form id="apply_form" class="form-horizontal" role="form" method="post">
<!--           <div class="form-group">
            <label for="applyUnit" class="col-sm-2 control-label">單位名稱</label>
            <div class="col-sm-10">
              <input type="text" name="unit" value="" class="form-control" id="applyUnit" placeholder="申請單位名稱">
            </div>
          </div> -->
          <div class="form-group">
            <label for="applyProgram" class="col-sm-2 control-label">活動名稱</label>
            <div class="col-sm-10">
              <input type="text" name="program" value="" class="form-control" id="applyProgram" placeholder="宣傳海報活動名稱">
            </div>
          </div>
          <div class="form-group">
            <label for="applyType" class="col-sm-2 control-label">活動類型</label>
            <div class="col-sm-10">
              <select name="type" class="form-control" id="applyType">
                <optgroup label="活動類型">
                <option value="1">張貼最多6天：大掛報 (不論活動類型)</option>
                <option value="2">張貼最多2週：小型活動 (Ex. 迎新、送舊)</option>
                <option value="3">張貼最多3週：大型活動 (Ex. 周展、營隊)</option>
                <option value="4">張貼最多4週：跨社活動 (Ex. 聯合活動)</option>
                </optgroup>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="applyPosition" class="col-sm-2 control-label">欄位位置</label>
            <div class="col-sm-10">
              <select name="code" class="form-control" id="applyPosition">
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
                <option value="W" selected="selected">W</option>
                <option value="X">X</option>
                <option value="Y">Y</option>
                <option value="Z">Z</option>
                </optgroup>
                <optgroup label="樓梯欄位">
                <option value="S">樓梯欄位</option>
                </optgroup>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="applyFrom" class="col-sm-2 control-label">開始日期</label>
            <div class="col-sm-10">
              <input type="date" name="from" value="2014-09-23" class="form-control" id="applyFrom" placeholder="開始日期">
            </div>
          </div>
          <div class="form-group">
            <label for="applyFrom" class="col-sm-2 control-label">結束日期</label>
            <div class="col-sm-10">
              <input type="date" name="end" value="2014-09-23" class="form-control" id="applyEnd" placeholder="結束日期">
            </div>
          </div>
          <p class="text-danger text-center"></p>
              <div class="form-group">
            <div class="col-sm-12 text-center">
              <button type="submit" form= "apply_form" class="btn btn-default">送出</button>
              <button type="reset" class="btn btn-default">清除</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
