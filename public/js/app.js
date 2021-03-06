(function() {
  'use strict';

  var app = angular.module('myApp', ['ngMaterial', 'ngAnimate', 'ngRoute', 'ngSanitize', 'dndLists', 'pascalprecht.translate']);
  // Theaming and colors
  app.config(function($mdThemingProvider) {
    // Extend the red theme with a few different colors
    var neonRedMap = $mdThemingProvider.extendPalette('red', {
      '500': '#db4c3f'
    });
    // Register the new color palette map with the name <code>neonRed</code>
    $mdThemingProvider.definePalette('neonRed', neonRedMap);

    // Use that theme for the primary intentions
    $mdThemingProvider.theme('default')
    .primaryPalette('neonRed')
  });

  // Handle the routing
  app.config(function($routeProvider, $locationProvider){
    $routeProvider.when('/login',{
      templateUrl:'js/templates/login.html',
      controller:'LoginController as login'
    });

    $routeProvider.when('/register',{
      templateUrl:'js/templates/register.html',
      controller:'RegisterController as register'
    });

    $routeProvider.when('/home',{
      templateUrl:'js/templates/home.html',
      //controller:'PlayController as play'
    });

    $routeProvider.when('/domains',{
      templateUrl:'js/templates/domains.html',
      controller:'DomainsController as domains'
    });

    $routeProvider.when('/profiles',{
      templateUrl:'js/templates/profiles.html',
      controller:'ProfilesController as profiles'
    });

    $routeProvider.when('/play',{
      templateUrl:'js/templates/play.html',
      controller:'PlayController as play'
    });

    $routeProvider.when('/score',{
      templateUrl:'js/templates/score.html',
      controller:'ScoreController as score'
    });

    $routeProvider.when('/matches',{
      templateUrl:'js/templates/matches.html',
      controller:'MatchesController as matches'
    });

    $routeProvider.otherwise({ redirectTo: '/home' });
  });

  app.config(function($httpProvider) {
    var logsOutUserOn401 = function($location, $q, SessionService, FlashService) {
      var sucess = function() {
        return response;
      };
      var error = function() {
        if(response.status === 401) {
          SessionService.unset('authenticated');
          FlashService.show(response.data.flash);
          $location.path('/login');
          return $q.reject(response);
        } else {
          return $q.reject(response);
        }
      };

      return function(promise) {
        return promise.then(sucess, error);
      }
    }
  });

  // Handle translation
  app.config(function($translateProvider) {
    // Indicate how to find translation files
    $translateProvider.useStaticFilesLoader({
      prefix: 'js/languages/',
      suffix: '.json'
    });

    $translateProvider.registerAvailableLanguageKeys(['en', 'fr'], {
        'en-US': 'en',
        'en-UK': 'en',
        'fr-FR': 'fr',
    });

    $translateProvider.uniformLanguageTag('bcp47');
    $translateProvider.fallbackLanguage('en');
    $translateProvider.preferredLanguage('en');
  });

  // Handle Security
  app.run(function($route, $rootScope, $location, $mdDialog, $mdSidenav, AuthenticationService, FlashService, SessionService, PlayService, MatchService) {
    var routesThatDontRequireAuth = ['/home', '/login', '/register'];

    $rootScope.$on('$routeChangeStart', function(event, next, current) {
      $rootScope.getTotalScore();
      if($location.path() === "/login" && AuthenticationService.isLoggedIn()) {
        $location.path('/domains');
        return;
      }
      if($location.path() !== "" && !_(routesThatDontRequireAuth).contains($location.path()) && !AuthenticationService.isLoggedIn()) {
        $location.path('/login');
        return FlashService.show("Please log in to continue.");
      }
      FlashService.clear();
      FlashService.clearShow();
    });
    $rootScope.isLoggedIn = AuthenticationService.isLoggedIn;
    $rootScope.logout = function() {
      AuthenticationService.logout();
      $location.path('/login');
      //$route.reload();
    }

    $rootScope.goTo = function(page) {
      $location.path(page);
    }

    $rootScope.toggleSidenav = function(menuId) {
      $mdSidenav(menuId).toggle();
    };

    $rootScope.totalScore = 0;
    $rootScope.getTotalScore = function() {
      if(AuthenticationService.isLoggedIn()) {
        MatchService.getTotalScore().then(function(response) {
          $rootScope.totalScore = response.data;
        })
      }
    };
    $rootScope.getTotalScore();

    $rootScope.sideNav = {};
    $rootScope.sideNav.conceptSelected = function (concept) {
      if($location.path() == '/play') $route.reload();
      SessionService.set('concept.id', concept.id);
      $location.path('/play');
    };

    $rootScope.sideNav.score = function (concept) {
      SessionService.set('concept_score', concept.id);
      $location.path('/score');
      $route.reload();
    };

    $rootScope.showNotCompleted = function(ev) {
      $mdDialog.show(
        $mdDialog.alert()
          .parent(angular.element(document.querySelector('#content')))
          .clickOutsideToClose(true)
          .title('Oops!')
          .content("Cette fonctionnalité n'a pas encore été programmée dans la version 0.5.7 de ce jeu. Pour plus d'infos, suivez nous sur Github: <a href='https://github.com/hamhec/zagame'><md-button>Za Game Github</md-button></a>")
          .ariaLabel('Alert Dialog Problem')
          .ok('Ok')
          .targetEvent(ev)
      ).then(function() {
        $route.reload();
      });
    }
  });

})();
