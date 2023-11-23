<!-- Add User Form (Initially Hidden) -->
<div id="addSchedule" >
    <div class="add-modal-content">
    <span class="close"  onclick="closeAddSchedModal()">&times;</span>
        <h2>Add Schedule</h2>
        <form id="scheduleAddForm" action="../includes/addschedule.php" method="post">
            <label for="roomNumber">Room number:</label>
            <select id ="roomNumber" name="room_number" required>>
                <option value="202">Room 202</option>
                <option value="203">Room 203</option>
            </select>
            <label for="dayOfWeek">Day of the Week:</label>
            <select id ="dayOfWeek" name="day_of_week" required>
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>
                <option value="sunday">Sunday</option>
            </select>
            <label for="startTime">Start Time:</label>
            <input type="time" id="startTime" name="start_time" required step="1800">
            <label for="endTime">End Time:</label>
            <input type="time" id="endTime" name="end_time" required>
            <label for="section">Section:</label>
            <input type="text" id="section" name="section" required>
            <label for="professor">Professor:</label>
            <input type="text" id="professor" name="professor" required>
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>
            <button type="submit" value="Submit">Submit</button>
        </form>
    </div>
</div>
