<?php 
    $conn = new mysqli('localhost', 'root', '', 're-books');

    /* Set the desired charset after establishing a connection */
    $conn->set_charset('utf8mb4');

    if(!$conn)
        echo 'asd';

    //printf("Success... %s\n", $conn->host_info);
?>
