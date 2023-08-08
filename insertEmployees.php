<div class="insertEmployees" style="text-align: center;
        color: #6A4C9C;
        align-items: center;
        font-family: 'Press Start 2P';
        font-size: 30px;">
    Insert Employee
</div>
<br>
<form method="POST" ,action="test.php" style="text-align: center;">
    <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
    ID: <input type="text" name="id"> <br /><br />
    Name: <input type="text" name="name"> <br /><br />
    Stored Loaction: <input type="text" name="location"> <br /><br />

    <input type="submit" value="insertEmployees" name="insertEmployees"></p>
</form>



<?php
if (isset($_POST['insertEmployees'])) {
    addToDB(
        "Employee",
        $_POST['First Day'],
        $_POST['ID'],
        $_POST['First Name'],
        $_POST['Last Name'],
        $_POST['Hourly Rate'],
        null
    );
}
?>