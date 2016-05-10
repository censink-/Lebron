$(init)

function init() {
    $('#usernameform').on("submit", submitHandler);
}

function submitHandler(e) {
    e.preventDefault();
    player = $('#usernameinput').val();
    window.location.assign("./player/" + player);
}