
var origin = document.location.origin;
var folder = document.location.pathname.split('/')[1];

var path = origin + "/" + folder + "/web/bundles/bloggerblog/js/";

var blogApp = angular.module('blog',['ngRoute']);

blogApp.config(['$routeProvider', function ($routeProvider) {
    $routeProvider.
        when('/', {
            templateUrl: path+ 'index.html.twig',
            controller: 'IndexAction'
        }).
        when('/contact', {
            templateUrl: path+ 'contact.html.twig',
            controller: 'ContactActions'
        }).
        when('/about', {
            templateUrl: path+ 'about.html.twig',
            controller: 'ContactActions'
        }).
        otherwise({
            redirectTo: '/'
        });
}]);