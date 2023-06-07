document.addEventListener("DOMContentLoaded", loadRooms);  

// Загружаем все помещения
async function loadRooms() {
    let url = './../queries/get_room.php';
    let options = {
        method: 'GET',
    };

    // Список всех помещений
    let response = await fetch(url, options);
    let result = await response.text();
    let rooms = JSON.parse(result);

    // Массив всех адресов
    let addresses = [];

    // Массив всех карточек
    let room_cards = [];

    let last_button = null;
    
    for (let room of rooms) {
        // Формируем список всех адресов
        if (!addresses.includes(room.address)) {
            addresses.push(room.address);
        }

        // Формируем основу карточки
        let room_card = document.createElement("div");

        //Добавляем стиль, события и адрес для карточки
        room_card.dataset.address = room.address;
        room_card.classList.add("room");
        room_card.addEventListener("click", function() {
            window.current_room_id = room.id;
            room_cards.forEach(function(room_card) {
                room_card.classList.remove("selected");
            })
            this.classList.add("selected");
            insertCalendar(room.id);
            document.querySelector("#top_bar").classList.remove("none");
            document.querySelector("#room_image").src = '/../' + room.image;
            document.querySelector("#room_name").textContent = room.name;
            document.querySelector("#room_address").textContent = room.address;
            document.querySelector("#room_description").textContent = room.description;
        });

        // Создаём изображение помещения
        let image = document.createElement("img");
        image.classList.add("image");
        image.src = room.image;

        // Создаём название помещения
        let name = document.createElement("div");
        name.classList.add("name");
        name.textContent  = room.name;

        // Создаём описание помещения
        let description = document.createElement("div");
        description.classList.add("description");
        description.textContent = room.description;

        // Формируем полноценную карточку помещения 
        // и добавляем её в общий массив
        room_card.append(image, name, description);
        room_cards.push(room_card);
    }

    // Для всех адресов создаём верхнее меню управления
    for (let address of addresses) {
        let button = document.createElement("button");
        button.textContent = address;
        button.classList.add("tab");
        button.addEventListener("click", function(e) {
            // При нажатии кнопки - отчищаем предыдущую выделенную кнопку
            if (last_button == null) {
                last_button = button;
            } else {
                button.classList.remove("selected");
                last_button = button;
                last_button.classList.add("selected");
            }
            // document.querySelectorAll(".tab").forEach(function (elem) {
            //     elem.classList.remove("selected");
            // });

            // Удаляем все карточки
            room_cards.forEach(function(room) {
                room.remove();
                // console.log(room);
            });
            
            let visible_rooms = room_cards.filter((room) => room.dataset.address == address);
            visible_rooms.forEach(function(room) {
                document.querySelector(".tabcontent").append(room);
            });
        });

        // Добавляем кнопку в конец блока с адресами
        document.querySelector(".addresses").append(button);
    }

    // Открываем первое помещение первого адреса
    document.querySelector(".tab:first-child").click();
    document.querySelector(".tabcontent .room:first-child").click();
}

window.addEventListener("scroll", changeTopBarAppearanceOnScroll);

function changeTopBarAppearanceOnScroll() {
    var win_scroll = document.body.scrollTop || document.documentElement.scrollTop;
    var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    var scrolled = (win_scroll / height) * 100;
    
    if (scrolled > 50) {
        document.getElementById("top_bar").classList.add("visible");
    } else {
        document.getElementById("top_bar").classList.remove("visible");
    }
  
}
