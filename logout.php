<?php

    include "includes/header.inc.php";

    session_destroy();

    header("Location: login.php");

?>