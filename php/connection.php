<?php
    $serverName = "DESKTOP-DEON01\SQLEXPRESS"; //serverName\instanceName
    $connectionInfo = array( "Database"=>"TrackerDB");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
?>