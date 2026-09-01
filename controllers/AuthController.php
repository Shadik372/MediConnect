<?php
require_once __DIR__ . "/../models/UserModel.php";
require_once __DIR__ . "/../models/ActivityModel.php";

function register_action($conn)
{
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $fullName = trim($_POST["fname"] ?? "");
        $phone    = trim($_POST["phone"] ?? "");
        $email    = trim($_POST["remail"] ?? "");
        $password = $_POST["pass"] ?? "";
        $confirm  = $_POST["re_pass"] ?? "";
        $role     = $_POST["role"] ?? "patient";
        $dob      = $_POST["dob"] ?? null;
        $spec     = $_POST["spec"] ?? null;

        // ---- basic server-side validation (mirrors the client-side rules) ----
        if ($fullName === "" || $phone === "" || $email === "" || $password === "" || $confirm === "") {
            $errors[] = "All fields are required.";
        }
        if (strlen($fullName) > 50) {
            $errors[] = "Name is too long.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address.";
        }
        if (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters.";
        }
        if ($password !== $confirm) {
            $errors[] = "Passwords do not match.";
        }
        if (!in_array($role, ["patient", "doctor", "receptionist", "admin"])) {
            $errors[] = "Invalid role selected.";
        }
        if (empty($errors) && get_user_by_email($conn, $email)) {
            $errors[] = "An account with this email already exists.";
        }

        if (empty($errors)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // doctors need admin approval before they can log in; everyone else is active right away
            $status = ($role === "doctor") ? "pending" : "approved";

            $userId = create_user($conn, $fullName, $email, $phone, $passwordHash, $role, $status);

            if ($role === "patient") {
                create_patient_profile($conn, $userId, $dob !== "" ? $dob : null);
            } elseif ($role === "doctor") {
                create_doctor_profile($conn, $userId, $spec !== "" ? $spec : "General Physician");
            }

            log_activity($conn, $userId, "$fullName registered as $role", "registration");

            if ($role === "doctor") {
                $_SESSION["flash"] = "Account created! A doctor account needs admin approval before you can log in.";
                header("Location: login.php");
                exit();
            }

            // log the new user straight in
            $_SESSION["user_id"]   = $userId;
            $_SESSION["role"]      = $role;
            $_SESSION["full_name"] = $fullName;
            redirect_to_dashboard($role);
        }
    }

    return $errors;
}

function login_action($conn)
{
    $error = "";

    if (is_logged_in()) {
        redirect_to_dashboard(current_role());
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email    = trim($_POST["email"] ?? "");
        $password = $_POST["password"] ?? "";
        $remember = isset($_POST["remember"]);

        $user = get_user_by_email($conn, $email);

        if ($user && password_verify($password, $user["password"])) {
            if ($user["role"] === "doctor" && $user["status"] === "pending") {
                $error = "Your doctor account is still awaiting admin approval.";
            } elseif ($user["status"] === "rejected") {
                $error = "This account has been deactivated. Contact an administrator.";
            } else {
                $_SESSION["user_id"]   = $user["id"];
                $_SESSION["role"]      = $user["role"];
                $_SESSION["full_name"] = $user["full_name"];

                if ($remember) {
                    // simple 30-day "remember me" cookie, as taught: just the email, not the password
                    setcookie("remember_email", $email, time() + (86400 * 30), "/");
                }

                log_activity($conn, $user["id"], $user["full_name"] . " logged in", "login");
                redirect_to_dashboard($user["role"]);
            }
        } else {
            $error = "Invalid email or password.";
            log_activity($conn, null, "Failed login attempt for $email", "error");
        }
    }

    return $error;
}

function logout_action()
{
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
