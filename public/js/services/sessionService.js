(function() {
  'use strict';

  angular.module('myApp').factory('SessionService', [SessionService]);

  function SessionService() {
    return {
      get: function(key) {
        return sessionStorage.getItem(key);
      },
      set: function(key, val) {
        return sessionStorage.setItem(key, val);
      },
      unset: function(key) {
        return sessionStorage.removeItem(key);
      }
    };
  }

})();
