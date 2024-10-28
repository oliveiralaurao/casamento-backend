<?php

$mysqli = new mysqli("localhost", "root", "", "casamento");

if($mysqli->connect_errno) {
    echo "Falha na conexão: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
}


?>
