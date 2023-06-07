document.addEventListener("DOMContentLoaded", loadRooms);  
window.addEventListener("scroll", changeTopBarAppearanceOnScroll);

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

    // Последняя нажатая Кнопка/Карточка
    let last_button = null;
    let last_card = null;
    
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
            // При нажатии кнопки - отчищаем предыдущую выделенную(нажатую) кнопку
            if (last_card == null) {
                last_card = room_card;
            } else {
                last_card.classList.remove("selected");
                last_card = room_card;
                last_card.classList.add("selected");
            }

            // Формируем карточку
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
        button.addEventListener("click", function() {
            // При нажатии кнопки - отчищаем предыдущую выделенную(нажатую) кнопку
            if (last_button == null) {
                last_button = button;
            } else {
                last_button.classList.remove("selected");
                last_button = button;
                last_button.classList.add("selected");
            }

            // Удаляем все карточки
            room_cards.forEach(function(room) {
                room.remove();
            });
            
            // Формируем и отображаем помещения соответсвующие выбранному адресу
            let visible_rooms = room_cards.filter((room) => room.dataset.address == address);
            visible_rooms.forEach(function(room) {
                document.querySelector(".tabcontent").append(room);
            });
        });

        // Добавляем кнопку в конец блока с адресами
        document.querySelector(".addresses").append(button);
    }

    let first_tab = document.querySelector(".tab:first-child");
    first_tab.click();

    let first_room = document.querySelector(".room:first-child");
    first_room.click();

    // Открываем первое помещение первого адреса
    document.querySelector(".tab:first-child").click();
    document.querySelector(".tabcontent .room:first-child").click();
}

// При скролле достаточно вниз
// Формируем вернее меню с выбранным помещением
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
