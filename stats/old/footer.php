<?php
require "db/connect.php";
$getkill = mysqli_query($db, "SELECT * FROM $killstable order by DATE_TIME desc LIMIT 1");
$kill = mysqli_fetch_array($getkill);
?>
<div style="width:100%;height:40px;background-color:rgba(255,255,255,0.5);bottom:0px;left:0px;position:fixed;border-top:3px solid rgba(255,255,255,0.5);text-align:center;vertical-align:middle;box-shadow:0 0 5px 0px gray;"><h5>Latest Kill By <a href="player?name=<?php echo $kill['WIN_USER']; ?>"><?php echo $kill['WIN_USER']; ?></a> (<span class="text-success">+<?php echo -$kill['ELO_DIFF_KILLER']; ?></span>)!</h5></div>
<script>
	function setSpecial() {
		document.getElementById('themeButton').setAttribute("onClick", "setNormal();");
		document.cookie='Theme=Special';
		document.getElementById('navBar').setAttribute("class", "navbar navbar-inverse navbar-static-top");
		document.getElementById('themeButton').setAttribute("class", "btn btn-xs btn-default navbar-btn");
		document.body.setAttribute("class", "special");
	}
	function setNormal() {
		document.getElementById('themeButton').setAttribute("onClick", "setSpecial();");
		document.cookie='Theme=;expires=Thu, 01 Jan 1970 00:00:00 GMT';
		document.getElementById('navBar').setAttribute("class", "navbar navbar-default navbar-static-top");
		document.getElementById('themeButton').setAttribute("class", "btn btn-xs btn-primary navbar-btn");
		document.body.setAttribute("class", "");
	}
</script>
