<!-- Add Acad Year Form (Initially Hidden) -->
<div id="addUpdateAcadForm" class="hide">
    <div class="add-modal-content">
        <span class="close"  onclick="closeAddUpdateAcadYearModal()">&times;</span>
        <h2>Update Academic Year of Users</h2>
        <form id="" action="../includes/updateacadyear.php" method="post">
  
            <label for="schoolyear">Academic Year:</label>
            <input type="text" id="schoolyear" name="school_year" placeholder="2023-2024" required>

            <label for="semester">Semester:</label>
            <select id="semester" name="semester"  required>
                <option value="First Semester">First Semester</option>
                <option value="Second Semester">Second Semester</option>
                <option value="Summer">Summer</option>
            </select>

            <button type="submit" value="Submit">Submit</button>
        </form>
    </div>
</div>
