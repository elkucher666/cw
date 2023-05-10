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
    $('#close').click(function(e){
        $('#booking').get(0).style.display = 'none';
        $('.dataform').get(0).innerHTML = '';
    });
});



