<?php
include_once 'connection.php';

//----------------------------------------------------------------------//
/* Handling Login */

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    login($email, $password);
}

//----------------------------------------------------------------------//
/* Handling Logout */

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'logout') {
        logout();
    }
}



//----------------------------------------------------------------------//
/* Logging in */
function login($email, $password)
{
    $con = connection();
    try {
        $sql = "SELECT * FROM login WHERE email='" . $email . "' AND password='" . $password . "'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION["name"] = $row['name'];
            }
            header("Location: ../home.php");
            exit();
        } else {
            header("Location: ../index.php?message=Email or Password is wrong");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        echo $e->getMessage();
    }

    $con->close();
}

//----------------------------------------------------------------------//
/* Logging out */
function logout()
{
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}
