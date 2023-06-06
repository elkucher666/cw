document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('.order').addEventListener("click", function(e){
        if (document.querySelector('.calendarev-day-selected')) {
            let day = document.querySelector('.calendarev-day-selected').innerText;
            let month = document.querySelector('.calendarev-month').value;
            let year = document.querySelector('.calendarev-years').value;
            month++;
            
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
        }
        
    });

    document.querySelector(".timebegin").addEventListener("change", function() {
        selectbeg = document.querySelector(".timebegin").value;
        selectend = document.querySelector(".timeend").value;
        if (selectbeg > selectend) {
            document.querySelector(".timeend").value = selectbeg;
        }

    });

    document.querySelector(".timeend").addEventListener("change", function() {
        selectbeg = document.querySelector(".timebegin").value;
        selectend = document.querySelector(".timeend").value;
        if (selectbeg > selectend) {
            document.querySelector(".timebegin").value = selectend;
        }
    });


    document.querySelector('#close').addEventListener("click", function(e) {
        document.querySelector('#booking').classList.add("none");
        document.querySelector('.dataform').innerHTML = '';
    });
});  



function isFree() {
    
}