let url = "application/post";

// Формируем вариант брони
function createOption(value) {
    let option = document.createElement("option");
    option.value = value;
    option.textContent = value + ":00";

    return option;
}

function generateOptions(busy_beginings, busy_endings) {
    // if (busy_beginings == null || busy_endings == null)
    //     return alert('К сожалению сегодня уже нельзя забронировать помещения.');
    
    let begin_select = document.querySelector(".timebegin");
    let end_select = document.querySelector(".timeend");

    // Отчищаем выбор
    begin_select.innerHTML = "";
    end_select.innerHTML = "";

    // Заполняем опции
    for (let i = 14; i <= 21; i++) {

        // Добавялем свободны опции
        if (!busy_beginings.includes(i)) {
            begin_select.append(createOption(i));
        }

        // Добавляем занятые опции
        if (!busy_endings.includes(i)) {
            end_select.append(createOption(i))
        }
    }
}

// Получаем занятые варианты
function getBusyOptions(begin, end) {
    if (begin == undefined)
        begin = 14;

    // Массив занятых опций
    let busy_beginings = [21];
    let busy_endings = [14];

    // Время в часах сегодня
    var today = (new Date()).getHours();
    var today_day = (new Date()).getDate();
    var booking_day = Number(document.getElementById('booking_date_id').innerText.substring(0,2));

    // Проверяем выбранные даты
    if (today_day == booking_day) {
        if (today >= 20)
            return null;

        // Исключаем запись на прошедшее время
        let i = 14;
        for (i; i <= today; i++){
            busy_beginings.push(i);
            busy_endings.push(i);
        }
        busy_endings.push(i);
    }

    // Исключаем не корректную бронь
    if (begin != undefined) {
        for (let i = 14; i <= begin; i++) {
            busy_endings.push(i);
        }
    }

    // Исключаем не корректную бронь
    // if (end != undefined) {
    //     for (let i = end; i < 21; i++) {
    //         busy_beginings.push(i);
    //     }
    // }

    // Исключаем не корректную бронь
    for (let e of window.current_events) {
        
        if (begin != undefined && begin < e.start) {
            for (let i = e.start+1; i <= 21; i++) {
                busy_endings.push(i);
            }
        }

        // if (end != undefined && end > e.end) {
        //     for (let i = 14; i < e.end; i++) {
        //         busy_beginings.push(i);
        //     }
        // }

        for (let i = e.start; i <= e.end; i++) {
            if (i != e.end) {
                busy_beginings.push(i)
            }

            if (i != e.start) {
                busy_endings.push(i);
            }
        }
    }
    
    return [busy_beginings, busy_endings];
}


document.addEventListener("DOMContentLoaded", function() {

    // Отслеживаем нажатие на кнопку ЗАБРОНИРОВАТЬ
    document.querySelector('.order').addEventListener("click", function(){

        // Проверяем, что дата была выбрана
        if (!document.querySelector('.calendarev-day-selected')) {
            alert('Выберите дату');
            return;
        }
        
        // Формируем даты 
        let date = new Date();
        let now = new Date();

        // Заполняем даты
        date.setDate(+document.querySelector('.calendarev-day-selected').innerText);
        date.setMonth(+document.querySelector('.calendarev-month').value);
        date.setFullYear(+document.querySelector('.calendarev-years').value);
        now.setHours(0);

        // Проверка на выбранную дату
        if (now > date) {
            alert("Вы не можете записаться на прошедший день");
            return;
        }
        
        document.querySelector('#booking').classList.remove("none");
        document.querySelector('.dateform').append(date.toLocaleDateString());
        
        generateOptions(...getBusyOptions());
    });

    // Вешаем события изменения на выбор начального времени
    document.querySelector(".timebegin").addEventListener("change", function() {

        // Выбираем 
        let begin_option = document.querySelector(".timebegin");
        let end_option = document.querySelector(".timeend");

        let begin_value = +begin_option.value;
        let end_value = +end_option.value;

        generateOptions(...getBusyOptions(begin_value));


        if (document.querySelector(`.timeend option[value='${end_value}']`)) {
            end_option.value = end_value;
        }
        begin_option.value = begin_value;

    });

    document.querySelector(".timeend").addEventListener("change", function() {
        let begin_option = document.querySelector(".timebegin");
        let end_option = document.querySelector(".timeend");

        let begin_value = +begin_option.value;
        let end_value = +end_option.value;

        generateOptions(...getBusyOptions(begin_value, end_value));


        if (document.querySelector(`.timebegin option[value='${begin_value}']`)) {
            begin_option.value = begin_value;
        }
        end_option.value = end_value;

    });


    document.querySelector('#close').addEventListener("click", function(e) {
        document.querySelector('#booking').classList.add("none");
        document.querySelector('.dateform').innerHTML = '';
    });


    document.querySelector("#application_form").addEventListener("formdata", function(event) {
        const formData = event.formData;
        formData.append("application_date", toDateString(new Date()));
        formData.append("id_room", window.current_room_id);
        
        // Формируем временные данные
        formData.append("booking_date", document.querySelector('.dateform').innerText);
        formData.set("booking_start", formData.get("booking_start") + ":00");
        formData.set("booking_end", formData.get("booking_end") + ":00");
    });

    document.querySelector("#application_form").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(document.querySelector("#application_form"));

        // Формируем отправляемые данные
        let options = {
            method: "POST",
            body: formData,
        };

        // Отправляем запрос на сервер
        fetch(url, options)
            .then(response => response.json())
            .then(answer => {

                // Выводим результат на экран
                if (answer['success'] == undefined)
                    return alert(answer['fail']);         
                
                document.querySelector('#booking').classList.add("none");
                document.querySelector('.dateform').innerHTML = '';
                return alert(answer['success']);
            });

        return false;
    });
});

function toDateString(date) {
    let result = "";

    function beautify(number) {
        if (number < 10) {
            return "0" + number;
        } else {
            return number;
        }
    }

    result +=  beautify(date.getDate()) + "." + beautify(date.getMonth() + 1) + "." + date.getFullYear() +" "+ date.getHours() + ":" + beautify(date.getMinutes());
    return result;
}