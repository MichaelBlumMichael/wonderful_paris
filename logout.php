<?php
session_start();
session_destroy();
header('location: index.php');
require_once 'app/helpers.php';
