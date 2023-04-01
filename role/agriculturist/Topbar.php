<?php
    // session_start();
    require_once 'connect.php';
?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <label for="inputState" class="form-label" style="font-size: 2rem;" >ระบบจัดการข้อมูลการเลี้ยงแพะ จังหวัดสุราษฎร์ธานี</label>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                            placeholder="Search for..." aria-label="Search"
                            aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                    // session_start();
                    $id = $_SESSION["id"];
                    // echo $id;
                    $select_stmt = $db->query("SELECT `agc_name`,`agc_nfarm`,`agc_img` 
                                                FROM `agriculturist` 
                                                INNER JOIN `user_login` ON user_login.agc_id = agriculturist.agc_id
                                                WHERE user_login.user_id = '$id'");
                    $select_stmt->execute(); 
                    $logins = $select_stmt->fetchAll();
                    foreach($logins as $login){
                ?>
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small text-right">
                        <?= $login["agc_name"]; ?>
                        <br>
                        <?= $login["agc_nfarm"]; ?>
                    </span>
                    <img class="img-profile rounded-circle" src="../admin/uploads/<?= $login["agc_img"]; ?>">
                <?php
                    } 
                ?>
            </a>

        </li>
    </ul>
</nav>