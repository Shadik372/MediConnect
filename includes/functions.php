<?php
// Safely print a value into HTML (prevents XSS).
function e($value)
{
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}

// "Nabila Prasad" -> "NP", used for the little round avatar badges.
function initials($fullName)
{
    $parts = preg_split('/\s+/', trim($fullName));
    $letters = "";
    foreach ($parts as $p) {
        if ($p !== "") $letters .= strtoupper($p[0]);
        if (strlen($letters) >= 2) break;
    }
    return $letters === "" ? "?" : $letters;
}

// 13:05:00 -> 1:05 PM
function format_time($time)
{
    if (!$time) return "";
    return date("g:i A", strtotime($time));
}

// 2026-08-18 -> 18 Aug 2026
function format_date($date)
{
    if (!$date) return "";
    return date("d M Y", strtotime($date));
}

function tag_class($status)
{
    $confirmed = ["approved", "confirmed", "completed", "checked-in", "active", "in queue"];
    return in_array($status, $confirmed) ? "tag-confirmed" : "tag-pending";
}
