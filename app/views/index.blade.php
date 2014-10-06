<html>
<head>
  <meta charset="utf-8" />
  <title>BMS</title>

  <style type="text/css">
  　.container, .blue {
      background: #d9edf7;
      padding:1em;
    }

    .filter {
      width:750px;
      background: rgb(228, 228, 228);
      border-radius: 1em;
      padding: 1em;
      margin-bottom: 2em;
    }
  </style>
  <link rel="stylesheet" href="./vendor/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="./vendor/sweetalert/lib/sweet-alert.css" />

  <script src="./vendor/jquery/dist/jquery.min.js"></script>
  <script src="./vendor/jquery/dist/jquery.min.map"></script>
  <script src="./vendor/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="./vendor/sweetalert/lib/sweet-alert.min.js"></script>
  <script src="./assets/stupidtable.min.js"></script>
  <script src="./assets/config.js"></script>
  <script src="./assets/i18n.js"></script>
  <script src="./assets/models.js"></script>
  <script src="./assets/views.js"></script>
  <script src="./assets/events.js"></script>
  <script src="./assets/main.js"></script>
</head>
<body>
  @include('home.nav')
  <div class="tab-content">
    @include('home.tab_about')
    @include('home.tab_map')
    @include('home.tab_boards')
    @include('home.tab_records')
    @include('home.tab_apply')
  </div>
  @include('home.modal_register')
  @include('home.modal_login')
</body>
</html>
