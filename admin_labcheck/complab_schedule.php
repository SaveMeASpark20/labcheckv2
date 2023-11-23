<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
}
$page = "ComLab Schedule";
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
                    initializeCalendar('complab_schedule/load.php?room=205');
                }
            });

            $('#room206Button').click(function () {
                if (currentButton !== this) {
                    destroyCalendar(); // Destroy the current calendar instance
                    toggleButton(this);
                    selectedRoom = 206;
                    console.log(selectedRoom);
                    initializeCalendar('complab_schedule/load.php?room=206');
                }
            });

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

                        var calendar = $('#calendar').fullCalendar({
                            editable: true,
                            header: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'month,agendaWeek,agendaDay'
                            },
                            events: parsedObject,
                            selectable: true,
                            selectHelper: true,
                            select: function (start, end, allDay) {
                            var title = prompt("Enter Event Title");
                                if (title) {
                                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                                    // Create an event object
                                    var data = {
                                        title: title,
                                        start: start,
                                        end: end,
                                        room: selectedRoom
                                    };

                                    // Add the event to the calendar
                                    calendar.fullCalendar('renderEvent', data);

                                    $.ajax({
                                        url: "complab_schedule/insert.php",
                                        type: "POST",
                                        data: data, // Send the event data to your server
                                        success: function (response) {
                                            alert("Added Successfully");
                                        }
                                    });
                                }
                            },                  
                            editable:true,
                            eventResize:function(event)
                            {
                                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                                var title = event.title;
                                var id = event.id;
                                
                                $.ajax({
                                    url:"complab_schedule/update.php",
                                    type:"POST",
                                    data:{title:title, start:start, end:end, id:id},
                                    success:function()
                                    {
                                        calendar.fullCalendar('refetchEvents');
                                        alert('Event Update');
                                    }
                                })
                            },

                            eventDrop:function(event)
                            {
                                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                                var title = event.title;
                                var id = event.id;
                                $.ajax({
                                    url:"complab_schedule/update.php",
                                    type:"POST",
                                    data:{title:title, start:start, end:end, id:id},
                                    success:function()
                                    {
                                        calendar.fullCalendar('refetchEvents');
                                        alert("Event Updated");
                                    }
                                });
                            },

                            eventClick: function (event) {
                            if (confirm("Are you sure you want to remove it?")) {
                                var id = event.id;
                                $.ajax({
                                    url: "complab_schedule/delete.php",
                                    type: "POST",
                                    data: { id: id },
                                    success: function () {
                                        // Remove the event from the calendar's view
                                        calendar.fullCalendar('removeEvents', id);
                                        alert("Event Removed");
                                    }
                                });
                            }
                        },
                        });
                    },
                    error: function () {
                        alert('Error loading events.');
                    }
                });
            }
        });
    </script>
    <title>Admin</title>
    <style>
        #calendar {
            display: none;
            
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
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <?php include '../partial/admin_sidebar_comlab.php' ?>
    <!-- NAVBAR -->
    <?php include '../partial/header.php' ?>

    <div class="main-content">
        <main class="complab-schedule">
            <div class="container">
                <button id="room205Button">Room 205</button>
                <button id="room206Button">Room 206</button>
                <br>
                <br>
                <div id="calendar"></div>
            </div>
        </main>
    </div>

</body>
</html>