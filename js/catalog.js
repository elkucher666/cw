document.addEventListener("DOMContentLoaded", loadRooms);  


async function loadRooms() {

    let response = await fetch('./../queries/get_room.php', {
        method: 'POST'
    });

    let result = await response.text();
    let rooms = JSON.parse(result);
    
    let addresses = [];

    let room_elements = [];

    for (let room of rooms) {
        if (!addresses.includes(room.address)) {
            addresses.push(room.address);
        }

        let room_element = document.createElement("div");
        room_element.dataset.address = room.address;
        room_element.classList.add("room");
        room_element.addEventListener("click", function() {
            insertCalendar(room.id);
            document.querySelector("#top_bar").classList.remove("none");
            document.querySelector("#room_image").src = '/../' + room.image;
            document.querySelector("#room_name").textContent = room.name;
            document.querySelector("#room_address").textContent = room.address;
            document.querySelector("#room_description").textContent = room.description;
        });

        let image = document.createElement("img");
        image.classList.add("image");
        image.src = room.image;

        let name = document.createElement("div");
        name.classList.add("name");
        name.textContent  = room.name;

        let description = document.createElement("div");
        description.classList.add("description");
        description.textContent = room.description;


        room_element.append(image, name, description);
        room_elements.push(room_element);
    }

    for (let address of addresses) {
        let button = document.createElement("button");
        button.textContent = address;
        button.classList.add("tab");
        document.querySelector(".addresses").append(button);


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

    

}

window.addEventListener("scroll", changeTopBarAppearanceOnScroll);

function changeTopBarAppearanceOnScroll() {
  var win_scroll = document.body.scrollTop || document.documentElement.scrollTop;
  var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  var scrolled = (win_scroll / height) * 100;
  if (scrolled > 50){
    document.getElementById("top_bar").classList.add("visible");
  }else{
    document.getElementById("top_bar").classList.remove("visible");
  }
  
}
