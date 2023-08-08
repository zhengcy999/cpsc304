<?php
global $currentStock;
global $vendor;

if (isset($_POST['SportsCenterTag']) || isset($_POST['insertSportCentre'])) {
    displayFromDB("SportsCenter", null);
}  elseif (isset($_POST['ClassTag']) || isset($_POST['insertClass'])) {
    displayFromDB("Class", "ALL", null);
} elseif (isset($_POST['FacilityTag']) || isset($_POST['insertFacility'])) {
    displayFromDB("Facility", "ALL", null);
} elseif (isset($_POST['EmployeeTag']) || isset($_POST['insertEmployee'])) {
    displayFromDB("Employees", "ALL", null);
} elseif (isset($_POST['EquipmentTag']) || isset($_POST['insertEquipment'])) {
    displayFromDB("Equipment", "ALL", null);
} elseif (isset($_POST['memberTag']) || isset($_POST['updateMembers']) || isset($_POST['insertMembers'])) {
    displayFromDB("Members", "ALL", null);
} elseif (isset($_POST['currentStockClick'])) {
    $currentStock = $_POST['currentStockClick'];
    include('currentStockDisplay.php');
} elseif (isset($_POST['vendorClick']) || isset($_POST['delete'])) {
    $vendor = $_POST['vendorClick'];
    include('vendorDisplay.php');
}