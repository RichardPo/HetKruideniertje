<?php

    include "includes/header.inc.php";

    if(!isset($_SESSION["user"])) {
        header("Location: index.php");
        exit();
    } else {
        if($_SESSION["user"]["role"] != "admin") {
            header("Location: kassa.php");
            exit();
        } 
    }

?>

<div class="beheer-header center">Camerameldingen</div>

<div class="beheer-main">
    <div class="beheer-sidebar">
        <div class="sidebar-item center-vertical" onclick="location.href = 'logout.php';">
            <div class="sidebar-item-icon center"><i class="fas fa-user-circle"></i></div>
            <div class="sidebar-item-text">Uitloggen</div>
        </div>
        <div class="sidebar-item center-vertical" onclick="location.href = 'voorraad.php';">
            <div class="sidebar-item-icon center"><i class="fas fa-cubes"></i></div>
            <div class="sidebar-item-text">Voorraad</div>
        </div>
        <div class="sidebar-item center-vertical" onclick="location.href = 'team.php';">
            <div class="sidebar-item-icon center"><i class="fas fa-users"></i></div>
            <div class="sidebar-item-text">Team</div>
        </div>
        <div class="sidebar-item center-vertical" onclick="location.href = 'kassa.php';">
            <div class="sidebar-item-icon center"><i class="fas fa-cash-register"></i></div>
            <div class="sidebar-item-text">Kassa</div>
        </div>
        <div class="sidebar-item center-vertical" onclick="location.href = 'camera.php';">
            <div class="sidebar-item-icon center"><i class="fas fa-camera"></i></div>
            <div class="sidebar-item-text">Camera</div>
        </div>
    </div>
    <div class="beheer-content">
        <div class="meldingen">
            <?php
            
                $json = file_get_contents("https://martenbiesheuvel.nl/hoornbeeckhelden/security_log.json");
                $data = json_decode($json, TRUE);

                foreach($data as $item) {
                    echo "
                        <div class='product'>
                            <table>
                                <tr>
                                    <td><b>Camera:</b></td>
                                    <td>" . $item["camera"] . "</td>
                                </tr>
                                <tr>
                                    <td><b>Tijd:</b></td>
                                    <td>" . $item["datetime"] . "</td>
                                </tr>
                                <tr>
                                    <td><b>Bericht:</b></td>
                                    <td>" . $item["message"] . "</td>
                                </tr>
                            </table>
                        </div>
                    ";
                }
            
            ?>
        </div>
    </div>
</div>