<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/PrescriptionModel.php";

require_role("patient");
$conn = get_db_connection();
$patientId = current_user_id();

$prescriptions = get_prescriptions_by_patient($conn, $patientId);

$pageTitle = "Prescriptions";
$theme = "patient";
$active = "prescriptions";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/patient/prescriptions.php";
require __DIR__ . "/views/partials/footer.php";
