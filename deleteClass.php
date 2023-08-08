<form method="POST" action="test.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
     Section: <input type="text" name="Section"> <br /><br />
     Name: <input type="text" name="Name"> <br /><br />
    <input type="submit" value="Delete" name="DeleteClass"></p>
</form>


<?php

function deleteFromDB($table, $value)
{
    global $db_conn;
    $plainSQL = "";

    if (connectToDB()) {
        switch ($table) {
            case "Class":
                $plainSQL = "DELETE from " . $table . " WHERE Section='" . $value . "'"
                " And  Name='" . $value . "'";
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

