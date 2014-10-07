<div id="modal_register" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Register Application</h4>
      </div>
      <div class="modal-body">
        <form id="register_form" class="form-horizontal" role="form">
          <div class="form-group">
            <label for="registerUsername" class="col-sm-2 control-label">ID</label>
            <div class="col-sm-10">
              <input type="text" name="username" value="" class="form-control" id="registerUsername" placeholder="6-24 characters">
            </div>
          </div>
          <div class="form-group">
            <label for="registerPassword" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
              <input type="password" name="password" value="" class="form-control" id="registerPassword" placeholder="6-32 characters">
            </div>
          </div>
          <div class="form-group">
            <label for="registerPasswordCheck" class="col-sm-2 control-label">Password Checked </label>
            <div class="col-sm-10">
              <input type="password" name="password2" value="" class="form-control" id="registerPasswordCheck" placeholder="6-32 characters">
            </div>
          </div>
          <div class="form-group">
            <label for="registerTitle" class="col-sm-2 control-label">Title</label>
            <div class="col-sm-10">
              <input type="text" name="title" value="" class="form-control" id="registerTitle" placeholder="Ex. 躲貓貓社社長 吳明世">
            </div>
          </div>
          <div class="form-group">
            <label for="registerEmail" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input type="text" name="email" value="" class="form-control" id="registerEmail" placeholder="Format: xxxooovvv@cc.ncu.edu.tw">
            </div>
          </div>
          <div class="form-group">
            <label for="registerPhone" class="col-sm-2 control-label">Phone</label>
            <div class="col-sm-10">
              <input type="text" name="phone" value="" class="form-control" id="registerPhone" placeholder="Format: 09xx-xxxxxx">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 text-danger">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" form="register_form" class="btn btn-primary">Register</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
