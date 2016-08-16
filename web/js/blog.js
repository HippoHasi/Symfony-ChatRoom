angular.module('Blog', [])
.controller('BlogCtrl', ['$scope','$http','$httpParamSerializer', '$log', function ($scope, $http, $httpParamSerializer, $log) {
	$scope.pass_username = function(name, page){	
		$scope.blogs = [];		
		$http.get('http://localhost/app_dev.php/getBlog/'+name+'/'+page)
			.then(function(response){
				$scope.blogs = response.data;	
			}, function(response){
				$scope.blogs = response.data || "Request failed";
				is_processing = false;
			});

	}

	$scope.myVar = false;
	$scope.hideBut = false;
    $scope.displayForm = function(blogId) {
    	$scope.blogId = blogId;
        $scope.myVar = true;  
        $scope.hideBut = true; 
    }
	$scope.hideButton = function(blogId){
		return $scope.blogId === blogId && $scope.hideBut;
	}
    $scope.isSelected = function(blogId){
		return $scope.blogId === blogId && $scope.myVar;
	}

	$scope.reply = {};	
	$scope.sendReply = function(blogId){
		$scope.reply.blog = blogId;
		
		$http({
		    method: 'POST',
		    url: 'http://localhost/app_dev.php/blogReply',
		    data: $.param($scope.reply),
		    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		    //transformRequest: $httpParamSerializer,		    		    
		})
		//$http.post('http://localhost/app_dev.php/blogReply', $.param($scope.reply), {'Content-Type': 'application/x-www-form-urlencoded'})
		.then(function success(response){
			$scope.message = response;
			
		}, function error(response){
			$scope.message = response.status;
			//$log.info(reason);
		});
		
	}
    

}]); 