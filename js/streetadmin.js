document.addEventListener("DOMContentLoaded", onLoad);

async function onLoad() {

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
        });
    }


    let time_buttons = document.querySelectorAll(".buttime");

    for (let time_button of time_buttons) {
        time_button.addEventListener("click", function() {
            document.querySelectorAll(".buttime").forEach(function (elem) {
                elem.classList.remove("selected");
            });
            time_button.classList.add("selected");
            
        });
    }


    document.querySelector("#apply_filter").addEventListener("click", fetchApplications);
    document.querySelectorAll(".buttime").forEach(function (button) {
        button.addEventListener("click", fetchApplications);
    });

    fetchApplications();
    
}

async function fetchApplications() {
    let phone = document.querySelector("input[name='phone']");
    let fullname = document.querySelector("input[name='fullname']");

    let time_interval = document.querySelector(".buttime.selected")

    if (phone.reportValidity() && fullname.reportValidity()) {
        let booking_date = document.querySelector("input[name='booking_date']");
        let application_date = document.querySelector("input[name='application_date']");
        let approved = document.querySelector("select[name='approved']");
        let address = document.querySelector("select[name='address']");

        let formData = new FormData();

        formData.append("phone", phone.value);
        formData.append("fullname", fullname.value);
        formData.append("booking_date", booking_date.value);
        formData.append("application_date", application_date.value);
        formData.append("approved", approved.value);
        formData.append("address", address.value);
        formData.append("time_interval", time_interval.value);

        let response = await fetch('./../queries/get_filtered_application.php', {
            method: 'POST',
            body: formData
        });

        let result = await response.text();
        let applications = JSON.parse(result);


        let table_body = document.querySelector(".aplication tbody");
        table_body.innerHTML = "";

        let namerow = document.createElement("tr");
        namerow.classList.add("namerow");


        let table_headers = ["Id", "ДАТА БРОНИ", "ВРЕМЯ", "ФИО", "ТЕЛЕФОН", "ПОМЕЩЕНИЕ/АДРЕС", "ДАТА ЗАЯВКИ", "СТАТУС"]
        
        namerow.append(...table_headers.map(function(header) {
            let header_element = document.createElement("th");
            header_element.textContent = header;
            return header_element;
        }));

        table_body.append(namerow);


        let i = 1;
        for (let application of applications) {
            let table_row = document.createElement("tr");

            let id = document.createElement("td");
            let booking_date = document.createElement("td");
            let booking_time = document.createElement("td");
            let fullname = document.createElement("td");
            let phone = document.createElement("td");
            let room_and_address = document.createElement("td");
            let application_date = document.createElement("td");
            let status = document.createElement("td");
            
            
            
            id.textContent = application.id;
            booking_date.textContent = application.booking_date;
            booking_time.textContent = application.booking_start + " - " + application.booking_end;
            fullname.textContent = application.fullname;
            phone.textContent = application.phone;
            room_and_address.textContent = application.name + ", " + application.address;
            application_date.textContent = application.application_date;
            
            if (application.approved == "2") {
                let formData = new FormData();
                formData.append("id", application.id);

                let button_reject = document.createElement("button");
                button_reject.classList.add("reject");
                let reject_image = document.createElement("img");
                reject_image.src = "./../img/reject_image.png";

                let button_accept = document.createElement("button");
                button_accept.classList.add("accept");
                let accept_image = document.createElement("img");
                accept_image.src = "./../img/accept_image.png";                

                button_reject.append(reject_image);
                button_accept.append(accept_image);

                button_reject.addEventListener("click", async function() {
                    await fetch('./../queries/reject.php', {
                        method: 'POST',
                        body: formData
                    });
                    fetchApplications();
                });

                button_accept.addEventListener("click", async function() {
                    await fetch('./../queries/accept.php', {
                        method: 'POST',
                        body: formData
                    });
                    fetchApplications();
                });

                status.append(button_reject, button_accept);
            }

            if (application.approved == "1") {
                let accept_image = document.createElement("img");
                accept_image.src = "./../img/accept_image.png";
                accept_image.classList.add("accept");

                status.append(accept_image);
            }

            if (application.approved == "0") {
                let reject_image = document.createElement("img");
                reject_image.src = "./../img/reject_image.png";
                reject_image.classList.add("reject");

                status.append(reject_image);
            }


            table_row.append(id, booking_date, booking_time, fullname, phone, room_and_address, application_date, status)
            table_body.append(table_row);
        }
    }
}
