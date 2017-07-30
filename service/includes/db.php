<?php

    $con = mysqli_connect("localhost","root","12345","AI-BusRoute");
    if(mysqli_connect_errno())
    {
        echo "Failed to connect to MySql: " . mysqli_connect_errno();
    }

?>
