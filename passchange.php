<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/UserModel.php";

require_login();
$conn = get_db_connection();
$userId = current_user_id();

$passMessage = null;
$passIsError = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["change_password"])) {
    $current = $_POST["current_password"] ?? "";
    $new     = $_POST["new_password"] ?? "";
    $confirm = $_POST["confirm_password"] ?? "";

    $user = get_user_by_id($conn, $userId);

    if (!password_verify($current, $user["password"])) {
        $passMessage = "Current password is incorrect.";
        $passIsError = true;
    } elseif (strlen($new) < 6) {
        $passMessage = "New password must be at least 6 characters.";
        $passIsError = true;
    } elseif ($new !== $confirm) {
        $passMessage = "New passwords do not match.";
        $passIsError = true;
    } else {
        update_user_password($conn, $userId, password_hash($new, PASSWORD_DEFAULT));
        $passMessage = "Password changed successfully.";
    }
}

$pageTitle = "Change Password";
$theme = current_role();
$active = "profile";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/account/passchange.php";
require __DIR__ . "/views/partials/footer.php";
