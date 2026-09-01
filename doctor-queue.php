<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/AppointmentModel.php";
require_once __DIR__ . "/controllers/DoctorController.php";

require_role("doctor");
$conn = get_db_connection();
$doctorId = current_user_id();

doctor_handle_queue_action($conn, $doctorId);
$queue = get_queue_for_doctor_today($conn, $doctorId);

$pageTitle = "Patient Queue";
$theme = "doctor";
$active = "queue";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/doctor/queue.php";
require __DIR__ . "/views/partials/footer.php";
