<form method="POST" action="test.php"> <!--refresh page when submitted-->
    <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
    Old Sports Center Location: <input type="text" name="oldSportsCenterLocation"> <br /><br />
    New Sports Center Locatio: <input type="text" name="newSportsCenterLocation"> <br /><br />
    Old Contact Number: <input type="text" name="oldContactNumber"> <br /><br />
    New Contact Number: <input type="text" name="newContactNumber"> <br /><br />
    Old Hours: <input type="text" name="oldHours"> <br /><br />
    New Hours: <input type="text" name="newHours"> <br /><br />
    Old Price: <input type="text" name="oldPrice"> <br /><br />
    New Price: <input type="text" name="newPrice"> <br /><br />
    Old Address: <input type="text" name="oldAddress"> <br /><br />
    New Address: <input type="text" name="newAddress"> <br /><br />
    Old Capacity: <input type="text" name="oldCapacity"> <br /><br />
    New Capacity: <input type="text" name="newCapacity"> <br /><br />

    <input type="submit" value="Update" name="updateSportsCenter"></p>
</form>


<?php

function updateSportsCenter() {
    global $$db_conn;

    executePlainSQL("UPDATE SportsCenter SET 
    SportsCenterLocation ='" . $_POST['newSportsCenterLocation'] . "', 
    ContactNumber ='" . $_POST['newContactNumber'] . "',
    Hours ='" . $_POST['newHours'] . "',
    PRICE ='" . $_POST['newPrice'] . "',
    Address ='" . $_POST['newAddress'] . "',
    Capacity ='" . $_POST['newCapacity'] . "'
    WHERE
    SportsCenterLocation ='" . $_POST['oldSportsCenterLocation'] . "', 
    ContactNumber ='" . $_POST['oldContactNumber'] . "',
    Hours ='" . $_POST['oldHours'] . "',
    PRICE ='" . $_POST['oldPrice'] . "',
    Address ='" . $_POST['oldAddress'] . "',
    Capacity ='" . $_POST['oldCapacity'] . "'");
        
    OCICommit($db_conn);

}
?>
