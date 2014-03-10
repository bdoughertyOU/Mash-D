var app = angular.module("app", ['ui.router']).config(function( $stateProvider, $urlRouterProvider){
  $stateProvider
    .state("myaccount", {
      url: "/myaccount",
      templateUrl: "myaccount.html",
      controller: "MyAccountController",
      authenticate: false
    })
    .state("login", {
      url: "/login",
      templateUrl: "login.html",
      controller: "LoginController",
      authenticate: false
    })
    .state("social", {
      url: "/social",
      templateUrl: "social.php",
      controller: "SocialController",
      authenticate: false
    });
  // Send to login if the URL was not found
 $urlRouterProvider.otherwise("/login");
});

app.controller('LoginController', function($scope, $location, MashdLogin) {
	$scope.credentials = { username: "", password: ""};

	$scope.login = function(){
		MashdLogin.login($scope.credentials).success(function(response){
			if(response == '1'){
				$location.path('/myaccount');
			}else{
				$location.path('/login');
			}
		});
	}
});

app.controller('MyAccountController', function($http) {
	$http.get('social_accounts_include.php').success(function(result){
				$('.brandon').html(result);
	});
});

app.controller('SocialController', function($scope, $location) {
       
});

app.factory('MashdLogin', function($http, $location){
	return{
		login: function(credentials){
			return $http({
					    method: 'POST',
					    url: 'login.php',
					    data: credentials,
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		logout: function(){
			return $http.get('logout.php');
		},
		isLoggedIn: function(){

		}
	};
});

/*app.controller('MyAccountController', function($scope){
	$scope.$watch( AuthService.isLoggedIn, function (isLoggedIn) {
    	$scope.isLoggedIn = isLoggedIn;
	});
});*/

app.directive('design', function (){
	return{
		restrict: "C",
		link: function(scope,element,attributes){
			$(function(){
    			$(document).foundation();    
  			});
			
			$(document).on('click', '.loadmorefeed', function() {
		    $.ajax({url:"vinelibs/vineajax.php",success:function(result){
		      $("#myDiv").html(result);
		      var elem = document.getElementById('ajaxbutton1');
		    elem.parentNode.removeChild(elem);
		    }});
		  });

			$(document).on('click', '.loadMoreFeed', function() {
			    pageNum = parseFloat($('.myDiv').last().attr('data'));
			    newPageNum = pageNum + 1;
			    $.ajax({url:"instagramlibs/instagram_load_more_feed_ajax.php",success:function(result){
			      $('div.myDiv[data="' + pageNum + '"]').after("<div class='myDiv' data='" + newPageNum + "'>&nbsp</div>");
			      $('div.myDiv[data="' + newPageNum + '"]').html(result);
			    }});
			  });

			$(document).on('click', '.instaComments', function() {
			    var currentDiv, pageValue, newPage, newPageid;
			    currentDiv = $(this).attr('group');
			    pageValue = parseFloat($(this).attr('data'));
			    newPage = pageValue + 5 ;
			    newPageid =  '.' + pageValue;
			    $.ajax({url:"instagramlibs/instagramcommentsajax.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: currentDiv,
			                  page: pageValue},
			        success:function(result){
			          $('div[group="' + currentDiv + '"] .commentsContainer > div:first-child').before("<div class='" + pageValue + "'>&nbsp</div>");
			       $('div[group="' + currentDiv + '"] ' + newPageid).html(result);
			       $('button[group="' + currentDiv + '"]').attr('data', newPage);
			       $('button[group="' + currentDiv + '"]').off();
			    }});
			});

			$(document).on('click', '.ajaxcommentbutton1', function() {
			    var currentDiv, pageValue, newPage, newPageid;
			    currentDiv = $(this).attr('group');
			    pageValue = parseFloat($(this).attr('data'));
			    newPage = pageValue + 1;
			    newPageid =  '.' + newPage;
			    $.ajax({url:"vinelibs/vinecommentsajax.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: currentDiv,
			                  page: newPage},
			        success:function(result){
			          $('div[data="' + currentDiv + '"] .commentsContainer > div:first-child').before("<div class='" + newPage + "'>&nbsp</div>");
			       $('div[data="' + currentDiv + '"] ' + newPageid).html(result);
			       $('button[group="' + currentDiv + '"]').attr('data', newPage);
			       $('button[group="' + currentDiv + '"]').off();
			    }});
			});

			$(document).on('click', '.twitterComments', function() {
			    var currentDiv, pageValue, newPage, newPageid;
			    posterScreenName = $(this).attr('data');
			    postId = $(this).attr('data-id');
			    $.ajax({url:"twitterlibs/twittercommentsajax.php",
			           type:'POST',              
			       dataType:'text',
			           data: {poster: posterScreenName,
			                  post: postId},
			        success:function(result){
			          $('div[data-id="' + postId + '"] .twitterCommentContainer').html(result);
			          
			    }});
			});

			$(document).on('click', '.faceBookToggle', function() {
			    	$('.fbPost').parent().toggle();
			});
			$(document).on('click', '.twitterToggle', function() {
			    	$('.twitterPost').parent().toggle();
			});
			$(document).on('click', '.instaToggle', function() {
			    	$('.igPost').parent().toggle();
			});
			$(document).on('click', '.vineToggle', function() {
			    	$('.vinepost').parent().toggle();
			});

		}
	};
});

app.directive('myaccount', function(){
	return{
		restrict: "C",
		link: function(scope,element,attributes){

			    var footer = $(".secondNav");
			    var pos = footer.position();
			    var height = $(window).height();
			    height = height - pos.top;
			    height = height - footer.height();
	        	footer.css({
	            	'margin': height + 'px auto'
	        	});
    		
		}
	};
});
