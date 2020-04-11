function callUserLogin() {
    console.log("run")
    let username = $('#loginUser').val();
    let password = $('#loginPass').val();
    jQuery.ajax({
        type: "POST",
        url: '/logic/requestHandler.php',
        dataType: 'json',
        data: {function: 'loginUser', params: [username, password]},

        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
                //TODO
            }
            else {
                console.log(obj.error);
            }
        }
    });
}