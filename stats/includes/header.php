<?php
if (isset($_COOKIE['Theme'])) {
    $theme = true;
} else {
    $theme = false;
}
?>
<html>
<head>
    <title>Lebroncraft Statistics</title>
    <link rel="stylesheet" href="<?php if(isset($ps)) { echo "../"; } ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php if(isset($ps)) { echo "../"; } ?>assets/css/style.css">
    <meta name="description" content="Interactive Statistics for the Lebroncraft minecraft server!">
</head>
<body<?php if($theme) { echo " class=\"special\""; } ?>>
<nav id="navBar" class="navbar <?php if($theme) { echo "navbar-inverse"; } else { echo "navbar-default"; } ?> navbar-static-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php if(isset($ps)) { echo "../"; } ?>./">Lebroncraft Statistics</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="<?php if(isset($ps)) { echo "../"; } ?>kills">Kills</a></li>
                <li><a href="<?php if(isset($ps)) { echo "../"; } ?>top">Leaderboard</a></li>
                <li><a href="<?php if(isset($ps)) { echo "../"; } ?>player">Player</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><button id="themeButton" type="button" class="btn btn-xs btn-<?php if($theme) { echo "default"; } else { echo "primary"; } ?> navbar-btn" onClick="<?php if($theme) { echo "setNormal();"; } else { echo "setSpecial();"; }; ?>">Theme <i class="glyphicon glyphicon-flash"></i></button></li>
                <li><a href="http://lebroncraft.com"><span class="hidden-sm">Back to the </span>Forums</a></li>
            </ul>
        </div>
    </div>
</nav>