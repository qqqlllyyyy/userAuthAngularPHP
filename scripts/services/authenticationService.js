app.service('AuthenticationService', ["$http", "$state", function($http, $state) {

  var vm = this;




  //--------------------------------------------------------------------------------------
  // Check Token Function
  //--------------------------------------------------------------------------------------

  vm.checkToken = function(token) {
    var data = {
      token: token
    };

    $http
      .post('backend/userAuthExe.php?action=checkToken', data)
      .success(function(response) {
        console.log(response);
        if (response == 'unauthorized') {
          $state.go("login");
        } else {
          return response;
        }
      })
      .error(function(error) {
        console.log(error);
        $state.go("login");
      });
  }

}]);
