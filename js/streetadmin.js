document.addEventListener("DOMContentLoaded", loadStreet);

async function loadStreet() {

    let response = await fetch('./../queries/get_room.php', {
        method: 'POST'
    });
    let result = await response.text();
    let rooms = JSON.parse(result);

    let addresses = [];
    for (let room of rooms) {
        if (!addresses.includes(room.address)) {
            addresses.push(room.address);
        }
    }
    for (let address of addresses) {
        let button = document.createElement("button");
        button.textContent = address;
        button.classList.add("tab");
        document.querySelector(".addressses").append(button);


        button.addEventListener("click", function() {

            document.querySelectorAll(".tab").forEach(function (elem) {
                elem.classList.remove("selected");
            });
            button.classList.add("selected");


            room_elements.forEach(function(room) {
                room.remove();
            });
            
            let visible_rooms = room_elements.filter((room) => room.dataset.address == address);
            visible_rooms.forEach(function(room) {
                document.querySelector(".tabcontent").append(room);
            });
            
        });
    }
    
    let buttime = document.querySelector('.buttime');
    buttime.addEventListener("click", function() {

        document.querySelectorAll(".buttime").forEach(function (elem) {
            elem.classList.remove("selected");
        });
        buttime.classList.add("selected");
        
    });
}
