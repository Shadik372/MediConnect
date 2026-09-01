<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/AppointmentModel.php";
require_once __DIR__ . "/models/PrescriptionModel.php";
require_once __DIR__ . "/controllers/DoctorController.php";

require_role("doctor");
$conn = get_db_connection();
$doctorId = current_user_id();

$rxMessage = doctor_write_prescription($conn, $doctorId);
$queue = get_queue_for_doctor_today($conn, $doctorId);

$pageTitle = "Write Prescription";
$theme = "doctor";
$active = "prescription";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/doctor/write-prescription.php";
require __DIR__ . "/views/partials/footer.php";
