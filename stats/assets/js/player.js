$(init);

var player,
    perc = $('#percentage');

function init() {
    console.log("init| player.js: loaded\n");
    player = $.urlParam();
    console.log("init| playername: " + player);
    setProgress(20);
    getUUID(player);
}

$.urlParam = function(){
    var results = new RegExp('player/([^&amp;#]*)').exec(window.location.href);
    return results[1] || 0;
}

function setProgress(number) {
    console.log("setProgress| Setting progress to " + number + "%");
    perc.attr('style', ("width: " + number + "%"));
    perc.text(number + "%");

    if (number == 100) {
        perc.addClass("progress-bar-success");
        setTimeout(function() {
            $('#progress').slideUp(500);
        }, 2000);
    }
    console.log("setProgress| Done setting progress");
}

function getUUID(name) {
    console.log("getUUID| Getting UUID from " + name);
    $.ajax({
        dataType: "json",
        url: "../api.php",
        data: {action: "uuid", username: name},
        success: gotUUID
    });
}

function gotUUID(data) {
    console.log(data);
    if (data.meta.status == 200) {
        var uuid = data.data.uuid;
        console.log("gotUUID| Got UUID: " + uuid);
        setProgress(40);
        getData(uuid);
    } else {
        alert("Error " + data.meta.status + ": " + data.meta.error);
        setProgress(0);
    }
}

function getData(uuid) {
    console.log("getData| Getting data from " + uuid);
    setProgress(60);
    $.ajax({
        dataType: "json",
        url: "../api.php",
        data: {action: "player", uuid: uuid},
        success: gotData
    });
}

function gotData(data) {
    console.log(data);
    if (data.meta.status == 200) {
        setProgress(80);
        $('#killcount').text(data.data.killcount);
        $('#deathcount').text(data.data.deathcount);
        $('#kd').text(data.data.killcount / data.data.deathcount);
        $('#mostkills').text(data.data.most_kills + " (" + data.data.most_kills_count + ")").attr("href", "../player/" + data.data.most_kills).show();
        $('#mostdeaths').text(data.data.most_deaths + " (" + data.data.most_deaths_count + ")").attr("href", "../player/" + data.data.most_deaths).show();
        var encountercount = 0;

        if (data.data.kills) {
            $.each(data.data.kills, function(i, result) {
                encountercount++;
                var color;
                if (result.winner == player) {
                    color = "success";
                } else {
                    color = "danger";
                }
                var newRow = $('<tr>')
                    .addClass(color)
                    .append($('<td>').text(result.datetime))
                    .append($('<td>').text(result.gamemode))
                    .append($('<td>').text(result.winner))
                    .append($('<td>')
                        .append($('<div>')
                            .addClass("hearts h-" + result.winner_health)))
                    .append($('<td>').text(result.loser))
                    .append($('<td>')
                        .append($('<img>')
                            .attr("src", "../assets/img/textures/items/" + result.weapon + ".png")));
                $('#kills').append(newRow);
            });
            if (encountercount == 1) {
                encountercount = "pvp encounter";
            } else if (encountercount == 0) {
                encountercount = "pvp encounters";
            } else {
                encountercount += " pvp encounters";
            }
        }
        $('#encountercount').text(encountercount);
        setProgress(100);
    } else {
        alert("Error " + data.meta.status + ": " + data.meta.error);
        setProgress(0);
    }
}