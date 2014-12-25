<div id="modal_record_modify" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Record Modify</h4>
      </div>
      <div class="modal-body">
        <form id="record_modify_form" class="form-horizontal" role="form">
          <div class="form-group">
            <label for="recordModifyId" class="col-sm-4 control-label">ID</label>
            <div class="col-sm-8">
              <input type="text" name="id" value="" class="form-control" id="recordModifyId" placeholder="Not initialize" readonly="readonly">
            </div>
          </div>
          <div class="form-group">
            <label for="recordModifyCode" class="col-sm-4 control-label">Board Code</label>
            <div class="col-sm-8">
              <input type="text" name="code" value="" class="form-control" id="recordModifyCode" placeholder="Not initialize" disabled="disabled">
            </div>
          </div>
          <div class="form-group">
            <label for="recordModifyFrom" class="col-sm-4 control-label">Begin Date</label>
            <div class="col-sm-8">
              <input type="text" name="from" value="" class="form-control" id="recordModifyFrom" placeholder="Not initialize" disabled="disabled">
            </div>
          </div>
          <div class="form-group">
            <label for="recordModifyEnd" class="col-sm-4 control-label">End Date</label>
            <div class="col-sm-8">
              <input type="text" name="end" value="" class="form-control" id="recordModifyEnd" placeholder="Not initialize" disabled="disabled">
            </div>
          </div>
          <div class="form-group">
            <label for="recordModifyName" class="col-sm-4 control-label">Program Name</label>
            <div class="col-sm-8">
              <input type="text" name="name" value="" class="form-control" id="recordModifyName" placeholder="6-24 characters">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8 text-danger">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" form="record_modify_form" class="btn btn-primary">Modify</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
