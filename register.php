<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/controllers/AuthController.php";

$conn = get_db_connection();
$registerErrors = register_action($conn);

require __DIR__ . "/views/auth/register.php";
