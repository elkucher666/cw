$(document).ready(navbar);

function navbar(){
    title = ["ОПИСАНИЕ", "ПОМЕЩЕНИЯ", "БРОНИРОВАТЬ"];
    id = ["about", "catalogstr", "book"];
    var mySnav = document.createElement("div");
    var ul = document.createElement("ul");
    for (i = 0; i < 3; i++){
        li = document.createElement("li");
        a = document.createElement("a");
        a.textContent = title[i];
        a.setAttribute("href", "#" + id[i]);
        a.setAttribute("id", "nav" + id[i]);
        li.appendChild(a);
        ul.appendChild(li);
        mySnav.appendChild(ul);
        document.getElementById('mySidenav').appendChild(mySnav);
    }
}
