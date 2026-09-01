<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/AppointmentModel.php";
require_once __DIR__ . "/models/PrescriptionModel.php";

require_role("patient");
$conn = get_db_connection();
$patientId = current_user_id();

$upcoming = get_upcoming_appointments_by_patient($conn, $patientId);
$completed = get_completed_appointments_by_patient($conn, $patientId);
$prescriptions = get_prescriptions_by_patient($conn, $patientId);

$pageTitle = "Patient Dashboard";
$theme = "patient";
$active = "overview";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/patient/dashboard.php";
require __DIR__ . "/views/partials/footer.php";
