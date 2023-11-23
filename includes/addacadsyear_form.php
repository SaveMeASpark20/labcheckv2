<!-- Add Acad Year Form (Initially Hidden) -->
<div id="addAcadForm" class="hide">
    <div class="add-modal-content">
        <span class="close"  onclick="closeAddAcadYearModal()">&times;</span>
        <h2>Add School Year</h2>
        <form id="" action="../includes/addacadsyear.php" method="post">
  
            <label for="schoolyear">School Year:</label>
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
