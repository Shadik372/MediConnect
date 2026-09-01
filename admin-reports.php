<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/UserModel.php";
require_once __DIR__ . "/models/AppointmentModel.php";

require_role("admin");
$conn = get_db_connection();

$totalUsers = count_all_users($conn);
$patientCount = count_users_by_role($conn, "patient");
$receptionistCount = count_users_by_role($conn, "receptionist");
$activeDoctors = count(get_all_doctors($conn));
$appointmentsThisMonth = count_appointments_this_month($conn);

$pageTitle = "Platform Reports";
$theme = "admin";
$active = "reports";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/admin/reports.php";
require __DIR__ . "/views/partials/footer.php";
