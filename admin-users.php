<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/UserModel.php";
require_once __DIR__ . "/controllers/AdminController.php";

require_role("admin");
$conn = get_db_connection();

admin_handle_user_management($conn);
$users = admin_search_users($conn);

$pageTitle = "User Management";
$theme = "admin";
$active = "users";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/admin/users.php";
require __DIR__ . "/views/partials/footer.php";
