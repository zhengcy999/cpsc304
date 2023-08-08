<div class="insertEquipment" style="text-align: center;
        color: #6A4C9C;
        align-items: center;
        font-family: 'Press Start 2P';
        font-size: 30px;">
    Insert Equipment
</div>
<br>
<form method="POST" ,action="test.php" style="text-align: center;">
    <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
    ID: <input type="text" name="id"> <br /><br />
    Name: <input type="text" name="name"> <br /><br />
    Stored Loaction: <input type="text" name="location"> <br /><br />

    <input type="submit" value="insertEquipment" name="insertEquipment"></p>
</form>



<?php
if (isset($_POST['insertEquipment'])) {
    addToDB(
        "Equipment",
        $_POST['ID'],
        $_POST['Name'],
        $_POST['Stored Loaction'],
        null,
        null,
        null
    );
}
?>