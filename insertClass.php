<div class="insertClass" style="text-align: center;
        color: #6A4C9C;
        align-items: center;
        font-family: 'Press Start 2P';
        font-size: 30px;">
    Insert Class
</div>
<br>
<form method="POST" ,action="test.php" style="text-align: center;">
    <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
    ID: <input type="text" name="id"> <br /><br />
    Name: <input type="text" name="name"> <br /><br />
    Stored Loaction: <input type="text" name="location"> <br /><br />

    <input type="submit" value="insertClass" name="insertClass"></p>
</form>



<?php
if (isset($_POST['insertClass'])) {
    addToDB(
        "Class",
        $_POST['Section'],
        $_POST['Name'],
        $_POST['Start Date'],
        $_POST['End Date'],
        null,
        null
    );
}
?>