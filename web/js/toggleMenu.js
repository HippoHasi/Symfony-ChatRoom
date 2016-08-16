var app = angular.module('ToggleMenu', [])
    app.controller('ToggleMenuController', function ($scope) {
        $scope.isVisible = false;          
        $scope.Toggle = function (tab) {
            $scope.tab = tab;
            $scope.isVisible = $scope.isVisible ? false : true;
        }
        $scope.isSelected = function(tab){
		return $scope.tab === tab && $scope.isVisible;
		};

    });