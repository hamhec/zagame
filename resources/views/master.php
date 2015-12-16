<!doctype html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1" >
    <title>Za Game</title>
    <link rel="stylesheet" href="/css/style.css" >
    <link rel="stylesheet" href="/bower_components/angular-material/angular-material.css" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" >
  </head>

  <body ng-app="myApp" layout="row">
    <!-- Application Dependencies -->
    <script type="text/javascript" src="/bower_components/underscore/underscore-min.js"></script>
    <script type="text/javascript" src="/bower_components/angular/angular.js"></script>
    <script type="text/javascript" src="/bower_components/angular-sanitize/angular-sanitize.min.js"></script>
    <script type="text/javascript" src="/bower_components/angular-material/angular-material.js"></script>
    <script type="text/javascript" src="/bower_components/angular-animate/angular-animate.js"></script>
    <script type="text/javascript" src="/bower_components/angular-aria/angular-aria.js"></script>
    <script type="text/javascript" src="/bower_components/angular-route/angular-route.js"></script>
    <script type="text/javascript" src="/bower_components/angular-translate/angular-translate.min.js"></script>
    <script type="text/javascript" src="/bower_components/angular-translate-loader-static-files/angular-translate-loader-static-files.min.js"></script>
    <script type="text/javascript" src="/bower_components/angular-drag-and-drop-lists/angular-drag-and-drop-lists.min.js"></script>
    <!-- Application Scripts -->
    <script type="text/javascript" src="/js/app.js"></script>
    <!-- Application Controllers -->
    <script type="text/javascript" src="/js/controllers/loginController.js"></script>
    <script type="text/javascript" src="/js/controllers/registerController.js"></script>
    <script type="text/javascript" src="/js/controllers/domainsController.js"></script>
    <script type="text/javascript" src="/js/controllers/profilesController.js"></script>
    <script type="text/javascript" src="/js/controllers/playController.js"></script>
    <script type="text/javascript" src="/js/controllers/scoreController.js"></script>
    <!-- Application Services -->
    <script type="text/javascript" src="/js/services/sessionService.js"></script>
    <script type="text/javascript" src="/js/services/flashService.js"></script>
    <script type="text/javascript" src="/js/services/authService.js"></script>
    <script type="text/javascript" src="/js/services/registrationService.js"></script>
    <script type="text/javascript" src="/js/services/domainsService.js"></script>
    <script type="text/javascript" src="/js/services/profilesService.js"></script>
    <script type="text/javascript" src="/js/services/playService.js"></script>
    <script type="text/javascript" src="/js/services/scoreService.js"></script>
    <!-- CSRF Token -->
    <script type="text/javascript">
      angular.module('myApp').constant("CSRF_TOKEN", '<?php echo csrf_token(); ?>');
    </script>

    <!-- Sidenav -->
    <md-sidenav layout="column" class="md-sidenav-left md-whiteframe-z2" md-is-locked-open="$mdMedia('gt-md')">
      <md-toolbar layout-align="center center">
        <div style="text-align:center">
          <h1 class="md-display-1">KAT Game</h1>
          <h2 class="md-title">Knowledge AssociaTions Game</h2>
        </div>
        <div layout="row" ng-show="!isLoggedIn()">
          <md-button ng-click="goTo('/login')" translate="BTN_LOGIN"></md-button>
          <md-button ng-click="goTo('/register')" translate="BTN_REGISTER"></md-button>
        </div>
        <md-button ng-show="isLoggedIn()" ng-click="logout()" translate="BTN_LOGOUT"></md-button>
      </md-toolbar>
      <md-list>
        <md-list-item class="md-1-line" ng-click="goTo('/home')">
          <div class="icon"><i class="material-icons md-24">home</i></div>
          <div class="md-list-item-text" flex translate="BTN_HOME"></div>
        </md-list-item>
        <md-list-item class="md-1-line" ng-click="goTo('/register')" ng-show="!isLoggedIn()">
          <div class="icon"><i class="material-icons md-24">exit_to_app</i></div>
          <div class="md-list-item-text" flex><span translate="BTN_LOGIN"></span> / <span translate="BTN_REGISTER"></span></div>
        </md-list-item>
        <md-list-item class="md-1-line" ng-click="logout()" ng-show="isLoggedIn()">
          <div class="icon"><i class="material-icons md-24">power_settings_new</i></div>
          <div class="md-list-item-text" flex translate="BTN_LOGOUT"></div>
        </md-list-item>
        <md-list-item class="md-1-line" ng-click="goTo('/domains')">
          <div class="icon"><i class="material-icons md-24">dns</i></div>
          <div class="md-list-item-text" flex translate="BTN_DOMAINS"></div>
        </md-list-item>

        <div ng-show="isLoggedIn()">
          <md-divider></md-divider>
          <md-subheader class="md-no-sticky">Dashboard</md-subheader>
          <md-list-item class="md-1-line" ng-click="alert('clicked')">
            <div class="icon"><i class="material-icons md-24">games</i></div>
            <div class="md-list-item-text" flex translate="PROFILE_PLAY"></div>
          </md-list-item>
          <md-list-item class="md-1-line" ng-click="alert('clicked')">
            <div class="icon"><i class="material-icons md-24">view_list</i></div>
            <div class="md-list-item-text" flex translate="SCORES"></div>
          </md-list-item>
          <md-list-item class="md-1-line" ng-click="showNotCompleted($event)">
            <div class="icon"><i class="material-icons md-24">timeline</i></div>
            <div class="md-list-item-text" flex translate="STATS"></div>
          </md-list-item>
        </div>

        <md-divider></md-divider>
        <md-subheader class="md-no-sticky">About</md-subheader>
        <md-list-item class="md-1-line" ng-click="showNotCompleted($event)">
          <div class="icon"><i class="material-icons md-24">gps_fixed</i></div>
          <div class="md-list-item-text" flex translate="PURPOSE"></div>
        </md-list-item>
        <md-list-item class="md-1-line" ng-click="showNotCompleted($event)">
          <div class="icon"><i class="material-icons md-24">chrome_reader_mode</i></div>
          <div class="md-list-item-text" flex translate="PRIVACY"></div>
        </md-list-item>
        <md-list-item class="md-1-line" ng-click="showNotCompleted($event)">
          <div class="icon"><i class="material-icons md-24">feedback</i></div>
          <div class="md-list-item-text" flex>Feedback</div>
        </md-list-item>

        <md-divider></md-divider>
        <md-subheader class="md-no-sticky">More information</md-subheader>
        <md-list-item class="md-1-line" ng-click="showNotCompleted($event)">
          <div class="icon"><i class="material-icons md-24">import_contacts</i></div>
          <div class="md-list-item-text" flex>Academic Research</div>
        </md-list-item>
        <md-list-item class="md-1-line" ng-click="showNotCompleted($event)">
          <div class="icon"><i class="material-icons md-24">videogame_asset</i></div>
          <div class="md-list-item-text" flex>Games with a purpose</div>
        </md-list-item>
      </md-list>
    </md-sidenav>
    <!-- Main Container -->
    <div layout="column" layout-fill role="main">
      <!-- Upper bar -->
      <md-toolbar class="md-white-frame-z2" layout="row">
        <md-button ng-click="toggleSidenav('left')" hide-gt-md aria-label="Menu">
            <div class="icon"><i class="material-icons md-24">view_headline</i></div>
        </md-button>
        <h1 class="md-toolbar-tools" layout-align="center" flex>Knowledge AssociaTions Game v0.1.3</h1>
        <md-button ng-click="goTo('/login')" translate="BTN_HOME"></md-button>
        <md-button ng-click="goTo('/domains')" translate="BTN_DOMAINS"></md-button>
        <md-button ng-click="logout()" ng-show="isLoggedIn()" translate="BTN_LOGOUT"></md-button>
        <md-button ng-click="goTo('/login')" ng-show="!isLoggedIn()" translate="BTN_LOGIN"></md-button>
        <md-button ng-click="goTo('/register')" ng-show="!isLoggedIn()" translate="BTN_REGISTER"></md-button>
      </md-toolbar>

      <!-- Content -->
      <div class="md-default-theme" layout-fill>
        <md-content layout="colum" id="content" layout-fill>
          <div layout="row" layout-align="center center" flex>
            <div layout="column" flex flex-gt-sm="90" flex-gt-md="80">
              <div id="flash" ng-show="flash" flex>
                <md-toolbar class="md-warn">
                  <h1 class="md-toolbar-tools">{{ flash }}</h1>
                </md-toolbar>
              </div>
              <div id="view" ng-view flex></div>
            </div>
          </div>
        </md-content>
      </div>

    </div>
  </body>
</html>
