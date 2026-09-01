<?php
// ActivityModel: the admin "System Activity" log.
function log_activity($conn, $userId, $description, $type)
{
    $sql = "INSERT INTO activity_log (user_id, description, activity_type) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iss", $userId, $description, $type);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function get_recent_activity($conn, $limit = 25)
{
    $sql = "SELECT al.*, u.full_name
            FROM activity_log al
            LEFT JOIN users u ON u.id = al.user_id
            ORDER BY al.created_at DESC
            LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function count_activity_today($conn)
{
    $result = mysqli_query($conn, "SELECT COUNT(*) AS c FROM activity_log WHERE DATE(created_at) = CURDATE()");
    return (int) mysqli_fetch_assoc($result)["c"];
}

function count_errors_today($conn)
{
    $result = mysqli_query($conn, "SELECT COUNT(*) AS c FROM activity_log WHERE activity_type='error' AND DATE(created_at) = CURDATE()");
    return (int) mysqli_fetch_assoc($result)["c"];
}
