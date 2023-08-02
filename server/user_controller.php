<?php
include_once 'connection.php';

//----------------------------------------------------------------------//
/* Handling Form */

if (isset($_POST['submit'])) {
    if ($_POST['form'] == 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        login($email, $password);
    } else if ($_POST['form'] == 'register') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];
        Register($name, $email, $mobile, $password);
    }
}

//----------------------------------------------------------------------//
/* Handling Logout */

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'logout') {
        logout();
    }
}

//----------------------------------------------------------------------//
/* Registeration */
function Register($name, $email, $mobile, $password)
{
    $con = connection();
    try {
        $sql = "INSERT INTO users (name, email, mobile, password ) VALUES ('" . $name . "', '" . $email . "', '" . $mobile . "', '" . $password . "')";
        if ($con->query($sql) === true) {
            header("Location: ../index.php?message=Register Successfully. Please Login now");
            exit();
        } else {
            header("Location: ../index.php?message=Something went wrong with data");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        echo $e->getMessage();
    }

    $con->close();
}

//----------------------------------------------------------------------//
/* Logging in */
function login($email, $password)
{
    $con = connection();
    try {
        $sql = "SELECT * FROM users WHERE email='" . $email . "' AND password='" . $password . "'";
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
