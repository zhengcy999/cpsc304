<div class="insertSportCentre" style="text-align: center;
        color: #6A4C9C;
        align-items: #6A4C9C;
        font-family: 'Press Start 2P';
        font-size: 30px;">
</div>
<br>


<form method="POST" ,action="test.php" style="text-align: center;">
    <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
    SportsCenterLocation: <input type="text" name="SportsCenterLocation"> <br /><br />
    ContactNumber: <input type="text" name="ContactNumber"> <br /><br />
    Hours: <input type="text" name="Hours"> <br /><br />
    PRICE: <input type="text" name="PRICE"> <br /><br />
    Address: <input type="text" name="Address"> <br /><br />
    Capacity: <input type="text" name="Capacity"> <br /><br />
    <input type="submit" value="insertSportCentre" name="insertSportCentre"></p>
</form>

<?php
if (isset($_POST['insertSportCentre'])) {
    // addTeam($_POST['teamName'], $_POST['region']);
    addToDB("SportsCenter", $_POST['SportsCenterLocation'], $_POST['ContactNumber'],$_POST['Hours'],$_POST['PRICE'],$_POST['Capacity']);
}
?>  