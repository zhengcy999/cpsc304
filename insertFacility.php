<div class="insertFacility" style="text-align: center;
        color: #6A4C9C;
        align-items: center;
        font-family: 'Press Start 2P';
        font-size: 30px;">
    Insert Facility
</div>
<br>
<form method="POST" ,action="test.php" style="text-align: center;">
    <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
    ID: <input type="text" name="Name"> <br /><br />
    Floor Level: <input type="text" name="Address"> <br /><br />
    Sqrt: <input type="text" name="Phone"> <br /><br />
    Hours: <input type="text" name="Email"> <br /><br />

    <input type="submit" value="insertFacility" name="insertFacility"></p>
</form>



<?php
if (isset($_POST['insertFacility'])) {
    addToDB(
        "Facility",
        $_POST['ID'],
        $_POST['Hour'],
        $_POST['Floor Level'],
        $_POST['Sqrt'],
        null,
        null
    );
}
?>