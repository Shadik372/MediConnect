<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/UserModel.php";
require_once __DIR__ . "/controllers/AdminController.php";

require_role("admin");
$conn = get_db_connection();

admin_handle_doctor_approval($conn);
$pendingDoctors = get_pending_doctors($conn);

$pageTitle = "Doctor Approvals";
$theme = "admin";
$active = "approvals";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/admin/approvals.php";
require __DIR__ . "/views/partials/footer.php";
