<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NEW PHONE | ระบบเติมเงิน</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>

  <script src="/js/angularjs/app.js"></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .status_icon{
      max-height: 250px;
    }

    .status_msg_success{
      color: green;
    }

    .status_msg_error{
      color: red;
    }
    .loading_balance{
      height: 15px;
    }
  </style>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav skin-black" ng-app="topupApp" ng-controller="topupController">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">


        <div class="navbar-header">
          <a href="../../index2.html" class="navbar-brand" style="padding: 0"><img src="/logo/logo_sm_text_right.png" height="40px" style="margin-top:5px"></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="#" ng-click="showTopupHistory()"><i class="fa fa-fw fa-history"></i> ประวัติการเติมเงิน (รายวัน)</a></li>
          </ul>
        </div>

        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="hidden-xs">ยอดเงินคงเหลือ: <span ng-bind-html="balance"></span> บาท</span>
              </a>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          ระบบเติมเงิน
          <small>เวอร์ชั่น 1.0</small>
        </h1>
        <ol class="breadcrumb">
          <li class="active">{{$user->branch_name}}</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">AIS</h3>
              </div>
              <div class="box-body">
                <center><img src="/logo/ais_logo.jpg" width="200" height="80"></center>
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร" ng-model="ais_number">
                <br>
                <select class="form-control" ng-model="ais_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="5">5 (ไม่มีส่วนลด,ยกเลิกไม่ได้)</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                  <option value="40">40</option>
                  <option value="50">50</option>
                  <option value="60">60</option>
                  <option value="70">70</option>
                  <option value="80">80</option>
                  <option value="90">90</option>
                  <option value="100">100</option>
                  <option value="150">150</option>
                  <option value="200">200</option>
                  <option value="300">300</option>
                  <option value="350">350</option>
                  <option value="400">400</option>
                  <option value="500">500</option>
                  <option value="800">800</option>
                  <option value="1000">1000</option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill(1,ais_number,ais_cash,users)">เติมเงิน</button>
              </div>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

          <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">DTAC</h3>
              </div>
              <div class="box-body">
                <center><img src="/logo/dtac_logo.jpg" width="200" height="80"></center>
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร" ng-model="dtac_number">
                <br>
                <select class="form-control" ng-model="dtac_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                  <option value="40">40</option>
                  <option value="50">50</option>
                  <option value="60">60</option>
                  <option value="100">100</option>
                  <option value="200">200</option>
                  <option value="300">300</option>
                  <option value="500">500</option>
                  <option value="800">800</option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill(2,dtac_number,dtac_cash,users)">เติมเงิน</button>
              </div>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

          <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">TRUE-H</h3>
              </div>
              <div class="box-body">
                <center><img src="/logo/true_h_logo.jpg" width="200" height="80"></center>
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร" ng-model="true_number">
                <br>
                <select class="form-control" ng-model="true_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                  <option value="40">40</option>
                  <option value="50">50</option>
                  <option value="60">60</option>
                  <option value="70">70</option>
                  <option value="80">80</option>
                  <option value="90">90</option>
                  <option value="100">100</option>
                  <option value="150">150</option>
                  <option value="200">200</option>
                  <option value="250">250</option>
                  <option value="300">300</option>
                  <option value="350">350</option>
                  <option value="400">400</option>
                  <option value="450">450</option>
                  <option value="500">500</option>
                  <option value="800">800</option>
                  <option value="1000">1000</option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill(3,true_number,true_cash,users)">เติมเงิน</button>
              </div>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

          <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">my by CAT</h3>
              </div>
              <div class="box-body">
                <center><img src="/logo/my.jpg" width="200" height="80"></center>
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร" ng-model="my_number">
                <br>
                <select class="form-control" ng-model="my_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                  <option value="300">300</option>
                  <option value="500">500</option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill(5,my_number,my_cash,users)">เติมเงิน</button>
              </div>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

          <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">I MOBILE 3G X</h3>
              </div>
              <div class="box-body">
                <center><img src="/logo/imobile.jpg" width="200" height="80"></center>
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร" ng-model="imobile_number">
                <br>
                <select class="form-control" ng-model="imobile_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                  <option value="40">40</option>
                  <option value="50">50</option>
                  <option value="60">60</option>
                  <option value="70">70</option>
                  <option value="80">80</option>
                  <option value="90">90</option>
                  <option value="100">100</option>
                  <option value="150">150</option>
                  <option value="200">200</option>
                  <option value="250">250</option>
                  <option value="300">300</option>
                  <option value="350">350</option>
                  <option value="400">400</option>
                  <option value="450">450</option>
                  <option value="500">500</option>
                  <option value="800">800</option>
                  <option value="1000">1000</option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill(4,imobile_number,imobile_cash,users)">เติมเงิน</button>
              </div>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

          <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">PENGUIN</h3>
              </div>
              <div class="box-body">
                <center><img src="/logo/penguinsim.jpg" width="200" height="80"></center>
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร" ng-model="pengoin_number">
                <br>
                <select class="form-control" ng-model="pengoin_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                  <option value="40">40</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                  <option value="200">200</option>
                  <option value="300">300</option>
                  <option value="500">500</option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill(7,pengoin_number,pengoin_cash,users)">เติมเงิน</button>
              </div>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

        </div>

        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->


  <div class="modal fade" id="modal-topup-status">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">ผลการเติมเงิน</h4>
        </div>
        <div class="modal-body text-center" ng-bind-html="content_topup_status">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-block" data-dismiss="modal">ปิด</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="modal-topup-history">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-fw fa-history"></i> ประวัติการเติมเงิน (รายวัน)</h4>
        </div>
        <div class="modal-body">

            <table class="table table-hover">
              <tbody><tr>
                <th>หมายเลขรายการ</th>
                <th>วัน-เวลา</th>
                <th>สาขา</th>
                <th>เครือข่าย</th>
                <th>หมายเลข</th>
                <th>ยอดเงิน</th>
                <th>สถานะ</th>
              </tr>
              <tr ng-if="topup_histories.length == 0">
                <td colspan="7" class="text-center">ไม่มีข้อมูล</td>
              </tr>
              <tr ng-repeat="data in topup_histories">
                <td><% data.orderid %></td>
                <td><% data.created_at %></td>
                <td><% data.branch_name %></td>
                <td><% data.network %></td>
                <td><% data.number %></td>
                <td><% data.cash %></td>
                <td><span class="label label-warning" ng-if="data.status == 0">กำลังดำเนินการ</span><span class="label label-success" ng-if="data.status == 1">สำเร็จ</span><span class="label label-danger" ng-if="data.status == 2">ไม่สำเร็จ</span></td>
              </tr>
              </tbody>
            </table>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-block" data-dismiss="modal">ปิด</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
      </div>
      <strong>Copyright &copy; 2017 <a href="#">NEW PHONE</a>.</strong> All rights
      reserved.
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/dist/js/demo.js"></script>

<script>

    branch_name = '{{$user->branch_name}}';
    var Encryption={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Encryption._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Encryption._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}};

</script>
</body>
</html>
