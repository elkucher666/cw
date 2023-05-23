$(document).ready(Filter);

function Filter(){
    $('.filterbut').click(function(){
        var displfil = window.getComputedStyle(document.querySelector('.filtersenting'));
        if(displfil.height != '0px'){
            //$('.filtersenting').get(0).style.display = 'none';
            $('.filtersenting').get(0).style.height = '0';
            $('.filtersenting').get(0).style.padding = '0 5vw';
        }else{
            $('.filtersenting').get(0).style.height = 'max-content';
            $('.filtersenting').get(0).style.padding = '5vw';
        }
    });
    
}
