<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/AppointmentModel.php";

require_role("patient");
$conn = get_db_connection();
$patientId = current_user_id();

$completed = get_completed_appointments_by_patient($conn, $patientId);

$pageTitle = "Visit History";
$theme = "patient";
$active = "history";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/patient/visit-history.php";
require __DIR__ . "/views/partials/footer.php";
