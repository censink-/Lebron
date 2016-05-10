<?php
if (isset($_GET['name'])) { $ps = true; }
include 'includes/header.php';
?>
<div class="container text-center">
    <?php
    if (!isset($_GET['name']) || $_GET['name'] == "") {
        ?>
        <h1>No Valid Username! <small>Enter one to continue</small></h1>
        <hr>
        <form id="usernameform" class="form-inline" method="get">
            <input id="usernameinput" required type="text" class="form-control" name="name"> <button class="btn btn-success" type="submit">Go!</button>
        </form>
    <?php
    } else {
        $username = $_GET['name'];
    ?>
    <h1><?= $username ?></h1>
    <hr>
    <div class="col-xs-12" id="progress">
        <div class="progress">
            <div id="percentage" class="progress-bar progress-bar-striped" style="width:0%">0%</div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="thumbnail"><img src="https://minotar.net/helm/<?php echo $username; ?>/245.png"><div class="caption"><h3><?php echo $username; ?></h3></div></div>
        <br>
        <ul class="list-group text-left">
            <li class="list-group-item"><b>Kills:</b> <span class="label label-success pull-right" id="killcount"></span></li>
            <li class="list-group-item"><b>Deaths:</b> <span class="label label-danger pull-right" id="deathcount"></span></li>
            <li class="list-group-item"><b>K/D Ratio:</b> <span class="label label-warning pull-right" id="kd"></span></li>
            <li class="list-group-item"><b>Most Kills On:</b><a class="btn btn-xs btn-success pull-right" href="#" id="mostkills" style="display:none"></a></li>
            <li class="list-group-item"><b>Most Deaths From:</b><a class="btn btn-xs btn-danger pull-right" href="#" id="mostdeaths" style="display:none"></a></li>
        </ul>
    </div>
    <div class="col-sm-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                Recent encounters:
            </div>
            <div class="panel-body">
                Here's a list of the last <span id="encountercount">pvp encounters</span> <?= $username; ?> has had!
            </div>
            <table class="table table-bordered" style="margin-bottom:0px;min-width:620px;">
                <thead>
                <tr class="tablehead">
                    <th><small>Date & Time<small></th>
                    <th><small>Gamemode</small></th>
                    <th><small>Winner</small></th>
                    <th width="167px"><small>Winner health</small></th>
                    <th><small>Loser</small></th>
                    <th width="25px"><small title="Kill Weapon">Wpn</small></th>
                </tr>
                </thead>
                <tbody id="kills">
				</tbody>
			</table>
        </div>
    </div>
    <?php } ?>
</div>
<?php include 'includes/footer.php'; ?>
<script src="<?php if(isset($ps)) { echo "../assets/js/player.js"; } else { echo "assets/js/playerform.js"; } ?>"></script>
</body>
</html>