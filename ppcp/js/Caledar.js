$(document).ready(function(){

   // календари
	$('#calendar-1').bitroidCalendarEv({
	    lang: "ru",
	    //sundayFirst: false,
	    years: "2022-2030",
	    showEventBlock: true,
	    events : [
	    	{
	    		day : "03",
	    		month : "04",
	    		year : "2023",
	    		event_description : "Вокальная мастерская",
	    		event_title : "16:00 - 18:00 Вокальная мастерская",
	    		event_body : "Уроки пения"
	    	},
	    	{
	    		day : "03",
	    		month : "04",
	    		year : "2023",
	    		event_description : "Театральная мастерская",
	    		event_title : "18:00 - 19:00 Театральная мастерская",
	    		event_body : "Уроки театра"
	    	},
	    	{
	    		day : "20",
	    		month : "04",
	    		year : "2023",
	    		event_description : "Хореографическая мастерская",
	    		event_title : "18:00 - 19:00 Хореографическая мастерская",
	    		event_body : "Уроки хореографии"
	    	}
	    ],
	    containers : {
	    	events : ".calendarev-events-container"
	    }
	});

})