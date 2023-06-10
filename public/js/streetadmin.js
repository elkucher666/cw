document.addEventListener("DOMContentLoaded", onLoad);

// Список url
let rooms_url =  "rooms/load";
let delete_url = "admin/rooms/delete/";
let accept_url = "admin/application/accept/";
let reject_url = "admin/application/reject/";
let filter_url = "admin/filter";
let add_url = "admin/rooms/add";
let edit_url = "admin/rooms/edit";

// Формируем опции отправки для помещений
let rooms_options = {
    method: 'GET',
};

// Формируем опции отправки POST запроса
let post_options = {
    method: 'POST',
};

// Заголовки для таблицы с помещениями
const rooms_table_headers = ["ID", "НАЗВАНИЕ", "АДРЕС", "ИНФОРМАЦИЯ", "ИЗОБРАЖЕНИЕ", "РЕДАКТИРОВАНИЕ"]

// Заголовки для таблицы с заявками
const applications_table_headers = ["ID", "ДАТА БРОНИ", "ВРЕМЯ", "ФИО", "ТЕЛЕФОН", "ПОМЕЩЕНИЕ/АДРЕС", "ДАТА ЗАЯВКИ", "СТАТУС"]

// При загрузке HTML вызываем основную логику
async function onLoad() {

    // Добавляем логику на кнопки
    addFiltersLogic();

    // Обновляем список запросов
    fetchApplications();

    // Обновляем список помещение
    fetchRooms();

    // Добавляем логику на форму добавления
    addAddingFormLogic();

    // Добавляем логику на форму Редактирования
    addEditFormLogic();
}

// Добавляем логику для кнопок
// СЕГОДНЯ, НЕДЕЛЯ, МЕСЯЦ, ВСЁ ВРЕМЯ, ПРИМЕНИТЬ, ОТЧИСТИТЬ
function addFiltersLogic() {
    
    // Получаем список с временными отрезками
    // [СЕГОДНЯ, НЕДЕЛЯ, МЕСЯЦ, ВСЁ ВРЕМЯ]
    let time_buttons = document.querySelectorAll(".buttime");

    // Приводим логику для каждой кнопки
    for (let time_button of time_buttons) {

        // Вешаем событие нажатия на кнопку в с временным отрезком
        time_button.addEventListener("click", function() {

            // Отчищаем все кнопки при нажатии
            document.querySelectorAll(".buttime").forEach(function (elem) {
                elem.classList.remove("selected");
            });

            // Подчёркиваем выбранную кнопку
            time_button.classList.add("selected");

            // Обновляем список заявок
            fetchApplications();
        });
    }

    // Вешаем обновление списка при нажатии на кнопку ПРИМЕНИТЬ
    document.querySelector("#apply_filter").addEventListener("click", fetchApplications);

    // Вешаем сброс фильтров и обновление при нажатии на кнопку ОТЧИСТИТЬ
    document.querySelector("#nullify_filter").addEventListener("click", function() {
        
        // Получаем все элементы блока фильтра
        let filters = getFilterElements();
        
        // Сбрасываем каждое поле фильтрации
        filters['phone'].value = "";
        filters['fullname'].value = "";
        filters['booking_date'].value = "";
        filters['application_date'].value = "";
        filters['approved'].value = "";
        filters['address'].value="";

        // Обновляем список заявок
        fetchApplications();
    });
}

// Добавляем логику для формы добавления помещения
// ДОБАВИТЬ
function addAddingFormLogic() {

    // Вешаем вызов формы добавления при нажатии на кнопку ДОБАВИТЬ
    document.querySelector("#add_room_button").addEventListener("click", function() {
        document.querySelector("#back_form").classList.remove("none");

        // Добавляем в поле адрес значение выбранного адреса, если тот выбран
        let selected_button = document.querySelector(".addresses button.selected");
        if (selected_button != null){
            document.querySelector(".groupformstep div input[name='address']").value = selected_button.innerHTML;
        }
    });

    // Вешаем логику на кнопку ДОБАВИТЬ на форме 
    document.querySelector("#add_room_form_button").addEventListener("click", async function() {
        // Выгружаем входные данные
        let inputs = [
            document.querySelector("input[name='name']"), 
            document.querySelector("input[name='address']"), 
            document.querySelector("input[name='description']"), 
            document.querySelector("input[name='image']")
        ];

        // Проверяем валидацию всех полей
        for (let input of inputs) {
            if (!input.checkValidity()) {
                return;
            }
        }

        // Формируем отправляемые данные
        let formData = new FormData(document.querySelector("#application_form"));
        let options = {
            method: 'POST',
            body: formData
        };

        // Отправляем запрос на добавление данных в базу
        let response = await fetch(add_url, options);
        let result = await response.text();

        // TODO: обработать результат и вывести его пользователю

        // Обновляем список помещений
        fetchRooms();

        // Отчищаем входные данные
        document.querySelector("input[name='name']").value = "";
        document.querySelector("input[name='address']").value = "";
        document.querySelector("input[name='description']").value = "";
        document.querySelector("input[name='image']").value = "";

        // Скрываем форму добавления
        document.querySelector("#back_form").classList.add("none");
    });
    
    // При нажатии на кнопку закрыть - Скрываем и отчищаем форму
    document.querySelector('#close').addEventListener("click", function(e) {
        document.querySelector('#back_form').classList.add("none");
        
        // Отчищаем входные данные
        document.querySelector("input[name='name']").value = "";
        document.querySelector("input[name='address']").value = "";
        document.querySelector("input[name='description']").value = "";
        document.querySelector("input[name='image']").value = "";
    });
}

// Добавляем логику для формы изменения помещения
// ИЗМЕНИТЬ
function addEditFormLogic() {
    
    // Получаем форму изменения
    let edit_form = document.querySelector("#edit_form");

    // Вешаем вызов формы добавления при нажатии на кнопку ИЗМЕНИТЬ
    document.querySelector("#edit_room_form_button").addEventListener("click", async function() {
        // Выгружаем входные данные
        let inputs = [
            edit_form.querySelector("input[name='name']"), 
            edit_form.querySelector("input[name='address']"), 
            edit_form.querySelector("input[name='description']"), 
            edit_form.querySelector("input[name='image']")
        ];

        // Проверяем валидацию всех полей
        for (let input of inputs) {
            if (!input.checkValidity()) {
                return;
            }
        }

        // Формируем отправляемые данные
        let formData = new FormData(document.querySelector("#edit_form"));
        let options = {
            method: 'POST',
            body: formData
        };

        // Отправляем запрос на добавление данных в базу
        let response = await fetch(edit_url, options);
        let result = await response.text();

        // TODO: обработать результат и вывести его пользователю
        
        // Обновляем список помещений
        fetchRooms();

        // Скрываем форму редактирования
        document.querySelector("#edit_back_form").classList.add("none");
    });
    
    // Скрываем форму редактирования при нажатии на кнопку закрыть
    document.querySelector('#edit_close').addEventListener("click", function(e) {
        document.querySelector('#edit_back_form').classList.add("none");
    });
}

// Создаём элемент перечисления "Все" и настраиваем его
function getAllOption(){
    let address_all_option = document.createElement("option");
    address_all_option.textContent = "Все";
    address_all_option.value = "";

    return address_all_option;
}

// Создаём элемент перечисления "Помещение" и настраиваем его
function getAddressOption(address) {
    let address_option = document.createElement("option")
    address_option.textContent = address;
    address_option.value = address;

    return address_option;
}

// Создаём, настраиваем и возвращаем кнопку с названием адреса
function getAddressTabButton(address) {
    let button = document.createElement("button");
    button.textContent = address;
    button.classList.add("tab");

    // Обрабатываем событие нажатия кнопку с адресом
    button.addEventListener("click", function() {

        // При повторном нажатии показываем все элементы таблицы
        if (this.classList.contains("selected")) {

            // Скрываем каждую строку таблицы, кроме строки с заголовками 
            document.querySelectorAll("#rooms_table tr:not(.namerow)").forEach( function(row) {
                row.classList.remove("none");
            });

            // Отчищаем выделение
            this.classList.remove("selected");

            return;
        }

        // Отчищаем выделение
        document.querySelectorAll(".tab").forEach(function(elem) {
            elem.classList.remove("selected");
        });

        // Добавляем выделение на нажатую кнопку
        button.classList.add("selected");

        // Скрываем каждую строку таблицы, кроме строки с заголовками 
        document.querySelectorAll("#rooms_table tr:not(.namerow)").forEach( function(row) {
            row.classList.add("none");
        });

        // Показываем все строки таблицы, соответсвующие выбранному адресу
        document.querySelectorAll(`#rooms_table tr[data-address='${address}']:not(.namerow)`).forEach( function(row) {
            row.classList.remove("none")
        });
    });

    return button;
}

// Получаем элемент содрежащий адреса, отчищаем, настраиваем и возращаем его
function getAddressFilter(){
    let address_filter = document.querySelector("select[name='address']");
    address_filter.innerHTML = "";
    address_filter.append(getAllOption());

    return address_filter;
}

// Формируем заголовки для таблицы
function generateHeadersWith(table_headers){

    // Создаём элемент строки заголовков таблицы
    let namerow = document.createElement("tr");

    // Помечаем элемент строки, как заголовок
    namerow.classList.add("namerow");

    // Заполняем строку заголовков данными
    namerow.append(...table_headers.map(function(header) {
        let th_elem = document.createElement("th");
        th_elem.textContent = header;

        return th_elem;
    }));

    return namerow;
}

// Формируем массив элементов фильтра
function getFilterElements(){
    return {
        'phone' : document.querySelector("input[name='phone']"),
        'fullname' : document.querySelector("input[name='fullname']"),
        'booking_date' : document.querySelector("input[name='booking_date']"),
        'application_date' : document.querySelector("input[name='application_date']"),
        'approved' : document.querySelector("select[name='approved']"),
        'address' : document.querySelector("select[name='address']"),
    };
}

// Обновляем таблицу заявок
async function fetchApplications() {

    // Выгружаем данные из фильтров
    let filters = getFilterElements();

    // Выгружаем временной отрезок
    let time_interval = document.querySelector(".buttime.selected")

    // Формируем отправяемые данные
    let formData = new FormData();
    formData.append("phone", filters['phone'].value);
    formData.append("fullname", filters['fullname'].value);
    formData.append("booking_date", filters['booking_date'].value);
    formData.append("application_date", filters['application_date'].value);
    formData.append("approved", filters['approved'].value);
    formData.append("address", filters['address'].value);
    formData.append("time_interval", time_interval.value);
    let application_options = {
        method: 'POST',
        body: formData,
    };

    // Список всех запросов удовлетворяющих фильтру
    let response = await fetch(filter_url, application_options);
    let result = await response.text();
    let applications = JSON.parse(result);

    // Получаем элемент таблицы для заявок
    let table_body = document.querySelector("#applications_table tbody");

    // Отчищаем таблицу от данных
    table_body.innerHTML = "";

    // Формируем заголовки для таблицы
    let namerow = generateHeadersWith(applications_table_headers);

    // Добавляем заголовки в таблицу
    table_body.append(namerow);

    // Пробегаемся по каждой заявке
    for (let application of applications) {
            // Создаём строку
            let table_row = document.createElement("tr");

            // Создаём ячейки для всех данных
            let id = document.createElement("td");
            let booking_date = document.createElement("td");
            let booking_time = document.createElement("td");
            let fullname = document.createElement("td");
            let phone = document.createElement("td");
            let room_and_address = document.createElement("td");
            let application_date = document.createElement("td");
            let status = document.createElement("td");
            
            // Заполняем таблицу данными
            id.textContent = application.id;
            booking_date.textContent = application.booking_date;
            booking_time.textContent = application.booking_start + " - " + application.booking_end;
            fullname.textContent = application.fullname;
            phone.textContent = application.phone;
            room_and_address.textContent = application.name + ", " + application.address;
            application_date.textContent = application.created_at;
            
            // Если заявка не просмотрена
            if (application.approved == "0") {

                // Формируем кнопку отклонить
                let button_reject = document.createElement("button");
                button_reject.classList.add("reject");

                // Формируем кнопку принять
                let button_accept = document.createElement("button");
                button_accept.classList.add("accept");

                // Формируем изображение отклонить
                let reject_image = document.createElement("img");
                reject_image.src = "img/reject_image.png";

                // Формируем изображение принять
                let accept_image = document.createElement("img");
                accept_image.src = "img/accept_image.png";                

                // Добавляем изображения на кнопки
                button_reject.append(reject_image);
                button_accept.append(accept_image);
                
                // Вешаем событие нажатия на кнопку отменить
                button_reject.addEventListener("click", async function() {
                    await fetch(reject_url + application.id, post_options);
                    fetchApplications();
                });

                // Вешаем событие нажатия на кнопки принять
                button_accept.addEventListener("click", async function() {
                    await fetch(accept_url + application.id, post_options);
                    fetchApplications();
                });

                // Добавляем кнопки в статус
                status.append(button_reject, button_accept);
            }
            
            // Если заявка принята
            if (application.approved == "1") {
                let reject_image = document.createElement("img");
                reject_image.src = "img/reject_image.png";
                reject_image.classList.add("reject");
        
                status.append(reject_image);
            }

            // Если заявка отклонена
            if (application.approved == "2") {
                let accept_image = document.createElement("img");
                accept_image.src = "img/accept_image.png";
                accept_image.classList.add("accept");

                status.append(accept_image);
            }

            // Добавляем данные в таблицу
            table_row.append(id, booking_date, booking_time, fullname, phone, room_and_address, application_date, status);
            table_body.append(table_row);
    }
}

// Обновляем таблицу Помещений
async function fetchRooms() {

    // Список всех помещений
    let response = await fetch(rooms_url, rooms_options);
    let result = await response.text();
    let rooms = JSON.parse(result);
    
    // Формируем массив адресов
    let addresses = [];
    for (let room of rooms) {
        if (!addresses.includes(room.address)) {
            addresses.push(room.address);
        }
    }

    // Фильтр по адресу
    let address_filter = getAddressFilter();
    
    // Получаем блок для списка адресов
    let address_block = document.querySelector(".addresses")
    address_block.innerHTML = "";

    // Для каждого адреса создаём варинат фильтрации и кнопку выбора
    for (let address of addresses) {

        // Создаём вариант фильтрации
        address_filter.append(getAddressOption(address));
        
        // Добавляем кнопку с адресом в блок адресов
        address_block.appendChild(getAddressTabButton(address));
    }

    // Получаем тело таблицы для помещений и отчищаем его
    let table_body = document.querySelector("#rooms_table tbody");
    table_body.innerHTML = "";

    // Создаём строку таблицы с заголовками
    let namerow = generateHeadersWith(rooms_table_headers);

    // Добавляем заголовки в таблицы
    table_body.append(namerow);

    // Пробегаемся по каждому помещению
    for (let room of rooms) {

        // Формируем строку данныъ
        let row = document.createElement("tr");
        row.dataset.address = room.address;

        // Создаём ячейки для всех данных
        let id = document.createElement("td");
        let name = document.createElement("td");
        let address = document.createElement("td");
        let description = document.createElement("td");
        let image = document.createElement("td");
        let editing = document.createElement("td");
        
        // Заполняем таблицу данными
        id.textContent = room.id;
        name.textContent = room.name;
        address.textContent = room.address;
        description.textContent = room.description;
        
        // Формируем изображение помещения
        let room_image = document.createElement("img");
        room_image.src = room.image;

        // Формируем кнопку редактирования
        let button_edit = document.createElement("button");
        button_edit.classList.add("edit");
        
        // Формируем кнопку удаления
        let button_delete = document.createElement("button");
        button_delete.classList.add("delete");

        // Формируем изображение редактирования
        let edit_image = document.createElement("img");
        edit_image.src = "img/edit_image.png"; 

        // Формируем изображение удалить
        let delete_image = document.createElement("img");
        delete_image.src = "img/delete_image.png";

        // Добавляем изображения на кнопки 
        button_delete.append(delete_image);
        button_edit.append(edit_image);

        // Добавляем событие нажатия на кнопку удалить
        button_delete.addEventListener("click", async function() {
            let response = await fetch(delete_url + room.id, post_options);
            let result = await response.text();
            
            // TODO: Сделать потверждение на удаления
            // TODO: Вывести результат удаления

            // Обновляем таблицу помещений
            fetchRooms();
        });

        // Добавляем событие нажатия на кнопку редактирования
        button_edit.addEventListener("click", function() {
            // Заполняем поля формы редактирования
            document.querySelector("#edit_back_form [name='id']").value = id.textContent;
            document.querySelector("#edit_back_form [name='name']").value = name.textContent;
            document.querySelector("#edit_back_form [name='address']").value = address.textContent;
            document.querySelector("#edit_back_form [name='description']").value = description.textContent;

            // Показываем форму для редактирования
            document.querySelector("#edit_back_form").classList.remove("none");
        });

        // Заполняем ячейку с изображением
        image.append(room_image);

        // Заполняем ячейку с управлением
        editing.append(button_delete, button_edit);

        // Заполняем оставшиеся ячейки
        row.append(id, name, address, description, image, editing);

        // Добавляем строку в таблицу
        table_body.append(row);
    }
}