<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/AppointmentModel.php";
require_once __DIR__ . "/controllers/ReceptionistController.php";

require_role("receptionist");
$conn = get_db_connection();

receptionist_handle_checkin($conn);
$todaysAppointments = get_appointments_needing_checkin($conn);

$pageTitle = "Patient Check-in";
$theme = "receptionist";
$active = "checkin";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/receptionist/checkin.php";
require __DIR__ . "/views/partials/footer.php";
