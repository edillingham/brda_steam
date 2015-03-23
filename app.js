(function() {
	var app = angular.module('brdaStats', []);
	
	app.controller('StatsController', function() {
		var self = this;
		
		this.members = {};
		this.games = {};

		this.currentGame = null;
		this.currentMember = null;

		$.ajax('data.php', {
			async: false,
			data: { op: 'getAllPlayers' },
			method: 'GET',
			dataType: 'json',
			success:function(result) {
				self.members = result; 
			}
		});

		$.ajax('data.php', {
			async: false,
			data: { op: 'getAllGames' },
			method: 'GET',
			dataType: 'json',
			success:function(result) {
				self.games = result; 
			}
		});
				
		this.setMember = function(obj) {
			var self = this;
			
			this.currentGame = null;
			this.currentMember = obj;
			
			$.ajax('data.php', {
				async: false,
				data: { op: 'getGamesByPlayer', id: obj.id },
				method: 'GET',
				dataType: 'json',
				success:function(result) {
					self.currentMember.games = result; 
				}
			});
		};

		this.setGame= function(obj) {
			var self = this;
			
			this.currentMember = null;
			this.currentGame = obj;

			$.ajax('data.php', {
				async: false,
				data: { op: 'getPlayersByGame', id: obj.id },
				method: 'GET',
				dataType: 'json',
				success:function(result) {
					self.currentGame.players = result; 
				}
			});
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
	});
	
	app.controller('PanelController', function() {
		this.tab = 'members';				// replaces ng-init
		
		this.selectTab = function(setTab) {	// replaces ng-click expression
			this.tab = setTab;
		};
		this.isSelected = function(checkTab) {
			return this.tab === checkTab;
		};
	});
	
	var users = [
		{
			id: 1,
			name: 'weevhy',
			games: [{ id: 70,  name: 'Half-Life',playTime: 100, lastPlayed: Date.now() }]
		},{
			id: 2,
			name: 'bloodygonzo',
			games: [
			        { id: 70, name: 'Half-Life', playTime: 1000, lastPlayed: Date.now() },
			        { id: 440, name: 'Team Fortress 2', playTime: 10, lastPlayed: Date.now() }
			        ]
		},{
			id: 3,
			name: 'Brobandy',
			games: [{ id: 440,  name: 'Team Fortress 2', playTime: 10, lastPlayed: Date.now() }]
		}
	];

	var gameList = [
         {
        	 id: 70,
        	 name: 'Half-Life',
        	 players: [
    	           { id: 1, name: 'weevhy', playTime: 100, lastPlayed: Date.now() },
    	           { id: 2, name: 'bloodygonzo', playTime: 1000, lastPlayed: Date.now() },
    	           ]
         },
         {
        	 id: 440,
        	 name: 'Team Fortress 2',
        	 players: [
    	           { id: 2, name: 'bloodygonzo', playTime: 1000, lastPlayed: Date.now() },
    	           { id: 3, name: 'Brobandy', playTime: 10, lastPlayed: Date.now() },
    	           ]
         }
     ];
})();