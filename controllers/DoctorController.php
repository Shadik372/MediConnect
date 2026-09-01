<?php
require_once __DIR__ . "/../models/AppointmentModel.php";
require_once __DIR__ . "/../models/PrescriptionModel.php";
require_once __DIR__ . "/../models/ScheduleModel.php";
require_once __DIR__ . "/../models/ActivityModel.php";

// Doctor ticks "Start" in the queue -> mark checked-in patient as being seen (no-op status change kept simple)
function doctor_handle_queue_action($conn, $doctorId)
{
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["appointment_id"], $_POST["new_status"])) {
        update_appointment_status($conn, (int) $_POST["appointment_id"], $_POST["new_status"]);
    }
}

function doctor_write_prescription($conn, $doctorId)
{
    $message = null;

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["issue_prescription"])) {
        $appointmentId = !empty($_POST["appointment_id"]) ? (int) $_POST["appointment_id"] : null;
        $patientId     = (int) $_POST["patient_id"];
        $diagnosis     = trim($_POST["diagnosis"] ?? "");
        $dateIssued    = $_POST["date_issued"] ?? date("Y-m-d");

        $medNames    = $_POST["medicine_name"] ?? [];
        $medDosages  = $_POST["dosage"] ?? [];
        $medDurations = $_POST["duration"] ?? [];

        $prescriptionId = create_prescription($conn, $appointmentId, $doctorId, $patientId, $diagnosis, $dateIssued);

        for ($i = 0; $i < count($medNames); $i++) {
            if (trim($medNames[$i]) === "") continue;
            add_prescription_medicine($conn, $prescriptionId, trim($medNames[$i]), trim($medDosages[$i] ?? ""), trim($medDurations[$i] ?? ""));
        }

        if ($appointmentId) {
            update_appointment_status($conn, $appointmentId, "completed");
        }

        log_activity($conn, $doctorId, "Prescription issued", "booking");
        $message = "Prescription #RX-" . str_pad($prescriptionId, 4, "0", STR_PAD_LEFT) . " issued and saved to the patient's account.";
    }

    return $message;
}

function doctor_save_schedule($conn, $doctorId)
{
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["save_schedule"])) {
        $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        foreach ($days as $day) {
            $key = strtolower($day);
            $isAvailable = isset($_POST["available_$key"]) ? 1 : 0;
            $start = $_POST["start_$key"] ?? "09:00";
            $end   = $_POST["end_$key"] ?? "17:00";
            update_schedule_day($conn, $doctorId, $day, $isAvailable, $start, $end);
        }
        return "Schedule saved.";
    }
    return null;
}
