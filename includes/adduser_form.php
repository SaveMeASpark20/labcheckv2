<div id="addUserForm" class="hide">
    <div class="add-modal-content">
        <span class="close"  onclick="closeAddUserModal()">&times;</span>
        <h2>Add User</h2>
        <form id="userAddForm" action="../includes/adduser.php" method="post">
                
            <input type="text" id="firstname" name="firstname" placeholder="FirstName" class="input" >

            <input type="text" id="lastname" name="lastname"  placeholder="LastName">

            <input type="text" id="middlename" name="middlename" placeholder="Middlename">

            <input type="text" id="id" name="id" placeholder="Id" >

            <input type="text" id="section" name="section" placeholder="Section">
            
            <select id="usertype" name="usertype" placeholder="User Type" >
                <option value="student">Student</option>
                <option value="faculty">Faculty</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" value="Submit">Submit</button>
        </form>
    </div>  
</div>
