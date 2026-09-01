<?php
// ------------------------------------------------------------
// ScheduleModel: a doctor's weekly available hours.
// ------------------------------------------------------------

function get_schedule_for_doctor($conn, $doctorId)
{
    $order = "FIELD(day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')";
    $sql = "SELECT * FROM doctor_schedule WHERE doctor_id = ? ORDER BY $order";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $doctorId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function update_schedule_day($conn, $doctorId, $day, $isAvailable, $startTime, $endTime)
{
    $sql = "UPDATE doctor_schedule SET is_available = ?, start_time = ?, end_time = ?
            WHERE doctor_id = ? AND day_of_week = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issis", $isAvailable, $startTime, $endTime, $doctorId, $day);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
