<?php
	require_once("_bootstrap.php");
	require_once("auth/brda_steamauth.php");
?>
<!DOCTYPE html>
<html ng-app="brdaStats">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body ng-controller="StatsController as stats">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script> -->
<script type="text/javascript" src="stats.js"></script>
<script type="text/javascript" src="app.js"></script>

<section ng-controller="SteamController as steam" class="container">
	<div class="pull-right"><button ng-click="steam.login()">LOGIN, BITCH</button></div>
</section>

<section ng-controller="PanelController as panel" class="container">
	<!--  navigation -->
	<ul class="nav nav-pills">
		<li ng-class="{ active:panel.isSelected('members') }">
			<a href ng-click="panel.selectTab('members')">Members ({{ stats.members.length || 'loading...' }})</a>
		</li>
		<li ng-class="{ active:panel.isSelected('games') }">
			<a href ng-click="panel.selectTab('games')">Games ({{ stats.games.length || 'loading...' }})</a>
		</li>
	</ul>

	<!--  members list -->
	<div class="panel col-md-6" ng-show="panel.isSelected('members')" style="border: 1px solid black; width:50%">
		<input ng-model="query" type="text" placeholder="Filter by" autofocus>
		<ul>
			<li ng-repeat="member in stats.members | filter:query" ng-class="{ active:stats.isCurrentMember(member.id) }">
				<a href ng-click="stats.setMember(member)">{{ member.username }}</a>
			</li>
		</ul>
	</div>

	<!-- games list -->
	<div class="panel col-md-6" ng-show="panel.isSelected('games')" style="border: 1px solid black; width:50%">
		<input ng-model="query" type="text" placeholder="Filter by" autofocus>
		Sort by: <select ng-model="gameSort">
			<option value="game" selected="true">game name</option>
			<option value="-numPlayers"># of players</option>
		</select>
		<ul>
			<li ng-repeat="game in stats.games | filter:query | orderBy:gameSort" ng-class="{ active:stats.isCurrentGame(game.id) }">
				<a href ng-click="stats.setGame(game)">{{ game.name }}</a> ({{ game.numPlayers }} players)
			</li>
		</ul>
	</div>

	<!-- member detail -->
	<div class="panel col-md-6" ng-show="panel.isSelected('members') && stats.currentMember">
		<strong>Stats for {{ stats.currentMember.username }}:</strong><br/>
		{{ stats.currentMember.games.length || 'loading' }} game(s)<br/>
		<ul>
			<li ng-repeat="game in stats.currentMember.games">
				{{ game.name }} ({{ game.numPlayers - 1}} other players)
				<!-- <br/>Play time: {{ game.playTime / 60 | number:2 }} hours<br/>-->
			</li>
		</ul>

	</div>

	<!-- game detail -->
	<div class="panel col-md-6" ng-show="panel.isSelected('games') && stats.currentGame">
		<strong>Stats for {{ stats.currentGame.name }}:</strong><p/>
		Players ({{ stats.currentGame.players.length }} total):
		<ul>
			<li ng-repeat="player in stats.currentGame.players">
				{{ player.username }}
			</li>
		</ul>
	</div>

</section>

</body>
</html>
