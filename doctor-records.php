<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/PrescriptionModel.php";

require_role("doctor");
$conn = get_db_connection();
$doctorId = current_user_id();

$patients = get_patients_for_doctor($conn, $doctorId);

$keyword = trim($_GET["q"] ?? "");
if ($keyword !== "") {
    $patients = array_values(array_filter($patients, function ($p) use ($keyword) {
        return stripos($p["full_name"], $keyword) !== false;
    }));
}

$pageTitle = "Patient Records";
$theme = "doctor";
$active = "records";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/doctor/records.php";
require __DIR__ . "/views/partials/footer.php";
