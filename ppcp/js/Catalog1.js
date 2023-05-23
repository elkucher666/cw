$(document).ready(Catalog);

function Catalog (){
    title = ['КУРЧАТОВА', 'ГОГОЛЯ', 'ГОЛАНДИЯ'];
    content = ['Яшмовый пляж', 'Мраморное озеро', 'Яшмовый пляж'];
    rooms = [['КУРЧАТОВА','img/room1.jpg', 'АУДИТОРИЯ №1', 'Площадь: 20м'],
            ['ГОГОЛЯ','img/room1.jpg', 'АУДИТОРИЯ №3', 'Площадь: 60м'],
            ['ГОГОЛЯ','img/room2.jpg', 'АУДИТОРИЯ №4', 'Площадь: 60м'],
            ['КУРЧАТОВА','img/room2.jpg', 'АУДИТОРИЯ №2', 'Площадь: 60м'],
            ['ГОЛАНДИЯ','img/room2.jpg', 'АУДИТОРИЯ №6', 'Площадь: 45м'],
            ['ГОГОЛЯ','img/room1.jpg', 'АУДИТОРИЯ №5', 'Площадь: 60м']];
    first = [];
    var last = new Array(title.length);
    n = 0;
    console.log(last);
    
    for (i = 0; i < last.length; i++){
        last[i] = new Array(2);
        last[i][0] = title[i]
    }
    for (i = 0; i < rooms.length; i++){
        street = rooms[i][0];
    }
    console.log(last);




    k = 0;

    for (i = 0; i < title.length; i++){
        var but = jQuery('<button>', {
            class: 'tablink',
            onclick: 'openPage("' + title[i] + '", this)'
        }).get(0);
        but.textContent = title[i];
        $('#menustreet').get(0).appendChild(but);
        if (k == 0){
            $('button').attr({id: 'defaultOpen'});
            k++;
        }
    }
    for (i = 0; i < title.length; i++){
        var listroom = jQuery('<div>', {
            id: title[i],
            class: 'tabcontent'
        }).get(0);
        //listroom.textContent = content[i];
        $('.contentstreet').get(0).appendChild(listroom);
        if (k == 1){
            $(".tabcontent").attr('style', 'display: flex');
            k++;
        }
    }

    for (i = 0; i < rooms.length; i++){
        var room = jQuery('<div>', {
            id: 'room' + i,
            class: "room"
        }).get(0);
        var picture = jQuery('<img>', {
            src: rooms[i][1]
        }).get(0);
        var namAudit = jQuery('<div>', {
            id: "nameroom" + i,
            class: "nameroom"
        }).get(0);
        namAudit.textContent = rooms[i][2];
        var paramAudit = jQuery('<div>', {
            id: "parametroom" + i,
            class: "parametroom"
        }).get(0);
        paramAudit.textContent = rooms[i][3];
        room.appendChild(picture);
        room.appendChild(namAudit);
        room.appendChild(paramAudit);
        
        document.getElementById(rooms[i][0]).appendChild(room);
        if (!(first.includes(rooms[i][0]))){
            document.getElementById('room' + i).style.marginLeft = "34vw";
            first.push(rooms[i][0]);
        }
        for(j = 0; j < title.length; j++){
            if(last[j][0] == rooms[i][0]){
                console.log(i,j);
                last[j][1] = i; 
            }
        }

    }
    for(i = 0; i < last.length; i++){
        document.getElementById('room' + last[i][1]).style.marginRight = "22vw";
    }
}
function openPage(pageName,elmnt){
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++){
        tabcontent[i].style.display = 'none';
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i ++){
        tablinks[i].style.borderBottom = 'thick solid #ffffff';
    }
    document.getElementById(pageName).style.display = 'flex';
    elmnt.style.borderBottom = 'thick solid #C9404A';
}