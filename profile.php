<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/UserModel.php";

require_login();
$conn = get_db_connection();
$userId = current_user_id();

$profileMessage = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["save_profile"])) {
    $fullName = trim($_POST["full_name"] ?? "");
    $email    = trim($_POST["email"] ?? "");
    $phone    = trim($_POST["phone"] ?? "");

    if ($fullName !== "" && filter_var($email, FILTER_VALIDATE_EMAIL) && $phone !== "") {
        update_user_profile($conn, $userId, $fullName, $email, $phone);
        $_SESSION["full_name"] = $fullName;
        $profileMessage = "Profile updated.";
    } else {
        $profileMessage = "Please fill in a valid name, email, and phone.";
    }
}

$user = get_user_by_id($conn, $userId);

$pageTitle = "Profile Settings";
$theme = current_role();
$active = "profile";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/account/profile.php";
require __DIR__ . "/views/partials/footer.php";
