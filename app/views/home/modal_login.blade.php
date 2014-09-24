<div id="modal_login" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">User Login</h4>
      </div>
      <div class="modal-body">
        <form id="login_form" class="form-horizontal" role="form">
          <div class="form-group">
            <label for="loginUsername" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">
              <input type="text" name="username" value="" class="form-control" id="loginUsername" placeholder="Username">
            </div>
          </div>
          <div class="form-group">
            <label for="loginPassword" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
              <input type="password" name="password" value="" class="form-control" id="loginPassword" placeholder="Password">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox"> Remember me
                </label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" form="login_form">Login</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
