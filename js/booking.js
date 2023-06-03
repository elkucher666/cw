$(document).ready(function() {
    //
    //
    $('.order').click(function(e){
        if (document.querySelector('.calendarev-day-selected')){
            var day = document.querySelector('.calendarev-day-selected').innerText;
            var month = document.querySelector('.calendarev-month').value;
            var year = document.querySelector('.calendarev-years').value;
            month++;
            if ( day < 10){
                day = '0' + day;
            }
            if ( month < 10){
                month = '0' + month;
            }       
            $('#booking').get(0).style.display = 'flex';
            data = day + '.' + month + '.' + year;
            console.log(data);
            $('.dataform').get(0).append(data);
        }
        else{
            alert('Выберите дату');
        }
        
    });

    document.querySelector(".timebegin").addEventListener("change", function() {
        selectbeg = document.querySelector(".timebegin").value;
        selectend = document.querySelector(".timeend").value;
        if (selectbeg > selectend){
            document.querySelector(".timeend").value = selectbeg;
        }

    });

    document.querySelector(".timeend").addEventListener("change", function() {
        selectbeg = document.querySelector(".timebegin").value;
        selectend = document.querySelector(".timeend").value;
        if (selectbeg > selectend){
            document.querySelector(".timebegin").value = selectend;
        }
    });


    $('#close').click(function(e){
        $('#booking').get(0).style.display = 'none';
        $('.dataform').get(0).innerHTML = '';
    });
});



