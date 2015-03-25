(function() {
	var app = angular.module('brdaStats', ['stats-module']);

	app.controller('SteamController', [ '$log', function($log) {
		this.login = function() {
			$log.log('attempting to login to steam...');
		};
	}]);
	
	app.controller('PanelController', function() {
		this.tab = 'members';				// replaces ng-init
		
		this.selectTab = function(setTab) {	// replaces ng-click expression
			this.tab = setTab;
		};
		this.isSelected = function(checkTab) {
			return this.tab === checkTab;
		};
	});
})();