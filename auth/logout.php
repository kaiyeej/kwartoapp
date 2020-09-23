<?php 
require_once '../core/config.php';

unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['user_fname']);
unset($_SESSION['user_mname']);
unset($_SESSION['user_lname']);
unset($_SESSION['user_categ']);

unset($_SESSION['error']);
session_destroy();
header("Location: ../index.php");