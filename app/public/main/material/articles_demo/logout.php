<?php
session_start();
session_destroy();
header("Location: articles.php");
exit;