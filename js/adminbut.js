document.addEventListener("DOMContentLoaded", adminbutton);

function adminbutton() {
    document.querySelector('.adminbut').addEventListener("click", function() {
        document.location = './../views/admin.html'
    });
}

