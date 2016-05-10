<?php
if (isset($_COOKIE['Theme'])) {
	$theme = true;
}
?>
<html>
<head>
	<title>Crewniverse Factions</title>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/custom.css">
	<meta name="description" content="Interactive PvP Statistics for the Crewniverse.com minecraft server!">
	<style>
		body {
			-webkit-transition: all .5s ease-in-out;
			transition: all .5s ease-in-out;
		}
		.special {
			background-color: #333333;
		}
		.special > div > h1,
		.special h4,
		.special label {
			color: #DDDDDD;
		}
		.special form > input,
		.special .list-group-item,
		.special .panel-heading {
			background-color: #666666;
			border: 1px solid #999999;
			color: #DDDDDD;
		}
		.special form > input:focus {
			background-color: #999999;
		}
		.special .well,
		.special .thumbnail,
		.special .table-striped tr:nth-child(odd)>td,
		.special table,
		.special .panel-body {
			background-color: #999999;
		}
		.special .tablehead {
			background-color: #666666;
		}
		.special .table>tbody>tr.warning>td {
			background-color: #B0B284;
		}
		.special .table>tbody>tr.active>td {
			background-color: #BBBBBB;
		}
		.special .table>tbody>tr.bronze>td {
			background-color: #AD9F92;
		}
		.special .table>tbody>tr.success>td {
			background-color: #A7BEA7;
		}
		.special .table>tbody>tr.danger>td {
			background-color: #BEA7A7;
		}
		.special .well>h1>small {
			color: #666666;
		}
		.special a,
		.special a:hover {
			color: #3853B4;
		}
		.special .btn,
		.special .btn:hover,
		.special th {
			color: white;
		}
		.special .btn.btn-default {
			color: black;
		}
		.special .list-group-item>.text-success {
			color: #5CB85C;
		}
		.special .list-group-item>.text-danger {
			color: #D9534F;
		}
	</style>
</head>
<body<?php if($theme) { echo " class=\"special\""; } ?> style="margin-bottom:35px;">
	<nav id="navBar" class="navbar <?php if($theme) { echo "navbar-inverse"; } else { echo "navbar-default"; } ?> navbar-static-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="">Crewniverse Factions</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href="kills">Kills</a></li>
						<li><a href="top">Leaderboard</a></li>
						<li><a href="player">Player</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<li><button id="themeButton" type="button" class="btn btn-xs btn-<?php if(isset($theme)) { echo "default"; } else { echo "primary"; } ?> navbar-btn" onClick="<?php if(isset($theme)) { echo "setNormal();"; } else { echo "setSpecial();"; }; ?>">Theme <i class="glyphicon glyphicon-flash"></i></button></li>
						<li><a href="http://crewniverse.com/forums"><span class="hidden-sm">Back to the </span>Forums</a></li>
					</ul>
			</div>
		</div>
	</nav>