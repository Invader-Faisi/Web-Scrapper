<?php
session_start();
function connection()
{
    $con = new mysqli("localhost", "root", "", "webscraper");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    } else {
        return $con;
    }
}
