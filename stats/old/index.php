<?php
	include 'header.php';
?>
	<div class="container text-center">
		<h1>Crewniverse Factions <small>PvP Statistics</small></h1>
		<hr>
		<img class="img-rounded" src="assets/images/spawn.png" width="100%">
		<hr>
		<div class="col-md-4">
			<div class="thumbnail">
				<div class="caption">
					<h3>Real-time Stats!</h3>
				</div>
				<i class="glyphicon glyphicon-time huge"></i>
				<div class="caption"><b><p>All our statistics are 100% live!<br>As soon as a player gets killed, this website will know.<hr>Our Pages update themselves every 30 seconds, but you can refresh the page yourself too!</p></b></div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="thumbnail">
				<div class="caption">
					<h3>Top-10!</h3>
				</div>
				<table class="table table-striped table-condensed col-xs-4">
					<thead>
						<tr>
							<th>#</th>
							<th>Username</th>
							<th>ELO</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						require 'db/connect.php'; 
						$getlist = mysqli_query($db, "SELECT * FROM $playertable ORDER BY ELO DESC,KILLS DESC,DEATHS ASC,PLAYTIME ASC LIMIT 10");
						$position = 1;
						while ($list = mysqli_fetch_array($getlist)) {
							echo "<tr>";
								echo "<td>" . $position++ . "</td>";
								echo "<td><a href=\"player?name=" . $list['USERNAME'] . "\">" . $list['USERNAME'] . "</td>";
								echo "<td>" . $list['ELO'] . "</td>";
							echo "<tr>";
						}
						?>
					</tbody>
				</table>
				<div class="caption">
					<a href="top" class="btn btn-lg btn-primary">See Full Leaderboards!</a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="thumbnail">
				<div class="caption"><h3>ELO?</h3></div>
				<i class="glyphicon glyphicon-stats huge"></i>
				<div class="caption"><b><p>We make use of an advanced skill rating system called ELO!<br>It gives a much more accurate description of a user's level of skill than a kill/death ratio would.<hr>Kill a <span class="text-success">high-ranked player</span>, and you will earn a lot of ELO points.<hr>Kill a <span class="text-danger">low-ranked player</span>, and you will earn less ELO points!</p></b></div>
			</div>
		</div>
	</div>
	<?php include 'footer.php'; ?>
</body>
</html>