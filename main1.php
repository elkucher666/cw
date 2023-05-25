<!DOCTYPE html>
<html>
    
<?php

/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */

require_once 'config/connect.php';

?>

    <head>
        <meta charset="utf-8">
        <title>Творческий цех</title>
        <link rel="shortcut icon" href="img/LogoWeb.png">
        <link rel="stylesheet" type="text/css" href="css/mainstyle.css">
        <!--link rel="stylesheet" type="text/css" href="css/bitroidCalendarEv.css"-->
        <!--script src="js/jquery-3.6.4.min.js"></script-->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/moment-with-locales.min.js"></script> <!-- библиотека moment-with-locales.min.js -->
        <script type="text/javascript" src="js/bitroidCalendarEv1.js"></script> <!-- плагин CalendarEvents -->
        <script src="js/Navbar.js"></script>
        <script src="js/Catalog.js"></script>
        <script src="js/Caledar.js"></script>
        <script src="js/Booking.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jura:wght@300&family=Montserrat+Alternates&display=swap" rel="stylesheet">
    </head>
    <body style="margin: 0;">
        <div class="logoline">
            <div class="Logo">
                <img class="LogoImg" src="img/MainLogo1.png">
            </div>
        </div>
        <div class="navbar">
            <div class="mySidenav" id="mySidenav"  style="width: 100px;"></div>
        </div>
        <div class="header">            
            <div class="linename">
                <div class="decor"></div>
                <div class="decor1"></div>
                <div class="name">РАСПИСАНИЕ МАСТЕРСКИХ</div>
            </div>
        </div>
        <div id="about"></div>
        <div class="content">
            <div class="hellomess">
                <div class="messege">Здраствуте, дорогие посетители!
                    <br>
                    На сайте “РАСПИСАНИ МАСТЕРСКИХ” вы можете узнать полную информацию о помещениях, а так же когда они занаты или забронировать.</div>
            </div>
            <div id="catalogstr"></div>
            <div id="catalog" class="catalog">
                <div id="menustreet" class="menustreet">
                </div>
                <div id="contentstreet" class="contentstreet">
                </div>
                <div class="worktimeroom">
                    <div id="calendar-1" class="my-class"></div>
                    <!--div class="datework" name="datework">
                        
                    </div-->
                    <div class="calendarev-events-container"></div>
                    
                </div>
            </div>
            <div id="book" class="buttons">
                <button class="search">
                    <div class="decor" style="margin: 1vw 5vw 1vw 5vw;"></div>
                    <div class="linebut">
                        <div class="namebut">НАЙТИ ПОМЕЩЕНИЕ</div>
                    </div>
                </button>
                <button class="order">
                    <div class="decor" style="margin: -1vw 6vw 1vw 15vw;"></div>
                    <div class="linebut">
                        <div class="namebut">ЗАБРОНИРОВАТЬ</div>
                    </div>
                </button>
            </div>
        </div>
        <div id="booking">
            <form action="vendor/create.php" method="post">
                <img id="close" src="img/NoBut.png">
                <div class="nameform">ФОРМА ЗАПОЛНЕНИЯ</div>
                <div class="dataform"></div>
                <div class="timeform">
                    с<select class="timebegin" name="aboba">
                        <option>14:00</option>
                        <option>15:00</option>
                        <option>16:00</option>
                        <option>17:00</option>
                        <option>18:00</option>
                        <option>19:00</option>
                        <option>20:00</option>
                    </select>
                    по<select class="timeend">
                        <option>15:00</option>
                        <option>16:00</option>
                        <option>17:00</option>
                        <option>18:00</option>
                        <option>19:00</option>
                        <option>20:00</option>
                        <option>21:00</option>
                    </select>
                </div>
                <div class="groupformstep">
                    <div class="formstep">
                        ФИО:<input id="FIO" type="text" name="fio">
                    </div>
                    <div class="formstep">
                        Возраст:<input id="Old" type="number" name="age">
                    </div>
                    <div class="formstep">
                        Институт:<input id="Univer" type="text" name="institute">
                    </div>
                    <div class="formstep">
                        Курс:<input id="Curs" type="number" name="course">
                    </div>
                    <div class="formstep">
                        Номер тел.:<input id="Phone" type="text" name="phone">
                    </div>
                    <div class="formstep">
                        Соц. сеть:<input id="socialnet" type="text" name="social_network">
                    </div>
                    <div class="formstep">
                        Назв. мастерской:<select id="Masterroom">
                            <option value="">Выберите мастерскую</option>
                            <option>Вокальная мастерская</option>
                            <option>Театральная мастерская</option>
                            <option>Хореографическая мастерская</option>
                        </select>
                    </div>
                </div>
                <button class="orderform">
                    <div class="decor" style="margin: -0.5vw 3vw 2vw 5vw;"></div>
                    <div class="linebut">                    
                        <div class="namebut" type="submit"> ЗАБРОНИРОВАТЬ</div>
                    </div>
                </button>
            </form>
        </div>



        <div class="footer">
            <div class="container">
                <div class="contactinfo">
                    КОНТАКТНАЯ ИНФОРМАЦИЯ
                    <div class="contact">
                        Служба подржки: +7 (978) 888-88-88
                        <br>
                        E-mail: TvorcheskiCheh@mail.ru
                        <br>
                        ул. Университетская 33
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>