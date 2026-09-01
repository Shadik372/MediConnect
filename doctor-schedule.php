<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/ScheduleModel.php";
require_once __DIR__ . "/controllers/DoctorController.php";

require_role("doctor");
$conn = get_db_connection();
$doctorId = current_user_id();

$scheduleMessage = doctor_save_schedule($conn, $doctorId);
$schedule = get_schedule_for_doctor($conn, $doctorId);

$pageTitle = "My Schedule";
$theme = "doctor";
$active = "schedule";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/doctor/schedule.php";
require __DIR__ . "/views/partials/footer.php";
