<?php
// ------------------------------------------------------------
// UserModel: every query that touches users / patient_profiles
// / doctor_profiles lives here. Controllers call these
// functions instead of writing SQL themselves.
// ------------------------------------------------------------

function create_user($conn, $fullName, $email, $phone, $passwordHash, $role, $status)
{
    $sql = "INSERT INTO users (full_name, email, phone, password, role, status)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $fullName, $email, $phone, $passwordHash, $role, $status);
    mysqli_stmt_execute($stmt);
    $newId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    return $newId;
}

function get_user_by_email($conn, $email)
{
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $user; // null if not found
}

function get_user_by_id($conn, $id)
{
    $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $user;
}

function get_all_users($conn)
{
    $sql = "SELECT * FROM users ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function search_users($conn, $keyword, $role)
{
    $keyword = "%" . $keyword . "%";
    if ($role !== "" && $role !== "All roles") {
        $sql = "SELECT * FROM users WHERE (full_name LIKE ? OR email LIKE ?) AND role = ?
                ORDER BY created_at DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $keyword, $keyword, $role);
    } else {
        $sql = "SELECT * FROM users WHERE full_name LIKE ? OR email LIKE ? ORDER BY created_at DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $keyword, $keyword);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function update_user_status($conn, $userId, $status)
{
    $sql = "UPDATE users SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function delete_user($conn, $userId)
{
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function update_user_profile($conn, $userId, $fullName, $email, $phone)
{
    $sql = "UPDATE users SET full_name = ?, email = ?, phone = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $fullName, $email, $phone, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function update_user_password($conn, $userId, $passwordHash)
{
    $sql = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $passwordHash, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// ---------------- Patient profile ----------------

function create_patient_profile($conn, $userId, $dob)
{
    $sql = "INSERT INTO patient_profiles (user_id, dob) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $userId, $dob);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function get_patient_profile($conn, $userId)
{
    $sql = "SELECT * FROM patient_profiles WHERE user_id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row;
}

// ---------------- Doctor profile ----------------

function create_doctor_profile($conn, $userId, $specialization)
{
    $sql = "INSERT INTO doctor_profiles (user_id, specialization) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $userId, $specialization);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // give every new doctor a default Mon-Fri 9-5 schedule row so the
    // schedule page has something to show/edit immediately.
    $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    foreach ($days as $day) {
        $available = in_array($day, ["Saturday", "Sunday"]) ? 0 : 1;
        $sql2 = "INSERT INTO doctor_schedule (doctor_id, day_of_week, is_available) VALUES (?, ?, ?)";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "isi", $userId, $day, $available);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    }
}

function get_doctor_profile($conn, $userId)
{
    $sql = "SELECT u.*, dp.specialization, dp.experience_years, dp.rating
            FROM users u JOIN doctor_profiles dp ON dp.user_id = u.id
            WHERE u.id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row;
}

function get_all_doctors($conn, $onlyApproved = true)
{
    $sql = "SELECT u.*, dp.specialization, dp.experience_years, dp.rating
            FROM users u JOIN doctor_profiles dp ON dp.user_id = u.id
            WHERE u.role = 'doctor'" . ($onlyApproved ? " AND u.status = 'approved'" : "") . "
            ORDER BY u.full_name";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function search_doctors($conn, $keyword, $specialization)
{
    $keyword = "%" . $keyword . "%";
    $sql = "SELECT u.*, dp.specialization, dp.experience_years, dp.rating
            FROM users u JOIN doctor_profiles dp ON dp.user_id = u.id
            WHERE u.role = 'doctor' AND u.status = 'approved' AND u.full_name LIKE ?";
    $params = [$keyword];
    $types = "s";
    if ($specialization !== "" && $specialization !== "All specializations") {
        $sql .= " AND dp.specialization = ?";
        $params[] = $specialization;
        $types .= "s";
    }
    $sql .= " ORDER BY u.full_name";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_pending_doctors($conn)
{
    $sql = "SELECT u.*, dp.specialization
            FROM users u JOIN doctor_profiles dp ON dp.user_id = u.id
            WHERE u.role = 'doctor' AND u.status = 'pending'
            ORDER BY u.created_at";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function count_users_by_role($conn, $role)
{
    $sql = "SELECT COUNT(*) AS c FROM users WHERE role = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $role);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return (int) $row["c"];
}

function count_all_users($conn)
{
    $result = mysqli_query($conn, "SELECT COUNT(*) AS c FROM users");
    return (int) mysqli_fetch_assoc($result)["c"];
}
