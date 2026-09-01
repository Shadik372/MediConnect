<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/AppointmentModel.php";
require_once __DIR__ . "/controllers/ReceptionistController.php";

require_role("receptionist");
$conn = get_db_connection();

receptionist_handle_confirmation($conn);
$pending = get_pending_confirmations($conn);

$pageTitle = "Confirmations";
$theme = "receptionist";
$active = "confirmations";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/receptionist/confirmations.php";
require __DIR__ . "/views/partials/footer.php";
