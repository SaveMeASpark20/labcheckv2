<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Labcheck</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <script> 
    var calendarVisible = false; 
        var currentButton = null;
        var selectedRoom = null;

        $(document).ready(function () {
            $('#room205Button').click(function () {
                if (currentButton !== this) {
                    destroyCalendar(); // Destroy the current calendar instance
                    toggleButton(this);
                    selectedRoom = 205;
                    console.log(selectedRoom);
                    initializeCalendar('includes/comlabSched_load.php?room=205');
                    fetchLatestPdf();
                }
            });

            $('#room206Button').click(function () {
                if (currentButton !== this) {
                    destroyCalendar(); // Destroy the current calendar instance
                    toggleButton(this);
                    selectedRoom = 206;
                    console.log(selectedRoom);
                    initializeCalendar('includes/comlabSched_load.php?room=206');
                    fetchLatestPdf();
                }
            });

            function updateRoomScheduleDisplay() {
                if (calendarVisible) {
                    $('#room_schedule').css('display', 'block');
                } else {
                    $('#room_schedule').css('display', 'none');
                }
            }

            function toggleButton(button) {
                if (currentButton) {
                    $(currentButton).removeClass('active-button');
                }
                $(button).addClass('active-button');
                currentButton = button;
            }

            function destroyCalendar() {
                if (calendarVisible) {
                    $('#calendar').fullCalendar('destroy'); // Destroy the existing calendar
                    $('#calendar').hide(); // Hide the calendar
                    calendarVisible = false;
                    updateRoomScheduleDisplay();
                }
            }
            function initializeCalendar(sourceUrl) {
                $.ajax({
                    url: sourceUrl,
                    type: 'GET',
                    success: function (events) {
                        const decodedJSON = decodeURIComponent(events);
                        const parsedObject = JSON.parse(decodedJSON);
                        $('#calendar').show();
                        calendarVisible = true;
                        updateRoomScheduleDisplay();

                        var calendar = $('#calendar').fullCalendar({
                            header: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'month,agendaWeek,agendaDay'
                            },
                            events: parsedObject,
                        })
                    }
                })    
            }      
        })

</script>
    
  <script src="main.js" defer></script>
  <style>
        #calendar {
            display: none;
            width: 100%;
        }

        #room_schedule {
            display: none;
        }
        
        #room_schedule iframe {
            width: 500px;
            height: 500px

        }

        #room205Button, #room206Button {
            padding: 5px;
            border: none;
            border-radius: 10px
        }


        .container {
            padding: 0;
            margin: 0;
        }
        .calendar-roomsched {
            display: flex;
            gap: 10px;        
        }

        .active-button {
            background-color: green; 
            color: white; 
        }
        .fc-center h2{
            font-size: clamp(0.5rem, 3vw, 2.5rem);
        }

        .fc button {
            padding: 0 2px;
        }
        .fc table {
            overflow: auto !important;
        }
        #calendar {
            overflow: scroll;
        }

        .fc-view-container {
            overflow: auto;
        }
        
        ul {
            padding: 0;
            margin: 0;
        }

        .navbar {
            padding: 0;
            margin: 0;
        }

        @media (min-width: 1200px) {
            .container {
                width: 100%;
            }
        }

        @media (max-width: 1000px){
            .calendar-roomsched {
                flex-direction: column;
            }
        }
        @media (max-width: 900px) {
            .fc-day-grid-container , .fc-time-grid-container{
                height: 400px !important;
            }
        }

        @media (max-width: 750px) {
            .fc table {
                width:500px;
            }
        }

        @media (max-width: 610px) {
                #room_schedule iframe {
                width: 350px;
                
                height: 300px
            }
        }

        @media (max-width: 440px) {
                #room_schedule iframe {
                width: 200px;
                height: 250px;
            }
        }

    </style>
  <link rel="stylesheet" href="../css/user-style.css">
  <link rel="stylesheet" href="../css/user-comlab-sched.css">
</head>
<body>
    <?php require_once "../partial/user_navbar.php" ?>
    <div class="main-content">
        <main class="complab-schedule">
            <div class="container">
                <button id="room205Button">Room 205</button>
                <button id="room206Button">Room 206</button>
                <br>
                <br>
                <div class="calendar-roomsched">
                    <div id="calendar"></div>
                    <div id="room_schedule">
                        <!-- button to update schedule (pop up for the modal) -->
                        <!-- Iframe for PDF -->
                        <iframe id="roomSchedulePdf"></iframe>
                    </div>
                </div>
            </div>
        </main>
    </div>

<script>
function fetchLatestPdf() {
    const requestBody = JSON.stringify({ selectedRoom });

    fetch("../includes/fetchLatestPdf.php", {
        method: "POST",
        body: requestBody,
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            // Handle the response data here
            if (data.pdfName !== null) {
                
                document.getElementById('roomSchedulePdf').src = `../room_schedule/${data.pdfName}`;
                
            } else {
                console.log("No data available");
            }
        })
        .catch(error => {
            // Handle errors here
            console.error("Error fetching data:", error);
        });
}


</script>

</body>
</html>
