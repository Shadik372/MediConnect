<?php
require_once __DIR__ . "/../models/UserModel.php";
require_once __DIR__ . "/../models/ActivityModel.php";

function admin_handle_doctor_approval($conn)
{
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user_id"], $_POST["action"])) {
        $userId = (int) $_POST["user_id"];
        $status = $_POST["action"] === "approve" ? "approved" : "rejected";
        update_user_status($conn, $userId, $status);
        log_activity($conn, current_user_id(), "Doctor account #$userId $status", "registration");
    }
}

function admin_handle_user_management($conn)
{
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user_id"], $_POST["manage_action"])) {
        $userId = (int) $_POST["user_id"];
        if ($_POST["manage_action"] === "deactivate") {
            update_user_status($conn, $userId, "rejected");
        } elseif ($_POST["manage_action"] === "activate") {
            update_user_status($conn, $userId, "approved");
        } elseif ($_POST["manage_action"] === "delete") {
            delete_user($conn, $userId);
        }
    }
}

function admin_search_users($conn)
{
    $keyword = trim($_GET["q"] ?? "");
    $role    = trim($_GET["role"] ?? "");
    if ($keyword !== "" || $role !== "") {
        return search_users($conn, $keyword, $role);
    }
    return get_all_users($conn);
}
