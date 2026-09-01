<?php
// ------------------------------------------------------------
// AppointmentModel: booking, confirming, checking in, queue,
// daily schedule overview.
// ------------------------------------------------------------

function create_appointment($conn, $patientId, $doctorId, $date, $time, $visitType, $reason, $status = "pending")
{
    $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, visit_type, reason, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iisssss", $patientId, $doctorId, $date, $time, $visitType, $reason, $status);
    mysqli_stmt_execute($stmt);
    $newId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    return $newId;
}

function get_appointments_by_patient($conn, $patientId)
{
    $sql = "SELECT a.*, u.full_name AS doctor_name, dp.specialization
            FROM appointments a
            JOIN users u ON u.id = a.doctor_id
            LEFT JOIN doctor_profiles dp ON dp.user_id = u.id
            WHERE a.patient_id = ?
            ORDER BY a.appointment_date DESC, a.appointment_time DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $patientId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_upcoming_appointments_by_patient($conn, $patientId)
{
    $sql = "SELECT a.*, u.full_name AS doctor_name, dp.specialization
            FROM appointments a
            JOIN users u ON u.id = a.doctor_id
            LEFT JOIN doctor_profiles dp ON dp.user_id = u.id
            WHERE a.patient_id = ? AND a.status IN ('pending','confirmed','checked-in')
            ORDER BY a.appointment_date, a.appointment_time";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $patientId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_completed_appointments_by_patient($conn, $patientId)
{
    $sql = "SELECT a.*, u.full_name AS doctor_name, dp.specialization
            FROM appointments a
            JOIN users u ON u.id = a.doctor_id
            LEFT JOIN doctor_profiles dp ON dp.user_id = u.id
            WHERE a.patient_id = ? AND a.status = 'completed'
            ORDER BY a.appointment_date DESC, a.appointment_time DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $patientId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_booked_slots($conn, $doctorId, $date)
{
    $sql = "SELECT appointment_time FROM appointments
            WHERE doctor_id = ? AND appointment_date = ? AND status != 'cancelled'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $doctorId, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $times = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $times[] = substr($row["appointment_time"], 0, 5); // HH:MM
    }
    mysqli_stmt_close($stmt);
    return $times;
}

function get_queue_for_doctor_today($conn, $doctorId)
{
    $sql = "SELECT a.*, u.full_name AS patient_name
            FROM appointments a
            JOIN users u ON u.id = a.patient_id
            WHERE a.doctor_id = ? AND a.appointment_date = CURDATE()
              AND a.status IN ('pending','confirmed','checked-in')
            ORDER BY a.appointment_time";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $doctorId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_pending_confirmations($conn)
{
    $sql = "SELECT a.*, p.full_name AS patient_name, d.full_name AS doctor_name
            FROM appointments a
            JOIN users p ON p.id = a.patient_id
            JOIN users d ON d.id = a.doctor_id
            WHERE a.status = 'pending'
            ORDER BY a.appointment_date, a.appointment_time";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_appointments_needing_checkin($conn)
{
    $sql = "SELECT a.*, p.full_name AS patient_name, d.full_name AS doctor_name
            FROM appointments a
            JOIN users p ON p.id = a.patient_id
            JOIN users d ON d.id = a.doctor_id
            WHERE a.appointment_date = CURDATE() AND a.status IN ('confirmed','checked-in')
            ORDER BY a.appointment_time";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_today_schedule_all($conn)
{
    $sql = "SELECT a.*, p.full_name AS patient_name, d.full_name AS doctor_name
            FROM appointments a
            JOIN users p ON p.id = a.patient_id
            JOIN users d ON d.id = a.doctor_id
            WHERE a.appointment_date = CURDATE()
            ORDER BY a.appointment_time";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function update_appointment_status($conn, $appointmentId, $status)
{
    $sql = "UPDATE appointments SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $appointmentId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function get_todays_walkins($conn)
{
    $sql = "SELECT a.*, p.full_name AS patient_name, d.full_name AS doctor_name
            FROM appointments a
            JOIN users p ON p.id = a.patient_id
            JOIN users d ON d.id = a.doctor_id
            WHERE a.visit_type = 'walk-in' AND a.appointment_date = CURDATE()
            ORDER BY a.created_at DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function count_today_appointments($conn)
{
    $result = mysqli_query($conn, "SELECT COUNT(*) AS c FROM appointments WHERE appointment_date = CURDATE()");
    return (int) mysqli_fetch_assoc($result)["c"];
}

function count_pending_confirmations($conn)
{
    $result = mysqli_query($conn, "SELECT COUNT(*) AS c FROM appointments WHERE status = 'pending'");
    return (int) mysqli_fetch_assoc($result)["c"];
}

function count_appointments_this_month($conn)
{
    $result = mysqli_query($conn, "SELECT COUNT(*) AS c FROM appointments
        WHERE MONTH(appointment_date) = MONTH(CURDATE()) AND YEAR(appointment_date) = YEAR(CURDATE())");
    return (int) mysqli_fetch_assoc($result)["c"];
}
