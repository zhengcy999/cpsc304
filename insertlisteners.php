<?php

    if (
        isset($_POST['SportsCenterTag']) || isset($_POST['insertSportCentre'])
    ) {
        include('insertSportCentre.php');
    } elseif (
        isset($_POST['ClassTag']) || isset($_POST['insertClass'])
    ) {
        include('insertClass.php');
    } elseif (
        isset($_POST['EmployeeTag']) || isset($_POST['insertEmployees']) || isset($_POST['insertEmployees'])
    ) {
        include('insertEmployees.php');
    } elseif (
        isset($_POST['FacilityTag']) || isset($_POST['insertFacility'])
    ) {
        include('insertFacility.php');
    } elseif (
        isset($_POST['EquipmentTag']) || isset($_POST['insertEquipment'])
    ) {
        include('insertEquipment.php');
    } elseif (
        isset($_POST['memberTag']) || isset($_POST['insertMembers']) || isset($_POST['updateMembers'])
    ) {
        include('insertMembers.php');
    }
    ?>

    
  