<?php
require_once __DIR__ . "/../models/UserModel.php";
require_once __DIR__ . "/../models/AppointmentModel.php";
require_once __DIR__ . "/../models/ActivityModel.php";

// Confirm / decline a pending appointment
function receptionist_handle_confirmation($conn)
{
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["appointment_id"], $_POST["action"])) {
        $id = (int) $_POST["appointment_id"];
        $status = $_POST["action"] === "confirm" ? "confirmed" : "cancelled";
        update_appointment_status($conn, $id, $status);
        log_activity($conn, current_user_id(), "Appointment #$id $status", "booking");
    }
}

// Mark a patient as checked-in
function receptionist_handle_checkin($conn)
{
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["appointment_id"], $_POST["checkin"])) {
        update_appointment_status($conn, (int) $_POST["appointment_id"], "checked-in");
    }
}

// Register a walk-in patient: create a lightweight patient user (if new) + an appointment for right now
function receptionist_register_walkin($conn)
{
    $message = null;

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register_walkin"])) {
        $name   = trim($_POST["patient_name"] ?? "");
        $phone  = trim($_POST["phone"] ?? "");
        $doctorId = (int) ($_POST["doctor_id"] ?? 0);
        $reason = trim($_POST["reason"] ?? "");

        if ($name === "" || $phone === "" || $doctorId <= 0) {
            $message = ["Please fill in patient name, phone, and doctor.", true];
        } else {
            // walk-ins get a placeholder account so they still show up in "patients"
            $placeholderEmail = "walkin_" . time() . rand(100, 999) . "@mediconnect.local";
            $passwordHash = password_hash(bin2hex(random_bytes(4)), PASSWORD_DEFAULT);
            $patientId = create_user($conn, $name, $placeholderEmail, $phone, $passwordHash, "patient", "approved");
            create_patient_profile($conn, $patientId, null);

            create_appointment($conn, $patientId, $doctorId, date("Y-m-d"), date("H:i:s"), "walk-in", $reason, "checked-in");
            log_activity($conn, current_user_id(), "$name registered as a walk-in", "booking");
            $message = ["$name has been registered and added to today's queue.", false];
        }
    }

    return $message;
}
