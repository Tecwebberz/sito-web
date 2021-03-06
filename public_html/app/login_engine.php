<?php
$root = "..";
require_once($root . "/app/global.php");

if (!(isset($_POST["username"]) && isset($_POST["password"]))) {
    echo "Stai per essere reindirizzato!";
    header("Location: ../accedi.php");
    exit();
}

$username = $_POST["username"];
$password = $_POST["password"];
$user = $user_service->login($username, $password);

if ($user === UserServiceError::AUTH_FAILED) {
    $snd = "";
    if (isset($_POST["target"]) && $_POST["target"] !== "") {
        $encoded = urlencode($_POST["target"]);
        $snd = "&target={$encoded}";
    }
    header("Location: ../accedi.php?error={$user}{$snd}");
    exit();
} 

$_SESSION["logged_user"] = $user;
if (isset($_POST["target"]) && $_POST["target"] !== "") {
    header("Location: ../{$_POST["target"]}");
} else {
    header("Location: ../index.php");
}
?>