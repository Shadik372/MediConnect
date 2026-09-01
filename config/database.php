<?php
/*
 * Database connection, wrapped in a function as requested.
 * XAMPP defaults: host=localhost, user=root, password=''
 * Create the "mediconnect" database + tables manually first
 * using sql/schema.sql in phpMyAdmin.
 */
function get_db_connection()
{
    static $conn = null; // reuse the same connection for the whole request

    if ($conn === null) {
        $host   = "localhost";
        $dbUser = "root";
        $dbPass = "";
        $dbName = "mediconnect";

        $conn = mysqli_connect($host, $dbUser, $dbPass, $dbName);

        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }
    }

    return $conn;
}
