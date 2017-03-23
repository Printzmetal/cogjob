<?php

// Connect to the database. Returns a PDO object
function getDb() {
    // Local deployment
    $server = "localhost";
    $username = "cogjob_user";
    $password = "secret";
    $db = "cogjob";

    return new PDO("mysql:host=$server;dbname=$db;charset=utf8", "$username", "$password",
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

// Check if a user is connected
function isUserConnected() {
    return isset($_SESSION['mail']);
}

function createPassword($nbCaractere)
    {
        $password = "";
        for($i = 0; $i <= $nbCaractere; $i++)
        {
            $random = rand(97,122);
            $password .= chr($random);
        }
 
        return $password;
    }

// Redirect to a URL
function redirect($url) {
    header("Location: $url");
}

// Escape a value to prevent XSS attacks
function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}

