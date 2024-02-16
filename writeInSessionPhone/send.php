<?php

session_start();
if(count($_SESSION) === 0) {
    $_SESSION["phones"] = [];
}

if((isset($_POST["phone"]) && !in_array($_POST["phone"], $_SESSION["phones"]) ||
    (isset($_POST["id"]) && !in_array($_POST["id"], $_SESSION["phones"]))
)) {
    $_SESSION['phones'][] = $_POST["phone"] ?? $_POST["id"];

}

//Redirect on your thanks page or idk what you need bitch

// header("Location: https://quiz.stom-tum.ru");
// die();