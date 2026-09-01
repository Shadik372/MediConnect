<?php
// ------------------------------------------------------------
// PrescriptionModel: writing prescriptions + their medicine
// lines, and reading them back for patients/doctors.
// ------------------------------------------------------------

function create_prescription($conn, $appointmentId, $doctorId, $patientId, $diagnosis, $dateIssued)
{
    $sql = "INSERT INTO prescriptions (appointment_id, doctor_id, patient_id, diagnosis, date_issued)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiiss", $appointmentId, $doctorId, $patientId, $diagnosis, $dateIssued);
    mysqli_stmt_execute($stmt);
    $newId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    return $newId;
}

function add_prescription_medicine($conn, $prescriptionId, $name, $dosage, $duration)
{
    $sql = "INSERT INTO prescription_medicines (prescription_id, medicine_name, dosage, duration)
            VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $prescriptionId, $name, $dosage, $duration);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function get_prescriptions_by_patient($conn, $patientId)
{
    $sql = "SELECT pr.*, u.full_name AS doctor_name
            FROM prescriptions pr
            JOIN users u ON u.id = pr.doctor_id
            WHERE pr.patient_id = ?
            ORDER BY pr.date_issued DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $patientId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_medicines_for_prescription($conn, $prescriptionId)
{
    $sql = "SELECT * FROM prescription_medicines WHERE prescription_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $prescriptionId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

// short comma separated medicine list, used on the prescriptions table
function get_medicine_names_string($conn, $prescriptionId)
{
    $meds = get_medicines_for_prescription($conn, $prescriptionId);
    $names = array_map(fn($m) => $m["medicine_name"], $meds);
    return implode(", ", $names);
}

function get_patients_for_doctor($conn, $doctorId)
{
    // distinct patients this doctor has ever had an appointment with,
    // with their visit count and last visit date - used on Patient Records
    $sql = "SELECT u.id, u.full_name,
                   COUNT(a.id) AS total_visits,
                   MAX(CASE WHEN a.status='completed' THEN a.appointment_date END) AS last_visit
            FROM appointments a
            JOIN users u ON u.id = a.patient_id
            WHERE a.doctor_id = ?
            GROUP BY u.id, u.full_name
            ORDER BY u.full_name";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $doctorId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}
