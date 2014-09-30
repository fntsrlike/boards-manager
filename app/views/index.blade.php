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
      width:700px;
      background: rgb(228, 228, 228);
      border-radius: 1em;
      padding: 1em;
      margin-bottom: 2em;
    }
  </style>
  <link rel="stylesheet" href="./assets/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="http://bootswatch.com/paper/bootstrap.min.css"> -->
  <script src="./assets/jquery.min.js"></script>
  <script src="./assets/bootstrap.min.js"></script>
  <script src="./assets/stupidtable.min.js"></script>
  <script src="./assets/home.js"></script>
</head>
<body>
  <div class="tab-content">
    @include('home.nav')
    @include('home.tab_about')
    @include('home.tab_map')
    @include('home.tab_list')
    @include('home.tab_apply')
    @include('home.tab_records')
    @include('home.modal_register')
    @include('home.modal_login')
  </div>
</body>
</html>
