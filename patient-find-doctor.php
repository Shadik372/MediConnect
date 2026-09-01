<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/UserModel.php";
require_once __DIR__ . "/controllers/PatientController.php";

require_role("patient");
$conn = get_db_connection();

$doctors = patient_find_doctors($conn);

$pageTitle = "Find a Doctor";
$theme = "patient";
$active = "find-doctor";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/patient/find-doctor.php";
require __DIR__ . "/views/partials/footer.php";
