<div id="tab_users" class="container tab-pane">
  <div class="row">
    <div class="col-md-12">
      <div class="container filter">
        <div class="col-md-12 text-left ">
          <form id="users_form" class="form" accept-charset="utf-8">
            <div class="col-md-4 text-right">
              <select name="role" class="form-control" style="height: 40px;" /
                data-toggle="tooltip" data-placement="top" title="選擇使用者角色">
                <option selected>All</option>
                <option >Normal</option>
                <option >Manager</option>
                <option >Administrator</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table">
        <thead>
          <tr>
            <th data-sort="string">ID</th>
            <th data-sort="string">User Name</th>
            <th data-sort="string">Email</th>
            <th data-sort="string">Phone</th>
            <th data-sort="string">Roles</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
