var app = angular.module("UserAuth", ["ui.router"]);

app.config(function($stateProvider, $urlRouterProvider){

  $urlRouterProvider.otherwise('/');

  $stateProvider
    .state("login", {
      url:"/",
      controller: "LoginController",
      templateUrl: "views/login.html"
    })
    .state("application", {
      url: "/app",
      controller: "ApplicationController",
      templateUrl: "views/application.html"
    });

});
