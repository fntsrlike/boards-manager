<nav id="navigation" class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Boards Management</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav" role="tablist">
        <li>
          <a href="#tab_about" role="tab" data-toggle="tab">About</a>
        </li>
        <li>
          <a href="#tab_map" role="tab" data-toggle="tab">Maps</a>
        </li>
        <li>
          <a href="#tab_list" role="tab" data-toggle="tab">List</a>
        </li>
        </li>
        @if (Auth::check())
        <li>
          <a href="#tab_apply" role="tab" data-toggle="tab">Apply</a>
        </li>
        @endif
        <li>
          <a href="#tab_records" role="tab" data-toggle="tab">Records</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::check())
          <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->username}} <span class="caret"></span></a>            
            <ul class="dropdown-menu" role="menu">
              @if (Auth::user()->can('boards_management'))
              <li>
                <a href="#tab_management" role="tab" data-toggle="tab">Managements</a>
              </li>
              @endif
              @if (Auth::user()->can('users_management'))
                <li>
                  <a href="#tab_administrate" role="tab" data-toggle="tab">Administrate</a>
                </li>
              @endif
              <li>            
                <a href="{{action('AuthController@logout');}}" >Logout</a>
              </li>
            </ul>
          </li>          
        @else
          <li>
            <a href="#" data-toggle="modal" data-target="#modal_register">Register</a>
          </li>
          <li>
            <a href="#" data-toggle="modal" data-target="#modal_login">Login</a>
          </li>
        @endif
      </ul>
    </div>
  </div><!-- /.navbar-collapse -->
</nav><!-- /.container-fluid -->
