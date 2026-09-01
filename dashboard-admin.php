<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/UserModel.php";
require_once __DIR__ . "/models/ActivityModel.php";

require_role("admin");
$conn = get_db_connection();

$pendingDoctors = get_pending_doctors($conn);
$totalUsers = count_all_users($conn);
$activityToday = count_activity_today($conn);

$pageTitle = "Admin Dashboard";
$theme = "admin";
$active = "overview";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/admin/dashboard.php";
require __DIR__ . "/views/partials/footer.php";
