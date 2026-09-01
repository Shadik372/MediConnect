<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/UserModel.php";
require_once __DIR__ . "/models/AppointmentModel.php";
require_once __DIR__ . "/controllers/ReceptionistController.php";

require_role("receptionist");
$conn = get_db_connection();

$walkinResult = receptionist_register_walkin($conn);
$walkinMessage = $walkinResult[0] ?? null;
$walkinIsError = $walkinResult[1] ?? false;

$allDoctors = get_all_doctors($conn);
$todaysWalkins = get_todays_walkins($conn);

$pageTitle = "Walk-in Registration";
$theme = "receptionist";
$active = "walkin";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/receptionist/walkin.php";
require __DIR__ . "/views/partials/footer.php";
