function setSpecial() {
    $('#themeButton').attr("onClick", "setNormal();");
    document.cookie='Theme=Special';
    $('#navBar').attr("class", "navbar navbar-inverse navbar-static-top");
    $('#themeButton').attr("class", "btn btn-xs btn-default navbar-btn");
    $('body').attr("class", "special");
}
function setNormal() {
    $('#themeButton').attr("onClick", "setSpecial();");
    document.cookie='Theme=;expires=Thu, 01 Jan 1970 00:00:00 GMT';
    $('#navBar').attr("class", "navbar navbar-default navbar-static-top");
    $('#themeButton').attr("class", "btn btn-xs btn-primary navbar-btn");
    $('body').attr("class", "");
}