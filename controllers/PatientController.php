<?php
require_once __DIR__ . "/../models/UserModel.php";
require_once __DIR__ . "/../models/AppointmentModel.php";
require_once __DIR__ . "/../models/PrescriptionModel.php";
require_once __DIR__ . "/../models/ActivityModel.php";

function patient_find_doctors($conn)
{
    $keyword = trim($_GET["q"] ?? "");
    $spec    = trim($_GET["spec"] ?? "");

    if ($keyword !== "" || $spec !== "") {
        return search_doctors($conn, $keyword, $spec);
    }
    return get_all_doctors($conn);
}

// Handles the "book appointment" POST and returns a [message, isError] pair
function patient_book_appointment($conn, $patientId)
{
    $message = null;
    $isError = false;

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["book_appointment"])) {
        $doctorId  = (int) ($_POST["doctor_id"] ?? 0);
        $date      = $_POST["appointment_date"] ?? "";
        $time      = $_POST["appointment_time"] ?? "";
        $visitType = $_POST["visit_type"] ?? "in-clinic";
        $reason    = trim($_POST["reason"] ?? "");

        if ($doctorId <= 0 || $date === "" || $time === "") {
            $message = "Please choose a doctor, date, and time slot.";
            $isError = true;
        } else {
            $taken = get_booked_slots($conn, $doctorId, $date);
            if (in_array(substr($time, 0, 5), $taken)) {
                $message = "That slot was just taken. Please pick another.";
                $isError = true;
            } else {
                create_appointment($conn, $patientId, $doctorId, $date, $time, $visitType, $reason, "pending");
                log_activity($conn, $patientId, "Appointment booked", "booking");
                $message = "Appointment requested! You'll see it as 'Awaiting confirmation' until the front desk confirms it.";
            }
        }
    }

    return [$message, $isError];
}
