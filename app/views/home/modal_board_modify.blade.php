<div id="modal_board_modify" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Board Modify</h4>
      </div>
      <div class="modal-body">
        <form id="board_modify_form" class="form-horizontal" role="form">
          <div class="form-group">
            <label for="boardModifyId" class="col-sm-2 control-label">ID</label>
            <div class="col-sm-10">
              <input type="text" name="id" value="" class="form-control" id="boardModifyId"  placeholder="Not initialize" readonly="readonly">
            </div>
          </div>
          <div class="form-group">
            <label for="boardModifyCode" class="col-sm-2 control-label">Code</label>
            <div class="col-sm-10">
              <input type="text" name="code" value="" class="form-control" id="boardModifyCode"  placeholder="VNot initialize" readonly="readonly">
            </div>
          </div>
          <div class="form-group">
            <label for="boardModifyDescription" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
              <input type="text" name="decription" value="" class="form-control" id="boardModifyDescription" placeholder="Description about this board.">
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 text-danger">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" form="board_modify_form" class="btn btn-primary">Modify</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
