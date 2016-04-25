
var blogApp = angular.module('blog',[]);

var urlBase = "http://blog.dev/app_dev.php";

var emailJson = {
    "senderName": "default",
    "senderEmail": "default",
    "content": "default"
};
blogApp.controller('ContactAction',function($scope, $http) {
    $scope.sendEmail = function(data) {
        $scope.messageSending="Please wait, message is sending...";
        $http.post(urlBase + '/cont', data).success(function(data) {
                $scope.message.senderName="";
                $scope.message.senderEmail="";
                $scope.message.content="";

                $scope.messageSending="";
            }
        ).error(function(){
                $scope.messageSending="Something was wrong. Probably email inputted by you doesn't exist.";

            });
    }
});