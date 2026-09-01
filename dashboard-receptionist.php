<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/AppointmentModel.php";

require_role("receptionist");
$conn = get_db_connection();

$pending = get_pending_confirmations($conn);
$appointmentsToday = count_today_appointments($conn);

$pageTitle = "Receptionist Dashboard";
$theme = "receptionist";
$active = "overview";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/receptionist/dashboard.php";
require __DIR__ . "/views/partials/footer.php";
