<div id="modal_user_modify" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">User Modify</h4>
      </div>
      <div class="modal-body">
        <form id="user_modify_form" class="form-horizontal" role="form">
          <div class="form-group">
            <label for="userModifyUsername" class="col-sm-2 control-label">ID</label>
            <div class="col-sm-10">
              <input type="text" name="username" value="" class="form-control" id="userModifyUsername" placeholder="3-24 characters" readonly="readonly">
            </div>
          </div>
          <div class="form-group">
            <label for="userModifyPassword" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
              <input type="password" name="password" value="" class="form-control" id="userModifyPassword" placeholder="8-32 characters">
            </div>
          </div>
          <div class="form-group">
            <label for="userModifyPasswordCheck" class="col-sm-2 control-label">Password Checked </label>
            <div class="col-sm-10">
              <input type="password" name="password2" value="" class="form-control" id="userModifyPasswordCheck" placeholder="8-32 characters">
            </div>
          </div>
          <div class="form-group">
            <label for="userModifyRoles" class="col-sm-2 control-label">Roles</label>
            <div class="col-sm-10">
              <input type="text" name="roles" value="" class="form-control" id="userModifyRoles" placeholder="Ex. Administrator">
            </div>
          </div>
          <div class="form-group">
            <label for="userModifyTitle" class="col-sm-2 control-label">Title</label>
            <div class="col-sm-10">
              <input type="text" name="title" value="" class="form-control" id="userModifyTitle" placeholder="Ex. 躲貓貓社社長 吳明世">
            </div>
          </div>
          <div class="form-group">
            <label for="userModifyEmail" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input type="text" name="email" value="" class="form-control" id="userModifyEmail" placeholder="Format: xxxooovvv@cc.ncu.edu.tw">
            </div>
          </div>
          <div class="form-group">
            <label for="userModifyPhone" class="col-sm-2 control-label">Phone</label>
            <div class="col-sm-10">
              <input type="text" name="phone" value="" class="form-control" id="userModifyPhone" placeholder="Format: 09xx-xxxxxx">
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
        <button type="submit" form="user_modify_form" class="btn btn-primary">userModify</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
