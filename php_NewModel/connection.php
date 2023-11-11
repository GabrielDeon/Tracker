<?php
    $serverName = "DESKTOP-MSJTR3J\SQLEXPRESS"; //serverName\instanceName
    $connectionInfo = array( "Database"=>"TrackerDB");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
?>