<div class="insertMembers" style="text-align: center;
        color: #6A4C9C;
        align-items: center;
        font-family: 'Press Start 2P';
        font-size: 30px;">
    Insert/Update Members
</div>
<br>
<form method="POST" ,action="test.php" style="text-align: center;">
    <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
    ID: <input type="text" name="ID"> <br /><br />
    First Name: <input type="text" name="First Name"> <br /><br />
    Last Name: <input type="text" name="Last Name<"> <br /><br />
    Phone Number: <input type="text" name="Phone Number"> <br /><br />
    Address: <input type="text" name="Address"> <br /><br />
    Date Birth: <input type="text" name="Date Birth"> <br /><br />
    <input type="submit" value="insertMembers" name="insertMembers"></p>
</form>

<form method="POST" ,action="test.php" style="text-align: center;">
    <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
    ID: <input type="text" name="ID"> <br /><br />
    Old Phone: <input type="text" name="oldPhone"> <br /><br />
    New Phone: <input type="text" name="newPhone"> <br /><br />
    <input type="submit" value="Update" name="updateMembers"></p>
</form>


<?php
if (isset($_POST['insertMembers'])) {

    addToDB(
        "Members",
        $_POST['ID'],
        $_POST['First Name'],
        $_POST['Last Name'],
        $_POST['Phone Number'],
        $_POST['Address'],
        $_POST['Date Birth']
    );
}

if (isset($_POST['updateMembers'])) {
    if (connectToDB()) {

        $plainSQL = "UPDATE Members SET 
        ID ='" . $_POST['ID'] . "', Name ='" . $_POST['newName'] . "',
        Email ='" . $_POST['newEmail'] . "', Phone ='" . $_POST['newPhone'] . "'
        WHERE UserID='" . $_POST['oldUserID'] . "' 
        AND Name='" . $_POST['oldName'] . "' 
        AND Email='" . $_POST['oldEmail'] . "'
        AND Phone='" . $_POST['oldPhone'] . "'";

        if (executePlainSQL($plainSQL)) {
            OCICommit($db_conn);
            echo '<br> The SportCentre Members table has been updated. Please refresh the page by clicking Members button to get updated table.
            <br>';
        } else {
            echo "Fail to add";
        }
    }


    disconnectFromDB();
}
?>