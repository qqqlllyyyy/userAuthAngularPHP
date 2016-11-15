app.controller("LoginController", function($scope, $http, $state){

  // Variables
  $scope.signUpInfo = {
    username: undefined,
    password: undefined
  };

  $scope.loginInfo = {
    username: undefined,
    password: undefined
  };



  // Sign Up Function
  $scope.signUserUp = function() {
    var data = {
      username: $scope.signUpInfo.username,
      password: $scope.signUpInfo.password
    };
    // Ajax
    $http
      .post("backend/userAuthExe.php?action=signup", data)
      .success(function(response) {
        console.log(response);
        // Save to localstorage
        localStorage.setItem("user", JSON.stringify({user: response}));
        $state.go("application");
      })
      .error(function(error) {
        console.log(error);
      });
  };



  // Login function
  $scope.loginUser = function() {
    var data = {
      username: $scope.loginInfo.username,
      password: $scope.loginInfo.password
    };
    // Ajax
    $http
      .post("backend/userAuthExe.php?action=login", data)
      .success(function(response) {
        console.log(response);
        localStorage.setItem("user", JSON.stringify({user: response[0].Username}));
        $state.go("application");
      })
      .error(function(error) {
        console.log(error);
      });
  }

});
