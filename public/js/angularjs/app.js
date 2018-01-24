var app = angular.module('topupApp', ['ngSanitize'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});



app.controller('topupController', function($scope,$http) {

    $scope.url = base_url+'/api/';
    $scope.username = 'bmV3bmV3MDE=';
    $scope.password = 'bmV3a2h1bmcwMQ=='
    $scope.users = branch_name;
    $scope.api_token = tData;
    $scope.balance = '<img src="/image/loading.gif" class="loading_balance">';
    $scope.orderid = '';
    $scope.content_topup_status = "<img class='status_icon' src='/image/loading.gif'><h3>กำลังทำรายการ...</h3>";

    $scope.timerCheckStatus = null;

    $scope.topup_histories = [];

    $scope.todayReport = [];
    $scope.todayReportTotal = [];
    $scope.monthlyReport = [];
    $scope.monthlyReportTotal = [];
    $scope.entireReport = [];
    $scope.entireReportTotal = [];

    $scope.search_logo = '/logo/search_logo.jpg';
    $scope.search_price = [];
    $scope.autoOperator = '';
    $scope.autoOperatorReady = false;

    $scope.mtopup_price = [];
    $scope.mtopup_price['12CALL'] = [10,20,30,40,50,60,70,80,90,100,150,200,250,300,350,400,450,500,600,700,800,1000,1500];
    $scope.mtopup_price['HAPPY'] = [10,20,30,40,50,60,100,200,300,500,800];
    $scope.mtopup_price['TRMV'] = [10,20,30,40,50,60,70,80,90,100,150,200,250,300,350,400,450,500,600,700,800,900,1000];
    $scope.mtopup_price['MY'] = [10,20,50,100,300,500];
    $scope.mtopup_price['PENGUIN'] = [10,20,30,40,50,100,200,300,500];
    $scope.mtopup_price['TOT'] = [20,50,100,200,300];
    $scope.mtopup_price['168'] = [10,20,50,100,200,300,500];
    $scope.mtopup_price['BUZZME'] = [50,100,200,300,500,1000,1200];

    $scope.network_name = {'12CALL':'AIS', 'HAPPY':'DTAC', 'TRMV':'TRUE', 'MY':'MY', 'PENGUIN':'PENGUIN', 'TOT':'TOT3G', '168':'168', 'BUZZME':'BUZZME'};
    $scope.status_name = ['NO_DATA0','กำลังดำเนินการ','สำเร็จ','NO_DATA3','ไม่สำเร็จ','กำลังดึงเงินคืน','ดึงเงินคืนสำเร็จ'];

    $scope.topupButtonDisabled = [];
    $scope.topupButtonDisabled['12CALL'] = false;
    $scope.topupButtonDisabled['HAPPY'] = false;
    $scope.topupButtonDisabled['TRMV'] = false;
    $scope.topupButtonDisabled['MY'] = false;
    $scope.topupButtonDisabled['PENGUIN'] = false;
    $scope.topupButtonDisabled['TOT'] = false;
    $scope.topupButtonDisabled['168'] = false;
    $scope.topupButtonDisabled['BUZZME'] = false;

    $scope.m_12call_number = '';
    $scope.m_happy_number = '';
    $scope.m_trmv_number = '';
    $scope.m_my_number = '';
    $scope.m_penguin_number = '';
    $scope.m_tot_number = '';
    $scope.m_168_number = '';
    $scope.m_buzzme_number = '';

    $scope.toastOption = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-left",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "0",
        "extendedTimeOut": "0",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    $scope.processQueue = [];




    $scope.getOperator = function () {
        if($scope.number_search.length == 10){
            var tmp_number = $scope.number_search;
            //tmp_number = $scope.number_search;
            $scope.search_logo = '/logo/loading.gif';
            $http.post($scope.url +'wepay/get-operator',{'number':tmp_number,'api_token':$scope.api_token})
                .then(function(response) {
                    operator = response.data;

                    //alert(tmp_number+'/'+$scope.number_search+'\nnetwork:'+operator);
                    //alert(operator)
                    if(tmp_number == $scope.number_search){
                        if(!operator || 0 === operator.length || operator == "error")
                        {
                            alert('ผิดพลาด! ไม่สามารถตรวจสอบได้ในขณะนี้หรือไม่สามารถระบุเครือข่ายได้');
                            $scope.search_logo = '/logo/search_logo.jpg';
                            $scope.search_price = [];
                            $scope.autoOperatorReady = false;
                            $scope.number_search = "";
                            $scope.autoOperator = '';
                        }
                        else if(operator == "ais")
                        {
                            $scope.search_logo = '/logo/ais_logo.jpg';
                            $scope.search_price = $scope.mtopup_price['12CALL'];
                            $scope.autoOperatorReady = true;
                            $scope.autoOperator = '12CALL';
                        }
                        else if(operator == "dtac")
                        {
                            $scope.search_logo = '/logo/dtac_logo.jpg';
                            $scope.search_price = $scope.mtopup_price['HAPPY'];
                            $scope.autoOperatorReady = true;
                            $scope.autoOperator = 'HAPPY';
                        }
                        else if(operator == "truemove")
                        {
                            $scope.search_logo = '/logo/true_h_logo.jpg';
                            $scope.search_price = $scope.mtopup_price['TRMV'];
                            $scope.autoOperatorReady = true;
                            $scope.autoOperator = 'TRMV';
                        }

                        else if(operator == "my")
                        {
                            $scope.search_logo = '/logo/my.jpg';
                            $scope.search_price = $scope.mtopup_price['MY'];
                            $scope.autoOperatorReady = true;
                            $scope.autoOperator = 'MY';
                        }
                        else if(operator == "penguin")
                        {
                            $scope.search_logo = '/logo/penguinsim.jpg';
                            $scope.search_price = $scope.mtopup_price['PENGUIN'];
                            $scope.autoOperatorReady = true;
                            $scope.autoOperator = 'PENGUIN';
                        }
                        else if(operator == "tot3g")
                        {
                            $scope.search_logo = '/logo/tot3g_logo.jpg';
                            $scope.search_price = $scope.mtopup_price['TOT'];
                            $scope.autoOperatorReady = true;
                            $scope.autoOperator = 'TOT';
                        }
                        else if(operator == "unknown"){
                            $scope.search_logo = '/logo/search_logo.jpg';
                            $scope.search_price = [];
                            $scope.autoOperatorReady = false;
                            alert('ผิดพลาด! ไม่สามารถระบุเครือข่ายได้');
                            $scope.number_search = "";
                            $scope.autoOperator = '';
                        }
                    }



                });
        }else{
            $scope.search_logo = '/logo/search_logo.jpg';
            $scope.search_price = [];
            $scope.autoOperatorReady = false;
            $scope.autoOperator = '';
        }
    }

    $scope.topupAutoOperator = function () {
        //alert('number:'+$scope.number_search+'\ncash:'+$scope.auto_operator_cash+'\nnetwork:'+$scope.autoOperator);
        $scope.topupRefill($scope.autoOperator,$scope.number_search,$scope.auto_operator_cash,$scope.users);
        $scope.search_logo = '/logo/search_logo.jpg';
        $scope.search_price = [];
        $scope.autoOperatorReady = false;
        $scope.autoOperator = '';
        $scope.number_search = '';
    }

    $scope.setOperator = function (number) {

    }

    $scope.test_click = function () {
        alert();
    }


    $scope.reloadBalance = function () {
        $http.post($scope.url + "wepay/balance",{'api_token':$scope.api_token})
            .then(function(response) {
                //alert(response.data.AMOUNT);
                if(response.data.code == '00000')
                    $scope.balance = response.data.available_balance;
            });
    }

    $scope.testfunc = function () {
        alert(123);
    }

    $scope.setStatusSuccess = function (transaction_id) {
        toastr.clear($scope.processQueue[transaction_id].toast_obj);
        clearInterval($scope.processQueue[transaction_id].interval_obj);
    }

    $scope.disableButton = function (network_code) {
        $scope.topupButtonDisabled[network_code] = true;
    }

    $scope.enableButton = function (network_code) {
        $scope.topupButtonDisabled[network_code] = false;
    }


    $scope.clearFormInput = function (network_code) {
        if(network_code == "12CALL"){
            $scope.m_12call_number = '';
            $scope.m_12call_cash = '';
        }else if(network_code == "HAPPY"){
            $scope.m_happy_number = '';
            $scope.m_happy_cash = '';

        }else if(network_code == "TRMV"){
            $scope.m_trmv_number = '';
            $scope.m_trmv_cash = '';

        }else if(network_code == "MY"){
            $scope.m_my_number = '';
            $scope.m_my_cash = '';

        }else if(network_code == "TOT"){
            $scope.m_tot_number = '';
            $scope.m_tot_cash = '';

        }else if(network_code == "PENGUIN"){
            $scope.m_penguin_number = '';
            $scope.m_penguin_cash = '';

        }else if(network_code == "168"){
            $scope.m_168_number = '';
            $scope.m_168_cash = '';

        }else if(network_code == "BUZZME"){
            $scope.m_buzzme_number = '';
            $scope.m_buzzme_cash = '';
        }
    }

    $scope.topupRefill = function (network_code,number,cash,users) {
        var network_name = $scope.network_name[network_code];




        if(number.length == 10 && cash > 0){
            data = {
                'number':number,
                'cash':cash,
                'network_code':network_code,
                'network':network_name,
                'users':users,
                'api_token':$scope.api_token
            };
            //disable loading button...
            $scope.disableButton(network_code);

            $http.post($scope.url +'wepay/topup',data).then(function (response) {
                //enable loading buttton
                $scope.enableButton(network_code);
                //clear form input
                $scope.clearFormInput(network_code);
                if(response.data.code == '00000'){
                    var toast_obj = toastr["info"]('เติมเงิน: '+number+' ['+cash+' บาท]<br>เครือข่าย: '+network_name,"<img src='/image/loading2.gif' height='15px'>  กำลังทำรายการ.......",$scope.toastOption);
                    var transaction_id = response.data.transaction_id;

                    var interval_obj = setInterval( function() {
                        //alert('number:'+number+'\ncash:'+cash+'\nnetwork:'+network_name);

                        $http.post($scope.url +'wepay/topup-status',{'transaction_id':transaction_id,'api_token':$scope.api_token}).then(function (response2) {
                            if(response2.data.status == '2'){
                                //success
                                toastr.clear($scope.processQueue[transaction_id].toast_obj);
                                clearInterval($scope.processQueue[transaction_id].interval_obj);
                                toastr["success"]('เติมเงิน: '+number+' ['+cash+' บาท]<br>เครือข่าย: '+network_name,"สำเร็จ",$scope.toastOption);
                                $scope.reloadBalance();
                            }else if(response2.data.status == '4'){
                                //error network not match the number, refund
                                toastr.clear($scope.processQueue[transaction_id].toast_obj);
                                clearInterval($scope.processQueue[transaction_id].interval_obj);
                                toastr["error"]('เติมเงิน: '+number+' ['+cash+' บาท]<br>เครือข่าย: '+network_name+'<br>เหตุผล: '+response2.data.sms,"ไม่สำเร็จ",$scope.toastOption);
                                $scope.reloadBalance();
                            }else if(response2.data.status == '1'){
                                //processing, nothing to do
                            }else{
                                //unknow error
                                toastr.clear($scope.processQueue[transaction_id].toast_obj);
                                clearInterval($scope.processQueue[transaction_id].interval_obj);
                                toastr["error"]('เติมเงิน: '+number+' ['+cash+' บาท]<br>เครือข่าย: '+network_name+'<br>เหตุผล: UNKNOW  ERROR',"ไม่สำเร็จ",$scope.toastOption);
                                $scope.reloadBalance();
                            }
                        });

                    }, 3000 );

                    $scope.processQueue[transaction_id] = {'toast_obj':toast_obj,'interval_obj':interval_obj};
                }else {
                    toastr["error"]('code: '+response.data.code+'<br>เหตุผล: '+response.data.desc,"ผิดพลาด",$scope.toastOption);
                }
            });



        }else{
            alert("ผิดพลาด! เบอร์โทรหรือราคาไม่ถูกต้อง");
        }




    }



    $scope.showTopupHistory = function () {
        $http.post("/api/log/today",{'api_token':$scope.api_token})
            .then(function(response) {
                //alert(response.data.AMOUNT);

                $scope.topup_histories = response.data;
                $('#modal-topup-history').modal('show');
                setTimeout(function () {
                    $('.show_tooltip').tooltip();
                },500)
            });

    }

    $scope.getTodayReport = function () {
        $http.post("/api/log/today/report",{'api_token':$scope.api_token})
            .then(function(response) {
                //alert(response.data.AMOUNT);
                $scope.todayReport = response.data;

                $http.post("/api/log/today/report-total",{'api_token':$scope.api_token})
                    .then(function(response) {
                        //alert(response.data.AMOUNT);
                        $scope.todayReportTotal = response.data;


                        $('#modal-topup-report').modal('show');
                    });
            });
    }

    $scope.getAllReport = function () {
        $http.post("/api/log/monthly/report",{'api_token':$scope.api_token})
            .then(function(response) {
                //alert(response.data.AMOUNT);
                $scope.monthlyReport = response.data;
            });
        $http.post("/api/log/monthly/report-total",{'api_token':$scope.api_token})
            .then(function(response) {
                //alert(response.data.AMOUNT);
                $scope.monthlyReportTotal = response.data;
            });
        $http.post("/api/log/entire/report",{'api_token':$scope.api_token})
            .then(function(response) {
                //alert(response.data.AMOUNT);
                $scope.entireReport = response.data;
            });
        $http.post("/api/log/entire/report-total",{'api_token':$scope.api_token})
            .then(function(response) {
                //alert(response.data.AMOUNT);
                $scope.entireReportTotal = response.data;
            });


        $('#modal-topup-report-all').modal('show');
    }





    $scope.reloadBalance();
});