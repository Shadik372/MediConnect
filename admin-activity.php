<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/ActivityModel.php";
require_once __DIR__ . "/models/AppointmentModel.php";

require_role("admin");
$conn = get_db_connection();

$activity = get_recent_activity($conn, 30);
$activityToday = count_activity_today($conn);
$bookingsToday = count_today_appointments($conn);
$errorsToday = count_errors_today($conn);

$pageTitle = "System Activity";
$theme = "admin";
$active = "activity";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/admin/activity.php";
require __DIR__ . "/views/partials/footer.php";
