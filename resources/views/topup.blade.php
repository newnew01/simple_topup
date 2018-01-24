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
  <link href="/plugins/toastjs/toastr.min.css" rel="stylesheet"/>

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
          <a href="#" class="navbar-brand" style="padding: 0"><img src="/logo/logo_sm_text_right.png" height="40px" style="margin-top:5px"></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="#" ng-click="showTopupHistory()"><i class="fa fa-fw fa-history"></i> ประวัติการเติมเงิน (รายวัน)</a></li>
            <li><a href="#" ng-click="getTodayReport()"><i class="fa fa-fw fa-list"></i> สรุปเติมเงิน (รายวัน)</a></li>
            <li><a href="#" ng-click="getAllReport()"><i class="fa fa-fw fa-bar-chart-o"></i> สรุปยอดทั้งหมด</a></li>
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
          <small>เวอร์ชั่น 2.0</small>
        </h1>
        <ol class="breadcrumb">
          <li class="active">{{Auth::user()->branch_name}}</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <!-- Form Element sizes -->
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">เลือกเครือข่ายอัตโนมัติ</h3><small> (แค่ใส่เบอร์ก็รู้เครือข่าย)</small>
              </div>
              <div class="box-body">

                <div class="row">
                  <div class="col-md-3">
                    <center><img ng-src="<% search_logo %>" src="/logo/search_logo.jpg" height="40"></center>
                  </div>
                  <div class="col-md-5">
                    <input class="form-control input-lg" type="text" placeholder="เบอร์โทร" ng-model="number_search" ng-change="getOperator()">
                  </div>
                  <div class="col-md-2">
                    <select class="form-control" ng-model="auto_operator_cash" ng-disabled="!autoOperatorReady">
                      <option value="">คลิกเลือกราคา</option>
                      <option value="<% price %>" ng-repeat="price in search_price"><% price %></option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary btn-block" ng-click="topupAutoOperator()" ng-disabled="!autoOperatorReady">เติมเงิน</button>
                  </div>
                </div>


              </div>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

          <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">AIS</h3>
              </div>
              <div class="box-body">
                <center><img src="/logo/ais_logo.jpg" width="200" height="80"></center>
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร" ng-model="m_12call_number">
                <br>
                <select class="form-control" ng-model="m_12call_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="<% price %>" ng-repeat="price in mtopup_price['12CALL']"><% price %></option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill('12CALL',m_12call_number,m_12call_cash,users)" ng-disabled="topupButtonDisabled['12CALL']">เติมเงิน</button>
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
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร" ng-model="m_happy_number">
                <br>
                <select class="form-control" ng-model="m_happy_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="<% price %>" ng-repeat="price in mtopup_price['HAPPY']"><% price %></option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill('HAPPY',m_happy_number,m_happy_cash,users)" ng-disabled="topupButtonDisabled['HAPPY']">เติมเงิน</button>
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
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร" ng-model="m_trmv_number">
                <br>
                <select class="form-control" ng-model="m_trmv_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="<% price %>" ng-repeat="price in mtopup_price['TRMV']"><% price %></option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill('TRMV',m_trmv_number,m_trmv_cash,users)" ng-disabled="topupButtonDisabled['TRMV']">เติมเงิน</button>
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
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร (ไม่สามารถดึงเงินคืนได้)" ng-model="m_my_number">
                <br>
                <select class="form-control" ng-model="m_my_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="<% price %>" ng-repeat="price in mtopup_price['MY']"><% price %></option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill('MY',m_my_number,m_my_cash,users)" ng-disabled="topupButtonDisabled['MY']">เติมเงิน</button>
              </div>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

          <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">TOT3G</h3>
              </div>
              <div class="box-body">
                <center><img src="/logo/tot3g_logo.jpg" width="200" height="80"></center>
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร (ไม่สามารถดึงเงินคืนได้)" ng-model="m_tot_number">
                <br>
                <select class="form-control" ng-model="m_tot_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="<% price %>" ng-repeat="price in mtopup_price['TOT']"><% price %></option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill('TOT',m_tot_number,m_tot_cash,users)" ng-disabled="topupButtonDisabled['TOT']">เติมเงิน</button>
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
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร (ไม่สามารถดึงเงินคืนได้)" ng-model="m_penguin_number">
                <br>
                <select class="form-control" ng-model="m_penguin_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="<% price %>" ng-repeat="price in mtopup_price['PENGUIN']"><% price %></option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill('PENGUIN',m_penguin_number,m_penguin_cash,users)" ng-disabled="topupButtonDisabled['PENGUIN']">เติมเงิน</button>
              </div>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

          <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">168</h3>
              </div>
              <div class="box-body">
                <center><img src="/logo/168_logo.jpg" width="200" height="80"></center>
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร (ไม่สามารถดึงเงินคืนได้)" ng-model="m_168_number">
                <br>
                <select class="form-control" ng-model="m_168_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="<% price %>" ng-repeat="price in mtopup_price['168']"><% price %></option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill('168',m_168_number,m_168_cash,users)" ng-disabled="topupButtonDisabled['168']">เติมเงิน</button>
              </div>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

          <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">Buzzme</h3>
              </div>
              <div class="box-body">
                <center><img src="/logo/buzzme_logo.jpg" width="200" height="80"></center>
                <input class="form-control input-lg" type="text" placeholder="เบอร์โทร (ไม่สามารถดึงเงินคืนได้)" ng-model="m_buzzme_number">
                <br>
                <select class="form-control" ng-model="m_buzzme_cash">
                  <option value="">คลิกเลือกราคา</option>
                  <option value="<% price %>" ng-repeat="price in mtopup_price['BUZZME']"><% price %></option>
                </select>
                <br>
                <button type="button" class="btn btn-default btn-block" ng-click="topupRefill('BUZZME',m_buzzme_number,m_buzzme_cash,users)" ng-disabled="topupButtonDisabled['BUZZME']">เติมเงิน</button>
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
                <th>ยอดดึงคืน</th>
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
                <td><% data.drawn_amount %><button class='btn btn-xs btn-default' ng-if="data.drawn_amount == null && data.status == 2">ดึงคืน</button></td>
                <td>
                  <span class="label label-warning show_tooltip" ng-if="data.status == 1" data-toggle="tooltip" title="<% data.sms == 'null' ? '':data.sms %>"><% status_name[data.status] %></span>
                  <span class="label label-success show_tooltip" ng-if="data.status == 2" data-toggle="tooltip" title="<% data.sms == 'null' ? '':data.sms %>"><% status_name[data.status] %></span>
                  <span class="label label-danger show_tooltip" ng-if="data.status == 4" data-toggle="tooltip" title="<% data.sms == 'null' ? '':data.sms %>"><% status_name[data.status] %></span>
                  <span class="label label-warning show_tooltip" ng-if="data.status == 5" data-toggle="tooltip" title="<% data.sms == 'null' ? '':data.sms %>"><% status_name[data.status] %></span>
                  <span class="label" style="background-color:#828282" ng-if="data.status == 6" data-toggle="tooltip" title="<% data.sms == 'null' ? '':data.sms %>"><% status_name[data.status] %></span></td>
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

  <div class="modal fade" id="modal-topup-report">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-fw fa-list"></i> สรุปเติมเงิน (รายวัน)</h4>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-6">
              <table class="table table-hover">
                <tbody>
                <tr>
                  <th colspan="2" class="text-center" bgcolor="#d0d0d0">สรุปยอดรวม</th>
                </tr>
                <tr>
                  <th>สาขา</th>
                  <th>ยอดรวม</th>
                </tr>
                <tr ng-if="todayReportTotal.length == 0">
                  <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                </tr>
                <tr ng-repeat="data in todayReportTotal">
                  <td><% data.branch_name %></td>
                  <td><% data.sum %></td>
                </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table table-hover">
                <tbody>
                <tr>
                  <th colspan="3" class="text-center" bgcolor="#d0d0d0">สรุปยอดรวมตามเครือข่าย</th>
                </tr>
                <tr>
                  <th>สาขา</th>
                  <th>เครือข่าย</th>
                  <th>ยอดเงิน</th>

                </tr>
                <tr ng-if="todayReport.length == 0">
                  <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                </tr>
                <tr ng-repeat="data in todayReport">
                  <td><% data.branch_name %></td>
                  <td><% data.network %></td>
                  <td><% data.sum %></td>
                </tr>
                </tbody>
              </table>
            </div>


          </div>

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

  <div class="modal fade" id="modal-topup-report-all">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-fw fa-list"></i> สรุปเติมเงิน</h4>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-6">
              <table class="table table-hover">
                <tbody>
                <tr>
                  <th colspan="2" class="text-center" bgcolor="#d0d0d0">สรุปยอดเติมเงินเดือนนี้</th>
                </tr>
                <tr>
                  <th>สาขา</th>
                  <th>ยอดรวม</th>
                </tr>
                <tr ng-if="monthlyReportTotal.length == 0">
                  <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                </tr>
                <tr ng-repeat="data in monthlyReportTotal">
                  <td><% data.branch_name %></td>
                  <td><% data.sum %></td>
                </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table table-hover">
                <tbody>
                <tr>
                  <th colspan="3" class="text-center" bgcolor="#d0d0d0">สรุปยอดเติมเงินเดือนนี้ (แยกตามเครือข่าย)</th>
                </tr>
                <tr>
                  <th>สาขา</th>
                  <th>เครือข่าย</th>
                  <th>ยอดเงิน</th>

                </tr>
                <tr ng-if="monthlyReport.length == 0">
                  <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                </tr>
                <tr ng-repeat="data in monthlyReport">
                  <td><% data.branch_name %></td>
                  <td><% data.network %></td>
                  <td><% data.sum %></td>
                </tr>
                </tbody>
              </table>
            </div>


          </div>

          <div class="row">
            <div class="col-md-6">
              <table class="table table-hover">
                <tbody>
                <tr>
                  <th colspan="2" class="text-center" bgcolor="#d0d0d0">สรุปยอดตั้งแต่เริ่มต้น</th>
                </tr>
                <tr>
                  <th>สาขา</th>
                  <th>ยอดรวม</th>
                </tr>
                <tr ng-if="entireReportTotal.length == 0">
                  <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                </tr>
                <tr ng-repeat="data in entireReportTotal">
                  <td><% data.branch_name %></td>
                  <td><% data.sum %></td>
                </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table table-hover">
                <tbody>
                <tr>
                  <th colspan="3" class="text-center" bgcolor="#d0d0d0">สรุปยอดตั้งแต่เริ่มต้น (แยกตามเครือข่าย)</th>
                </tr>
                <tr>
                  <th>สาขา</th>
                  <th>เครือข่าย</th>
                  <th>ยอดเงิน</th>

                </tr>
                <tr ng-if="entireReport.length == 0">
                  <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                </tr>
                <tr ng-repeat="data in entireReport">
                  <td><% data.branch_name %></td>
                  <td><% data.network %></td>
                  <td><% data.sum %></td>
                </tr>
                </tbody>
              </table>
            </div>


          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-block" data-dismiss="modal">ปิด</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
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

<script src="/plugins/toastjs/toastr.min.js"></script>

<script>

    base_url = '{{URL::to('/')}}';
    branch_name = '{{Auth::user()->branch_name}}';
    tData = '{{Auth::user()->api_token}}';
</script>
</body>
</html>
