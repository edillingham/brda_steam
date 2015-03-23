(function() {
	var app = angular.module('brdaStats', []);
	
	app.controller('StatsController', function() {
		this.members = users;
		this.games = gameList;

		this.currentGame = null;
		this.currentMember = null;
				
		this.setMember = function(obj) {
			this.currentMember = obj;
			this.currentGame = null;
		};

		this.setGame= function(obj) {
			this.currentGame = obj;
			this.currentMember = null;
		};

		this.isCurrentMember = function(id) {
			return this.currentMember && this.currentMember.id === id;
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