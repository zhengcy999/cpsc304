<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container {
            width: 100%;
            height: 100vh;
        }

        .toppane {
            width: 100%;
            height: 80px;
            background-color: #00BFFF;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-buttons {
            display: flex;
            gap: 10px;
            margin-right: 10px;
            margin-bottom: -50px;
            color: #98e6ee;
            font-size: 10px;
            border-radius: 5px;
        }

        .top-buttons button {
            padding: 10px;
        }

        .leftpane {
            width: 20%;
            height: 100vh;
            background-color: #FFFAF0;
        }

        .middlepane {
            width: 80%;
            height: 100vh;
            background-color: #ADD8E6;
        }

        .rightpane {
            width: 25%;
            height: 100vh;
            background-color: #FFF0F5;
        }

        body {
            margin: 0 !important;
        }

        .d-flex {
            display: flex;
        }

        .leftpane li {
            display: block;
            /* height: 100; */
            width: 100%;
            line-height: 100px;
            font-weight: 100px;
            font-size: 10px;
            color: rgb(15, 5, 5);
            padding-left: 20px;
            /* box-sizing: border-box; */
            /* border-top: 1px solid rgba(255, 255, 255); */
            /* border-bottom: 1px solid rgba(255, 255, 255); */
            transition: 0.4s;
        }
    </style>

    <title>SportCentre Management System</title>
</head>

<body>
    <div class="container">
        <div class="toppane">
            <h1 style="color: white; font-size: 40px;">SportCentre Management System</h1>
            <div class="top-buttons">
                <button onclick="window.location.href='../login/index.php'">Sign In</button>
            </div>
        </div>

        <div class="d-flex">
            <div class="leftpane">



                <form method="POST" action="test.php">
                    <li>
                        <input type="submit" name="SportCentreTag" value="SportCentre" , style="font-size: 25px;" />
                    </li>

                    <li>
                        <input type="submit" name="ClassTag" value="Class" , style="font-size: 25px;" />
                    </li>

                    <li>
                        <input type="submit" name="EmployeeTag" value="Employees" , style="font-size: 25px;" />
                    </li>

                    <li>
                        <input type="submit" name="EquipmentTag" value="Equipments" , style="font-size: 25px;" />
                    </li>

                    <li>
                        <input type="submit" name="FacilityTag" value="Facilities" , style="font-size: 25px;" />
                    </li>

                    <li>
                        <input type="submit" name="memberTag" value="Members" , style="font-size: 25px;" />
                    </li>
                </form>

            </div>

            <div class="middlepane">
                <?php include('mainDisplay.php'); ?>


            </div>

            <div class="rightpane">
                <?php include('insertlisteners.php'); ?>
            </div>
        </div>
    </div>


    <?php
    //this tells the system that it's no longer just parsing html; it's now parsing PHP
    $record = null;

    $success = True; //keep track of errors so it redirects the page only if there are no errors
    $db_conn = NULL; // edit the login credentials in connectToDB()
    $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

    function debugAlertMessage($message)
    {
        global $show_debug_alert_messages;

        if ($show_debug_alert_messages) {
            echo "<script type='text/javascript'>alert('" . $message . "');</script>";
        }
    }

    function executePlainSQL($cmdstr)
    { //takes a plain (no bound variables) SQL command and executes it
        //echo "<br>running ".$cmdstr."<br>";
        global $db_conn, $success;

        $statement = OCIParse($db_conn, $cmdstr);
        //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
            echo htmlentities($e['message']);
            $success = False;
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
            echo htmlentities($e['message']);
            $success = False;
        }

        return $statement;
    }

    function executeBoundSQL($cmdstr, $list)
    {
        /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

        global $db_conn, $success;
        $statement = OCIParse($db_conn, $cmdstr);

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn);
            echo htmlentities($e['message']);
            $success = False;
        }

        foreach ($list as $tuple) {
            foreach ($tuple as $bind => $val) {
                //echo $val;
                //echo "<br>".$bind."<br>";
                OCIBindByName($statement, $bind, $val);
                unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                echo htmlentities($e['message']);
                echo "<br>";
                $success = False;
            }
        }
    }


    function connectToDB()
    {
        global $db_conn;

        // Your username is ora_(CWL_ID) and the password is a(student number). For example,
        // ora_platypus is the username and a12345678 is the password.
        $db_conn = OCILogon("ora_czheng17", "a36718591", "dbhost.students.cs.ubc.ca:1522/stu");

        if ($db_conn) {
            debugAlertMessage("Database is Connected");
            return true;
        } else {
            debugAlertMessage("Cannot connect to Database");
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
            return false;
        }
    }

    function disconnectFromDB()
    {
        global $db_conn;

        debugAlertMessage("Disconnect from Database");
        OCILogoff($db_conn);
    }


    function displayFromDB($table, $mode, $value)
    {
        global $db_conn;
        if (connectToDB()) {
            echo '<table class="dispTable" style="
                   width: 100%;
                   text-align:center;
                   padding: 15px;">';

            switch ($table) {
                case "SportCentre":
                    echo '<p style="
                    color:black; 
                    font-size: 20px;
                    text-align:center;"> SportCentre </p>
                    <tr>
                    <th>Location</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Hours</th>
                    <th>Price</th>
                    <th>Capacity</th></tr>';
                    break;
                case "Class":
                    echo '<p style="
                    color:black; 
                    font-size: 20px;
                    text-align:center;"> Class </p>
                    <tr><th>Section</th>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    </tr>';
                    break;
                case "Facility":
                    echo '<p style="
                    color:black; 
                    font-size: 20px;
                    text-align:center;"> Facility </p>
                    <tr><th >Hours</th>
                    <th>Floor Level</th>
                    <th>Sqrt</th>
                    <th>ID</th>
                    </tr>';
                    break;
                case "Employees":
                    echo '<p style="
                    color:black; 
                    font-size: 20px;
                    text-align:center;"> Employees </p>
                    <tr><th>First Day</th>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Hourly Rate</th></tr>';
                    break;
                case "Equipment":
                    echo '<p style="
                    color:black; 
                    font-size: 20px;
                    text-align:center;"> Equipments </p>
                    <tr><th>ID</th>
                    <th>Name</th>
                    <th>Stored Location</th></tr>';
                    break;
                case "Members":
                    echo '<p style="
                    color:black; 
                    font-size: 20px;
                    text-align:center;">  Members </p>
                    <tr><th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Date Birth</th></tr>';
                    break;
                default:
                    echo '<tr><th>ID</th>
                    <th>Name</th>
                    <th>Address</th></tr>';
                    break;
            }
            switch ($table) {
                case "SportCentre":
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                        <td> ' . $row["Location"] . '</td>
                        <td> ' . $row["Phone Number"] . '</td>
                        <td>' . $row["Address"] . '</td>
                        <td>' . $row["Hours"] . '</td>
                        <td>' . $row["Price"] . '</td>
                        <td>' . $row["Capacity"] . '</td>
                        </tr>';
                    }
                    break;

                case "Class":
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                        <td> ' . $row["Section"] . '</td>
                        <td> ' . $row["Name"] . '</td>
                        <td>' . $row["Start Date"] . '</td>
                        <td> ' . $row["End Date"] . '</td>
                        </tr>';
                    }
                    break;

                case "Facility":
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                            <td> ' . $row["ID"] . '</td>
                            <td> ' . $row["Hours"] . '</td>
                            <td>' . $row["floor Level"] . '</td>
                            <td> ' . $row["Sqrt"] . '</td>
                            </tr>';
                    }
                    break;

                case "Employees":
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                            <td> ' . $row["First Day"] . '</td>
                            <td> ' . $row["ID"] . '</td>
                            <td>' . $row["First Name"] . '</td>
                            <td> ' . $row["Last Name"] . '</td>
                            <td> ' . $row["Hourly Rate"] . '</td></tr>';
                    }
                    break;

                case "Equipment":
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                            <td> ' . $row["ID"] . '</td>
                            <td> ' . $row["Name"] . '</td>
                            <td> ' . $row["Stored Location"] . '</td>
                            </tr>';
                    }
                    break;

                case "Members":
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                            <td> ' . $row["ID"] . '</td>
                            <td> ' . $row["First Name"] . '</td>
                            <td> ' . $row["Last Name"] . '</td>
                            <td> ' . $row["Phone Number"] . '</td>
                            <td> ' . $row["Birth Date"] . '</td>
                            <td> ' . $row["Address"] . '</td></tr>';
                    }
                    break;

                default:
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                        <td> ' . $row["ID"] . '</td>
                        <td> ' . $row["NAME"] . '</td>
                        <td>' . $row["ADDRESS"] . '</td></tr>';
                    }
                    break;
            }
            echo '</table>';
        } else {
            echo "Notconnected";
        }
        disconnectFromDB();
    }

    function buttonConv($name, $value)
    {

        $result = '<form method="POST" action="test.php">
    <input type ="submit" name=' . $name . ' value=' . $value . ' />  
    </form>';
        return $result;
    }



    function addToDB($table, $val1, $val2, $val3, $val4, $val5, $val6)
    {
        global $db_conn;
        $plainSQL = "";
        if (connectToDB()) {
            switch ($table) {
                case "SportCentre":
                    $plainSQL = "INSERT into " . $table . " values('" . $val1 . "','" . $val2 . "','" . $val3 . "','". $val4 . "','". $val5 . "','". $val6 .  "')";
                    break;
                case "Class":
                    $plainSQL = "INSERT into " . $table . " values('" . $val1 . "','" . $val2 . "', TO_DATE('" . $val3 . "', 'YYYY-MM-DD'),'". "', TO_DATE('" . $val4 . "', 'YYYY-MM-DD'))";
                    break;
                case "Members":
                    $plainSQL = "INSERT into " . $table . " values('" . $val1 . "','" . $val2 . "','" . $val3 . "','" . $val4 . "','". $val5 . "','". "', TO_DATE('" . $val6 . "', 'YYYY-MM-DD'))";
                    break;
                case "Facilities":
                    $plainSQL = "INSERT INTO " . $table . " VALUES ('" . $val1 . "','" . $val2 . "','" . $val3 . "','" . $val4 . "')";
                    break;
                case "Employees":
                    $plainSQL = "INSERT into " . $table . " values('" . "', TO_DATE('" . $val1 . "', 'YYYY-MM-DD'), '"  . $val2 . "','" . $val3 . "','". $val4 . "','". $val5 . "')";
                    break;
                case "Equipments":

                    $plainSQL = "INSERT INTO " . $table . " VALUES ('" . $val1 . "','" . $val2 . "','" . $val3 . "')";
                    break;
                default:
                    break;
            }
            if (executePlainSQL($plainSQL)) {
                OCICommit($db_conn);
                echo '<br>' . $val1 . ' has been added to the database. Please refresh the page by clicking ' . $table . ' button to get updated table.
                <br>';
            } else {
                echo "Fail to add";
            }
        }
        disconnectFromDB();
    }

    function deleteFromDB($table, $value)
    {
        global $db_conn;
        $plainSQL = "";

        if (connectToDB()) {
            switch ($table) {
                case "Employees":

                    $plainSQL = "DELETE from " . $table . " WHERE Name='" . $value . "'";
                    break;
                case "Purchase":
                    $plainSQL = "DELETE from " . $table . " WHERE Name='" . $value . "'";
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

    // HANDLE ALL POST ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handlePOSTRequest()
    {
        if (connectToDB()) {
            if (array_key_exists('resetTablesRequest', $_POST)) {
                handleResetRequest();
            } else if (array_key_exists('updateQueryRequest', $_POST)) {
                handleUpdateRequest();
            } else if (array_key_exists('insertQueryRequest', $_POST)) {
                handleInsertRequest();
            }

            disconnectFromDB();
        }
    }


    // HANDLE ALL GET ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handleGETRequest()
    {
        if (connectToDB()) {
            if (array_key_exists('countTuples', $_GET)) {
                handleCountRequest();
            }
            disconnectFromDB();
        }
    }

    if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])) {
        handlePOSTRequest();
    } else if (isset($_GET['countTupleRequest'])) {
        handleGETRequest();
    }
    ?>

</body>

</html>