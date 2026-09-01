<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/models/UserModel.php";
require_once __DIR__ . "/models/AppointmentModel.php";
require_once __DIR__ . "/controllers/PatientController.php";

require_role("patient");
$conn = get_db_connection();
$patientId = current_user_id();

[$bookMessage, $bookIsError] = patient_book_appointment($conn, $patientId);

$allDoctors = get_all_doctors($conn);
$upcoming = get_upcoming_appointments_by_patient($conn, $patientId);

$selectedDoctorId = (int) ($_POST["doctor_id"] ?? $_GET["doctor_id"] ?? 0);
$selectedDate = $_POST["appointment_date"] ?? date("Y-m-d");
$bookedSlots = $selectedDoctorId ? get_booked_slots($conn, $selectedDoctorId, $selectedDate) : [];

$pageTitle = "Book an Appointment";
$theme = "patient";
$active = "appointments";
require __DIR__ . "/views/partials/header.php";
require __DIR__ . "/views/patient/book-appointment.php";
require __DIR__ . "/views/partials/footer.php";
