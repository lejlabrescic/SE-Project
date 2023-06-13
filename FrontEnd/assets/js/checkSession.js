$(document).ready(() => {
    $.ajax({
        method: 'GET',
        url: "http://localhost/newProject/backEnd/checkSession",
        xhrFields: {
            withCredentials: true
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.success) {
                // User is logged in, display home page content
                // ...
            } else {
                window.location.href = "./../../index.html";
            }
        },
        error: function () {
            window.location.href = "./../../index.html";
        },
    });

   
});