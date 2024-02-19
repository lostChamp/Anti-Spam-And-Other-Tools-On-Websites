<?php
session_start();
$utm = $_GET["utm_source"] ?? "";
if(!isset($_SESSION["utm_source"])) {
    $_SESSION["utm_source"] = "";
}
if(!isset($_SESSION["utm_source"]) && !empty($utm)) {
    $_SESSION["utm_source"] = $utm;
}else if($_SESSION["utm_source"] !== $utm && !empty($utm) && isset($_SESSION["utm_source"])) {
    $_SESSION["utm_source"] = $utm;
}else if(empty($utm)) {
    $utm = $_SESSION["utm_source"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>