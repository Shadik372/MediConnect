<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/AppointmentModel.php";

require_role("receptionist");
$conn = get_db_connection();

$todaysSchedule = get_today_schedule_all($conn);

$pageTitle = "Daily Schedule";
$theme = "receptionist";
$active = "schedule";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/receptionist/schedule.php";
require __DIR__ . "/views/partials/footer.php";
