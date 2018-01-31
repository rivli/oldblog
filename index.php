<?php
session_start();
if ($_SESSION['upost'] == 'admin') {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
}
require_once 'application/bootstrap.php';
