<?php
// Start (or resume) the session on every page that includes this file.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in()
{
    return isset($_SESSION["user_id"]);
}

// Send visitor to login.php if they are not logged in.
function require_login()
{
    if (!is_logged_in()) {
        header("Location: login.php");
        exit();
    }
}

// Send visitor to login.php if they are not logged in OR not one of the allowed roles.
function require_role($allowedRoles)
{
    require_login();
    if (!in_array($_SESSION["role"], (array) $allowedRoles)) {
        header("Location: login.php");
        exit();
    }
}

function current_user_id()
{
    return $_SESSION["user_id"] ?? null;
}

function current_role()
{
    return $_SESSION["role"] ?? null;
}

function current_name()
{
    return $_SESSION["full_name"] ?? "";
}

// Send the user to the dashboard that matches their role.
function redirect_to_dashboard($role)
{
    switch ($role) {
        case "doctor":
            header("Location: dashboard-doctor.php");
            break;
        case "receptionist":
            header("Location: dashboard-receptionist.php");
            break;
        case "admin":
            header("Location: dashboard-admin.php");
            break;
        default:
            header("Location: dashboard-patient.php");
    }
    exit();
}
