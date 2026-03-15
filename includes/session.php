<?php

session_start(); // Start/renew session
$logged_in = $_SESSION["logged_in"] ?? false; // Is user logged in?

function login($user)
{
    // Remember user passed login
    session_regenerate_id(true); // Update session id

    $_SESSION["logged_in"] = true; // Set logged_in key to true
    $_SESSION["username"] = $user["username"]; // Set username key to username from database
    $_SESSION["custID"] = $user["custID"]; // Set custID key to custID from database
}

function require_login($logged_in)
{
    // Check if user logged in
    if ($logged_in == false) {
        // If not logged in
        header("Location: login.php"); // Send to login page
        exit(); // Stop rest of page running
    }
}

function logout()
{
    // Terminate the session
    $_SESSION = []; // Clear contents of array
    $params = session_get_cookie_params(); // Get session cookie parameters

    // Delete session cookie
    setcookie(
        "PHPSESSID",
        "",
        time() - 3600,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"],
    );

    session_destroy(); // Delete session file
}

function authenticate(PDO $pdo, string $username, string $password)
{
    // SQL query to find customer matching username and password
    $sql = "SELECT *
					FROM customer
					WHERE username = :username AND password = :password;";

    // Execute the SQL query using the pdo function and fetch the result
    $user = pdo($pdo, $sql, [
        "username" => $username,
        "password" => $password,
    ])->fetch();

    return $user; // Return the user row if found, or false if not found
}

?>
