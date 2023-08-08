 <form method="POST" action="test.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
     SportsCenterLocation: <input type="text" name="oldReservationID"> <br /><br />
    <input type="submit" value="Delete" name="DeleteSportCentre"></p>
</form>


<?php

function deleteFromDB($table, $value)
{
    global $db_conn;
    $plainSQL = "";

    if (connectToDB()) {
        switch ($table) {
            case "SportCentre":
                $plainSQL = "DELETE from " . $table . " WHERE Location='" . $value . "'";
                break;
            
            default:
                break;
        }
        if (executePlainSQL($plainSQL)) {

            if (OCICommit($db_conn)) {
                echo  '<br>' . $value . " in " . $table . " has been successfully DELETED! <br>";
            };
        }
    }

    disconnectFromDB();
}
?>

