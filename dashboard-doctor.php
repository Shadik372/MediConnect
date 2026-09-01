<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/AppointmentModel.php";
require_once __DIR__ . "/models/PrescriptionModel.php";

require_role("doctor");
$conn = get_db_connection();
$doctorId = current_user_id();

$queue = get_queue_for_doctor_today($conn, $doctorId);
$patients = get_patients_for_doctor($conn, $doctorId);

$pageTitle = "Doctor Dashboard";
$theme = "doctor";
$active = "overview";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/doctor/dashboard.php";
require __DIR__ . "/views/partials/footer.php";
