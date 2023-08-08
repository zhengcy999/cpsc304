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
            background-color: #547980;
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
            background-color: #9DE0AD;
        }

        .middlepane {
            width: 55%;
            height: 100vh;
            background-color: #e5fcc2;
        }

        .rightpane {
            width: 25%;
            height: 100vh;
            background-color: #9DE0AD;
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

    <title>Lab Inventory Management System</title>
</head>

<body>
    <div class="container">
        <div class="toppane">
            <h1 style="color: white; font-size: 40px;">Lab Inventory Management System</h1>
            <div class="top-buttons">
                <button onclick="window.location.href='../login/index.php'">Sign Out</button>
            </div>
        </div>

        <div class="d-flex">
            <div class="leftpane">



                <form method="POST" action="main.php">
                    <li>
                        <input type="submit" name="labTag" value="Lab" , style="font-size: 25px;" />
                    </li>

                    <li>
                        <input type="submit" name="currentStockTag" value="CURRENT STOCK" , style="font-size: 25px;" />
                    </li>

                    <li>
                        <input type="submit" name="purchaseTag" value="PURCHASE" , style="font-size: 25px;" />
                    </li>

                    <li>
                        <input type="submit" name="vendorTag" value="VENDOR" , style="font-size: 25px;" />
                    </li>

                    <li>
                        <input type="submit" name="wasteTag" value="WASTE" , style="font-size: 25px;" />
                    </li>

                    <li>
                        <input type="submit" name="memberTag" value="MEMBERS" , style="font-size: 25px;" />
                    </li>
                </form>

            </div>

            <div class="middlepane">

                <?php include('listeners/filterListener.php'); ?>

                <?php include('listeners/mainDisplay.php'); ?>


            </div>

            <div class="rightpane">
                <?php include('listeners/insertListener.php'); ?>
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
                case "Lab":
                    echo '<p style="
                    color:black; 
                    font-size: 20px;
                    text-align:center;"> LAB </p>
                    <tr><th>ID</th>
                    <th>Name</th>
                    <th>Address</th></tr>';
                    break;
                case "Items":
                    echo '<p style="
                    color:black; 
                    font-size: 20px;
                    text-align:center;"> CURRENT STOCK </p>
                    <tr><th>CatalogNumber</th>
                    <th>FullName</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Type</th></tr>';
                    break;
                case "Purchase":
                    echo '<p style="
                    color:black; 
                    font-size: 20px;
                    text-align:center;"> PURCHASE </p>
                    <tr><th >CatalogNumber</th>
                    <th>AdminID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>PurchaseDate</th>
                    <th>UnitPrice</th></tr>';
                    break;
                case "Vendors":
                    echo '<p style="
                    color:black; 
                    font-size: 20px;
                    text-align:center;"> VENDORS </p>
                    <tr><th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th></tr>';
                    break;
                case "Chemical_Waste_Dispose":
                    echo '<p style="
                    color:black; 
                    font-size: 20px;
                    text-align:center;"> WASTE </p>
                    <tr><th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>AdminID</th>
                    <th>UseDate</th></tr>';
                    break;
                case "LabMembers":
                    echo '<p style="
                    color:black; 
                    font-size: 20px;
                    text-align:center;"> LAB MEMBERS </p>
                    <tr><th>UserID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th></tr>';
                    break;
                default:
                    echo '<tr><th>ID</th>
                    <th>Name</th>
                    <th>Address</th></tr>';
                    break;
            }
            if ($mode == "ALL") {

                $result = executePlainSQL("SELECT * FROM " . $table);
            } else {
                $result = executePlainSQL("SELECT * FROM " . $table . " WHERE " . $mode . "='" . $value . "'");
            }
            switch ($table) {
                case "Lab":
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                        <td> ' . $row["ID"] . '</td>
                        <td> ' . $row["NAME"] . '</td>
                        <td>' . $row["ADDRESS"] . '</td></tr>';
                    }
                    break;

                case "Items":
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                        <td> ' . $row["CATALOGNUMBER"] . '</td>
                        <td> ' . $row["FULLNAME"] . '</td>
                        <td>' . $row["DESCRIPTION"] . '</td>
                        <td> ' . $row["QUANTITY"] . '</td>
                        <td>' .   buttonConv("currentStockClick", $row["TYPE"]) . '</td></tr>';
                    }
                    break;

                case "Purchase":
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                            <td> ' . $row["CATALOGNUMBER"] . '</td>
                            <td> ' . $row["ADMINID"] . '</td>
                            <td>' . $row["NAME"] . '</td>
                            <td> ' . $row["ADDRESS"] . '</td>
                            <td>' . $row["PURCHASEDATE"] . '</td>
                            <td> ' . $row["UNITPRICE"] . '</td></tr>';
                    }
                    break;

                case "Vendors":
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                            <td> ' . buttonConv("vendorClick", $row["NAME"]) . '</td>
                            <td> ' . $row["EMAIL"] . '</td>
                            <td>' . $row["ADDRESS"] . '</td>
                            <td> ' . $row["PHONE"] . '</td></tr>';
                    }
                    break;

                case "Chemical_Waste_Dispose":
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                            <td> ' . $row["ID"] . '</td>
                            <td> ' . $row["NAME"] . '</td>
                            <td> ' . $row["DESCRIPTION"] . '</td>
                            <td>' . $row["ADMINID"] . '</td>
                            <td> ' . $row["USEDATE"] . '</td></tr>';
                    }
                    break;

                case "LabMembers":
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo '<tr>
                            <td> ' . $row["USERID"] . '</td>
                            <td> ' . $row["NAME"] . '</td>
                            <td> ' . $row["EMAIL"] . '</td>
                            <td> ' . $row["PHONE"] . '</td></tr>';
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

        $result = '<form method="POST" action="main.php">
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
                case "Lab":
                    $plainSQL = "INSERT into " . $table . " values('" . $val1 . "','" . $val2 . "','" . $val3 . "')";
                    break;
                case "Items":
                    $plainSQL = "INSERT into " . $table . " values('" . $val1 . "','" . $val2 . "','" . $val3 . "', '" . $val4 . "',
                    '" . $val5 . "')";
                    break;
                case "ItemUnit":
                    $plainSQL = "INSERT into " . $table . " values('" . $val1 . "','" . $val2 . "')";
                    break;
                case "Chemicals":
                    $plainSQL = "INSERT into " . $table . " values('"  . $val1 . "', TO_DATE('" . $val2 . "', 'YYYY-MM-DD'))";
                    break;
                case "Equipments":
                    $plainSQL = "INSERT into " . $table . " values('" . $val1 . "','" . $val2 . "')";
                    break;
                case "LabMembers":

                    $plainSQL = "INSERT into " . $table . " values('" . $val1 . "','" . $val2 . "','" . $val3 . "','" . $val4 . "')";
                    break;
                case "Purchase":
                    $plainSQL = "INSERT INTO " . $table . " VALUES ('" . $val1 . "','" . $val2 . "','" . $val3 . "','" . $val4 . "', TO_DATE('" . $val5 . "', 'YYYY-MM-DD'), '" . $val6 . "')";
                    break;
                case "Vendors":
                    $plainSQL = "INSERT into " . $table . " values('" . $val1 . "','" . $val2 . "','" . $val3 . "','" . $val4 . "')";
                    break;
                case "Chemical_Waste_Dispose":

                    $plainSQL = "INSERT INTO " . $table . " VALUES ('" . $val1 . "','" . $val2 . "','" . $val3 . "','" . $val4 . "', TO_DATE('" . $val5 . "', 'YYYY-MM-DD'))";
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
                case "Vendors":

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