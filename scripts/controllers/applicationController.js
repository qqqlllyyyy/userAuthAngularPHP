app.controller("ApplicationController", function($scope, $state){

  // If not logged in
  if (localStorage['user'] === undefined) {
    $state.go("login");
  }

});
