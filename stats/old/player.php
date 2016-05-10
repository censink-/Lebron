<?php
	include 'header.php';
?>
	<div class="container text-center">
		<?php
			require "db/connect.php";

			if (isset($_POST['inputName'])) {
				echo "<meta http-equiv='refresh' content='0;URL=player?name=" . $_POST['inputName'] . "'>";
			}
			if (!isset($_GET['name']) || $_GET['name'] == "") {
		?>
		<h1>No Valid Username! <small>Enter one to continue</small></h1>
		<hr>
		<form action="player.php" method="post">
			<input required type="text" class="form-control" style="width:200px;display:inline;" name="inputName"> <button class="btn btn-success" style="margin-top:-3px;" type="submit">Go!</button>
		</form>
		<?php
			} else {

				$username = $_GET['name'];
				$getname = mysqli_query($db, "SELECT * FROM $playertable WHERE USERNAME='$username' LIMIT 1");
				if (!isset($_COOKIE['ViewsUpdate'])) {
					echo "<script>var now = new Date(); var time = now.getTime(); time += 86400 * 1000; now.setTime(time); document.cookie='ViewsUpdate=Noooooo pls no i beg;expires=' + now.toUTCString();</script>";
					$pageview = mysqli_query($db, "UPDATE $playertable SET PAGEVIEWS = PAGEVIEWS + 1 WHERE USERNAME='$username'");
				} // or else page was viewed by same person within the last day, so fuck giving it another view.
				
				$name = mysqli_fetch_array($getname);
				if ($name['USERNAME'] != $username) {
					die("<meta http-equiv='refresh' content='0;URL=player?name=" . $name['USERNAME'] . "'>");
				};
				echo "<meta http-equiv=\"refresh\" content=\"30;URL=" . $_SERVER['REQUEST_URI'] . "\">";
				echo '<h1>' . $username . '\'s stats!</h1>';

				$getstats = mysqli_query($db, "SELECT * FROM $playertable WHERE USERNAME='$username'");
				$stats = mysqli_fetch_array($getstats);

				$getenemykills = mysqli_query($db, "SELECT `LOSE_USER`, COUNT(`LOSE_USER`) AS `value_occurrence` FROM $killstable WHERE WIN_USER = '$username' GROUP BY `LOSE_USER` ORDER BY `value_occurrence` DESC LIMIT 1");
				$enemykills = mysqli_fetch_array($getenemykills);

				$getenemydeaths = mysqli_query($db, "SELECT `WIN_USER`, COUNT(`WIN_USER`) AS `value_occurrence` FROM $killstable WHERE LOSE_USER = '$username' GROUP BY `WIN_USER` ORDER BY `value_occurrence` DESC LIMIT 1");
				$enemydeaths = mysqli_fetch_array($getenemydeaths);

				if ($stats['DEATHS'] != 0) {
					if ($stats['KILLS'] == 0) {
						$kd = round(1 / $stats['DEATHS'],2);
					} else {
						$kd = round($stats['KILLS'] / $stats['DEATHS'],2);
					}
				} else {
					$kd = $stats['KILLS'];
				}
		?>
		
		<hr>
		<div class="col-sm-3">
			<div class="thumbnail"><img src="https://minotar.net/helm/<?php echo $username; ?>/245.png"><div class="caption"><h3><?php echo $username; ?></h3></div></div>
			<br>
			<ul class="list-group text-left">
				<li class="list-group-item"><b>ELO Rating:</b> <span class=<?php if($stats['ELO'] >= 1000) { if($stats['ELO'] == 1000) { echo "\"label label-warning pull-right\""; } else { echo "\"label label-success pull-right\""; } } else { echo "\"label label-danger pull-right\""; } ?>><?php echo $stats['ELO']; ?></span></li>
				<li class="list-group-item"><b>Kills:</b> <span class="label label-success pull-right"><?php echo $stats['KILLS']; ?></span></li>
				<li class="list-group-item"><b>Deaths:</b> <span class="label label-danger pull-right"><?php echo $stats['DEATHS']; ?></span></li>
				<li class="list-group-item"><b>K/D Ratio:</b> <span class=<?php if($kd >= 1) { if($kd == 1) { echo "\"label label-warning pull-right\">" . $kd; } else { echo "\"label label-success pull-right\">" . $kd; } } else { echo "\"label label-danger pull-right\">" . $kd; } ?></span></li>
				<li class="list-group-item"><? if($stats['STREAK'] > 0) { echo "<b class=\"text-success\"><span class=\"hidden-xs hidden-sm\">Current </span>killstreak:</b> <span class=\"label label-success pull-right\">"; } else { echo "<b class=\"text-danger\">Current deathstreak:</b> <span class=\"label label-danger pull-right\">"; } echo str_replace("-", "", $stats['STREAK']); ?></span></li>
				<li class="list-group-item"><b>Most Kills From:</b><br><?php if ($enemykills[0] == "") { echo "<p>Nobody!</p>"; } else { echo "<a class=\"btn btn-xs btn-success\" href=\"player?name=" . $enemykills[0] . "\">" . $enemykills[0] . "</a>"; }?></li>
				<li class="list-group-item"><b>Most Deaths From:</b><br><?php if ($enemydeaths[0] == "") { echo "Nobody!"; } else { echo "<a class=\"btn btn-xs btn-danger\" href=\"player?name=" . $enemydeaths[0] . "\">" . $enemydeaths[0] . "</a>"; }?></li>
				<li class="list-group-item"><b>Page Views:</b> <span class="label label-primary pull-right"><?php echo $stats['PAGEVIEWS']; ?></span></li>
			</ul>
		</div>
		<div class="col-sm-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				Recent encounters:
			</div>
			<div class="panel-body">
				Here's a list of the latest <?php if ($stats['KILLS'] + $stats['DEATHS'] < 20) { echo $stats['KILLS'] + $stats ['DEATHS']; } else { echo 20; } ?> pvp encounters <?php echo $username; ?> has had!
			</div>
			<table class="table table-bordered" style="margin-bottom:0px;min-width:620px;">
				<thead>
					<tr class="tablehead">
						<th width="auto"><small>Date & Time<small></th>
						<th><small>Winner</small></th>
						<th width="167px"><small>Winner health</small></th>
						<th><small>Loser</small></th>
						<th width="25px"><small title="Kill Weapon">Wpn</small></th>
					</tr>
				</thead>
				<tbody>
				<?php
					require('westsworld.datetime.class.php');
					require('timeago.inc.php');

					$getpvplog = mysqli_query($db, "SELECT * FROM $killstable WHERE WIN_USER='$username' OR LOSE_USER='$username' ORDER BY DATE_TIME DESC LIMIT 20");
					while ($list = mysqli_fetch_array($getpvplog)) {
						$datetimeold = str_replace(" ", " @ ", $list["DATE_TIME"]);

						$year = substr($datetimeold, 0, 4);
						$month = substr($datetimeold, 5, 2);
						$day = substr($datetimeold, 8, 2);
						$time = substr($datetimeold, 12, 9);
						$datetime = $day . "-" . $month . "-" . $year . " @ " . $time;
						$health = 5 * $list['WIN_HEALTH'];

						include 'weapon.php';
						
						$timeago = new TimeAgo();

						if ($list['LOSE_USER'] == $username) {
							echo "<tr class='danger'>";
						} else {
							echo "<tr class='success'>";
						}

						if ($list['WIN_USER'] == $username) {
							$winner = "<b>" . $list['WIN_USER'] . "</b>";
						} else {
							$winner = "<a href=\"player?name=" . $list['WIN_USER'] . "\">" . $list['WIN_USER'] . "</a>";
						}
						if ($list['LOSE_USER'] == $username) {
							$loser = "<b>" . $list['LOSE_USER'] . "</b>";
						} else {
							$loser = "<a href=\"player?name=" . $list['LOSE_USER'] . "\">" . $list['LOSE_USER'] . "</a>";
						}
						echo "<td data-toggle='popover' data-container='body' data-placement='right' data-content='$datetime' data-trigger='hover'>" . $timeago->inWords($list['DATE_TIME']) . " ago</td><td>" . $winner . " <span class=\"hidden-xs hidden-sm\">(<span class=\"text-success\">+" . -$list['ELO_DIFF_KILLER'] . "</span>)</span></td><td><div class='hearts h-" . $health . "'></div></td><td>" . $loser . " <span class=\"hidden-xs hidden-sm\">(<span class=\"text-danger\">" . -$list['ELO_DIFF_VICTIM'] . "</span>)</span></td>" . $weapon;
						echo "</tr>";
									}
						echo '
				</tbody>
			</table>';
		}
				?>
		</div>
		</div>
		<br>
	</div>
	<?php include 'footer.php'; ?>
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script>
		$(function(){
				$("[data-toggle='popover']").popover();
			});
	</script>
</body>
</html>