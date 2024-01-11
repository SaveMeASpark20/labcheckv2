<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
}
$page = "Calendar";

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
                    fetchLatestPdf();
                    console.log("fetch")
                }
            });

            $('#room206Button').click(function () {
                if (currentButton !== this) {
                    destroyCalendar(); // Destroy the current calendar instance
                    toggleButton(this);
                    selectedRoom = 206;
                    console.log(selectedRoom);
                    initializeCalendar('complab_schedule/load.php?room=206');
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
                            var title = prompt("Enter Schedule Description");
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
                                    
                                    // // Add the event to the calendar
                                    // calendar.fullCalendar('renderEvent', data);

                                    $.ajax({
                                        url: "complab_schedule/insert.php",
                                        type: "POST",
                                        data: data, // Send the event data to your server
                                        success: function (response) {
                                            var insertedId = JSON.parse(response).id;

                                            if (insertedId) {
                                                // If a valid ID is received, update the event's ID
                                                data.id = insertedId;
                                                calendar.fullCalendar('renderEvent', data);
                                                alert("Added Successfully");
                                            } else {
                                                alert("Error: Unable to get a valid ID from the server");
                                            }
                                        },
                                        error: function () {
                                            // Handle errors
                                            alert("Error during AJAX request");
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
                                console.log(event);
                                $.ajax({
                                    url:"complab_schedule/update.php",
                                    type:"POST",
                                    data:{title:title, start:start, end:end, id:id},
                                    success:function()
                                    {
                                        calendar.fullCalendar('updateEvents', id);
                                        alert('Event Updated');
                                    }
                                })
                            },

                            eventDrop:function(event)
                            {
                                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                                var title = event.title;
                                var id = event.id;
                                console.log(event);
                                $.ajax({
                                    url:"complab_schedule/update.php",
                                    type:"POST",
                                    data:{title:title, start:start, end:end, id:id},
                                    success:function()
                                    {
                                        calendar.fullCalendar('updateEvents', id);
                                        alert("Event Updated");
                                    }
                                });
                            },

                            eventClick: function (event) {
                            if (confirm("Are you sure you want to remove it?")) {
                                var id = event.id;
                                var title = event.title;
                                $.ajax({
                                    url: "complab_schedule/delete.php",
                                    type: "POST",
                                    data: { id: id, title: title },
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

        function closeRoomScheduleModal() {
            $('#myModal').hide();
        }

        function openRoomScheduleModal() {
            $('#myModal').show();
        }

        function setSelectedRoom() {
            // Set the value of selectedRoom in the hidden input field
            $('#selectedRoom').val(selectedRoom);
        }

    </script>
    <title>Admin</title>
    <style>
        #calendar {
            display: none;
            flex: 2;
        }  

        #room_schedule {
            display: none;
        }
        
        #room_schedule button {
            display:block;
            background-color: green;
            color: white;
            padding: 5px;
            margin-bottom: 10px;
            border: none;
            border-radius: 10px;

        }  


        #room_schedule iframe {
            width: 500px;
            height: 500px
        }

        .calendar-roomsched {
            display: flex;
            gap: 10px;        
        }

        #room205Button, #room206Button {
            padding: 5px;
            border: none;
            border-radius: 10px
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

        .modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 100px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* Close button styling */
        .close {
            color: #aaa;
            text-align: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        #uploadForm {
            
        }
        #uploadForm button {
            background-color: green;
            color: white;
            padding: 5px;
            border: none;
            border-radius: 10px;
            margin-top: 10px;
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

        @media (max-width: 300px) {
                #room_schedule iframe {
                width: 150px;
                height: 200px;
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
            <div>
                <button id="room205Button">Room 205</button>
                <button id="room206Button">Room 206</button>
                <br>
                <br>
                <div class="calendar-roomsched">
                    <div id="calendar"></div>
                    <div id="room_schedule">
                        <!-- button to update schedule (pop up for the modal) -->
                        <button onclick="openRoomScheduleModal()">Update Room Schedule</button>
                        <!-- Iframe for PDF -->
                        <iframe id="roomSchedulePdf" width="100%" height="75%"></iframe>
                    </div>
                </div>
            </div>
        </main> 
    </div>
    
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRoomScheduleModal()">&times;</span>
            <form id="uploadForm">
                <label for="pdfFile">Select PDF file:</label>
                <input type="hidden" name="selectedRoom" id="selectedRoom" value="">
                <input type="file" name="pdfFile" id="pdfFile" accept=".pdf">
                <button type="button" onclick="uploadFormData()">Upload</button>
            </form>
        </div>
    </div>
</body>

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




function uploadFormData() {
    // Get the form data
    var formData = new FormData(document.getElementById("uploadForm"));

    // Set the selectedRoom value
    formData.append("selectedRoom", selectedRoom);

    // Make the asynchronous request using fetch
    fetch("../includes/roomSchedule.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // assuming the response is in JSON format
    .then(data => {
        // Handle the response data here
        alert(data.message);
        closeRoomScheduleModal();
        document.getElementById("uploadForm").reset();
        fetchLatestPdf();
    })
    .catch(error => {
        // Handle errors here
       alert(error.message);
    });
}
</script>
</html>