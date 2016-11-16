app.controller("ApplicationController", function($scope, $state, $http, AuthenticationService){

  var token;
  if (localStorage['token']) {
    token = JSON.parse(localStorage['token']);
  } else {
    token = 'No Token';
  }

  // If not logged in
  AuthenticationService.checkToken(token);



  //--------------------------------------------------------------------------------------
  // Logout Function
  //--------------------------------------------------------------------------------------

  $scope.logout = function() {
    var data = {
      token: token
    };

    $http
      .post('backend/userAuthExe.php?action=logout', data)
      .success(function(response) {
        console.log(response);
        localStorage.clear();
        $state.go("login");
      })
      .error(function(error) {
        console.log(error);
      });
  }

});
