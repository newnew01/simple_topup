var app = angular.module('topupApp', ['ngSanitize'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});



app.controller('topupController', function($scope,$http) {

    $scope.username = 'bmV3bmV3MDE=';
    $scope.password = 'bmV3a2h1bmcwMQ=='
    $scope.users = branch_name;
    $scope.balance = '<img src="/image/loading.gif" class="loading_balance">';
    $scope.orderid = '';
    $scope.content_topup_status = "<img class='status_icon' src='/image/loading.gif'><h3>กำลังทำรายการ...</h3>";

    $scope.timerCheckStatus = null;


    $scope.reloadBalance = function () {
        $http.post("http://topup.newphone-function.trade/api/balance",{'username':Encryption.decode($scope.username),'password':Encryption.decode($scope.password)})
            .then(function(response) {
                //alert(response.data.AMOUNT);
                $scope.balance = response.data.AMOUNT;
            });
    }

    $scope.testfunc = function () {
        alert(123);
    }

    $scope.topupRefill = function (network,number,cash,users) {
        var data = {
            'username':Encryption.decode($scope.username),
            'password':Encryption.decode($scope.password),
            'network':network,
            'number':number,
            'cash':cash,
            'users':users
        };

        $scope.showStatusLoading();
        //alert(network+'|'+number+'|'+cash+'|'+users);
        $('#modal-topup-status').modal('show');
       // alert();
        //$scope.showStatusSuccess('ทำรายการสำเร็จ');
       // alert();
        //$scope.showStatusError('ผิดพลาด');

        //setInterval($scope.testfunc, 3000);


        $http.post("http://topup.newphone-function.trade/api/topup_refill",data)
            .then(function(response) {
                //alert(response.data.AMOUNT);
                $('#modal-topup-status').modal('show');
                if(response.data.STATUS != 1){
                    $scope.showStatusError(response.data.DETAIL);
                }else{
                    $scope.orderid = response.data.ORDERID;
                    $scope.timerCheckStatus = setInterval($scope.checkTopupStatus, 5000);
                }
            });

    }

    $scope.checkTopupStatus = function () {
        var data = {
            'username':Encryption.decode($scope.username),
            'password':Encryption.decode($scope.password),
            'orderid':$scope.orderid
        };
        $http.post("http://topup.newphone-function.trade/api/topup_status",data)
            .then(function(response) {
                if(response.data.STATUS == 1){
                    if(response.data.STATUS_REFILL == 1){
                        $scope.showStatusSuccess('การทำรายการสำเร็จ');
                        clearInterval($scope.timerCheckStatus);
                        $scope.clearData();
                        $scope.orderid = '';
                        $scope.reloadBalance();
                    }

                    if(response.data.STATUS_CANCEL == 1){
                        $scope.showStatusError('ผิดพลาด: กรุณาตรวจสอบเครือข่ายมือถือของท่าน')
                        clearInterval($scope.timerCheckStatus);
                        $scope.clearData();
                        $scope.orderid = '';
                        $scope.reloadBalance();
                    }
                }else {
                    $scope.showStatusError(response.data.DETAIL)
                    clearInterval($scope.timerCheckStatus);
                    $scope.clearData();
                    $scope.orderid = '';
                    $scope.reloadBalance();
                }

            });
    }

    $scope.showStatusSuccess = function (msg) {
        $scope.content_topup_status = "<img src='/image/success.png' class='status_icon'><h3 class='status_msg_success'>"+msg+"</h3>";
    }

    $scope.showStatusError = function (msg) {
        $scope.content_topup_status = "<img src='/image/error.png' class='status_icon'><h3 class='status_msg_error'>"+msg+"</h3>";
    }

    $scope.showStatusLoading = function () {
        $scope.content_topup_status = "<img src='/image/loading.gif' class='status_icon'><h3>กำลังทำรายการ...</h3>";
    }

    $scope.clearData = function () {
        $scope.ais_number = '';
        $scope.dtac_number = '';
        $scope.true_number = '';
        $scope.my_number = '';
        $scope.imobile_number = '';
        $scope.pengoin_number = '';
    }




    $scope.reloadBalance();
});