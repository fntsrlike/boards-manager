<div id="tab_apply" class="container tab-pane">
  <div class="row">
    <div class="col-md-12">
      <h3 class="text-center">Application</h3>
      <div class="container" style="width:600px">
        <form id="apply_form" class="form-horizontal" role="form" method="post">
<!--           <div class="form-group">
            <label for="applyUnit" class="col-sm-2 control-label">單位名稱</label>
            <div class="col-sm-10">
              <input type="text" name="unit" value="" class="form-control" id="applyUnit" placeholder="申請單位名稱">
            </div>
          </div> -->
          <div class="form-group">
            <label for="applyProgram" class="col-sm-2 control-label">Program Name</label>
            <div class="col-sm-10">
              <input type="text" name="program" value="" class="form-control" id="applyProgram" placeholder="宣傳海報活動名稱">
            </div>
          </div>
          <div class="form-group">
            <label for="applyType" class="col-sm-2 control-label">Program Type</label>
            <div class="col-sm-10">
              <select name="type" class="form-control" id="applyType">
                <optgroup label="Type">
                <option value="internal">Internal: Up to 2 weeks post</option>
                <option value="external">External: Up to 3 weeks post</option>
                <option value="internclub">InternClub: Up to 4 weeks post</option>
                </optgroup>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="applyPosition" class="col-sm-2 control-label">Location</label>
            <div class="col-sm-10">
              <select name="code" class="form-control" id="applyPosition">
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
                <option value="W" selected="selected">W</option>
                <option value="X">X</option>
                <option value="Y">Y</option>
                <option value="Z">Z</option>
                </optgroup>
                <optgroup label="Stairs">
                <option value="S">Stairs</option>
                </optgroup>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="applyFrom" class="col-sm-2 control-label">From</label>
            <div class="col-sm-10">
              <input type="date" name="from" value="{{date('Y-m-d')}}" class="form-control" id="applyFrom" placeholder="開始日期">
            </div>
          </div>
          <div class="form-group">
            <label for="applyFrom" class="col-sm-2 control-label">End</label>
            <div class="col-sm-10">
              <input type="date" name="end" value="{{date('Y-m-d')}}" class="form-control" id="applyEnd" placeholder="結束日期">
            </div>
          </div>
          <p class="text-danger text-center"></p>
              <div class="form-group">
            <div class="col-sm-12 text-center">
              <button type="submit" form= "apply_form" class="btn btn-default">Apply</button>
              <button type="reset" class="btn btn-default">Clear</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
