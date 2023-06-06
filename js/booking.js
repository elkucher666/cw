function createOption(value) {
    let result = document.createElement("option");
    result.value = value;
    result.textContent = value + ":00";

    return result;
}

function generateOptions(busy_beginings, busy_endings) {
    let begin_select = document.querySelector(".timebegin");
    let end_select = document.querySelector(".timeend");

    begin_select.innerHTML = "";
    end_select.innerHTML = "";

    for (let i = 14; i <= 21; i++) {
        if (!busy_beginings.includes(i)) {
            begin_select.append(createOption(i));
        }

        if (!busy_endings.includes(i)) {
            end_select.append(createOption(i))
        }
    }
}

function getBusyOptions(begin, end) {
    let busy_beginings = [21];
    let busy_endings = [14];

    if (begin != undefined) {
        for (let i = 14; i <= begin; i++) {
            busy_endings.push(i);
        }
    }

    if (end != undefined) {
        for (let i = end; i < 21; i++) {
            busy_beginings.push(i);
        }
    }


    for (let event of window.current_events) {
        if (begin != undefined && begin < event.start) {
            for (let i = event.start+1; i <= 21; i++) {
                busy_endings.push(i);
            }
        }

        if (end != undefined && end > event.end) {
            for (let i = 14; i < event.end; i++) {
                busy_beginings.push(i);
            }
        }



        for (let i = event.start; i <= event.end; i++) {
            if (i != event.end) {
                busy_beginings.push(i)
            }

            if (i != event.start) {
                busy_endings.push(i);
            }
        }
    }

    return [busy_beginings, busy_endings];
}


document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('.order').addEventListener("click", function(e){
        if (document.querySelector('.calendarev-day-selected')) {
            let day = document.querySelector('.calendarev-day-selected').innerText;
            let month = document.querySelector('.calendarev-month').value + 1;
            let year = document.querySelector('.calendarev-years').value;
            
            day = (day < 10) ? "0" + day : day;
            month = (month < 10) ? "0" + month : month;

            date = day + '.' + month + '.' + year;

            if (new Date() > new Date(date)) {
                alert("Вы не можете записаться на прошедший день");
                return;
            }
            
            document.querySelector('#booking').classList.remove("none");
            document.querySelector('.dateform').append(date);
        } else {
            alert('Выберите дату');
            return
        }

        generateOptions(...getBusyOptions());
    });

    document.querySelector(".timebegin").addEventListener("change", function() {
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

        generateOptions(...getBusyOptions(null, end_value));


        if (document.querySelector(`.timebegin option[value='${begin_value}']`)) {
            begin_option.value = begin_value;
        }
        end_option.value = end_value;


        // if (begin_value >= end_value) {
        //     let new_begin = +end_value - 1;
        //     while (document.querySelector(`.timebegin option[value='${new_begin}']`)?.classList.contains("none") == true) {
        //         new_begin--;    
        //     }

        //     document.querySelector(".timebegin").value = new_begin;
        // }
    });


    document.querySelector('#close').addEventListener("click", function(e) {
        document.querySelector('#booking').classList.add("none");
        document.querySelector('.dateform').innerHTML = '';
    });
});  