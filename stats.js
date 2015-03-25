(function() {
	var app = angular.module('stats-module', []);
	
	app.controller('StatsController', [ '$http', function($http) {
		var self = this;
		
		this.members = [];
		this.games = [];

		this.currentGame = null;
		this.currentMember = null;

		$http.get('data.php', { params: { op: 'getAllPlayers' } }).success(function(result) { self.members = result; });
		$http.get('data.php', { params: { op: 'getAllGames' } }).success(function(result) { self.games = result; });
				
		this.setMember = function(obj) {
			var self = this;
			
			this.currentGame = null;
			this.currentMember = obj;
			
			$http.get('data.php', { params: { op: 'getGamesByPlayer', id: obj.id } }).success(function(result) { self.currentMember.games = result; });
		};

		this.setGame= function(obj) {
			var self = this;
			
			this.currentMember = null;
			this.currentGame = obj;

			$http.get('data.php', { params: { op: 'getPlayersByGame', id: obj.id } }).success(function(result) { self.currentGame.players = result; });
		};

		this.isCurrentMember = function(id) {
			return this.currentMember && this.currentMember.id === id;
		}
		
		this.isCurrentGame= function(id) {
			return this.currentGame && this.currentGame.id === id;
		}
		
		this.resetCurrent = function() {
			this.currentGame = null;
			this.currentMember = null;
		};
	}]);

})();