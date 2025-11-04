<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}
require_once 'login.php';
// The rest of this file will not be shown, as login.php handles the form and logic. 