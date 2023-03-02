<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>หน้าหลัก</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="Profile.php">
            <i class="fa-solid fa-user-pen"></i>
            <span>ประวัติส่วนตัว</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa-solid fa-file-pen"></i>
            <span>จัดการข้อมูล</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="Manage_agc.php">ข้อมูลเกษตรกร</a>
                <a class="collapse-item" href="Manage_food.php">ข้อมูลอาหาร</a>
                <a class="collapse-item" href="Manage_disease.php">ข้อมูลโรค</a>
                <a class="collapse-item" href="Manage_vm.php">ข้อมูลยาและวัคซีน</a>
                <a class="collapse-item" href="Manage_breed.php">ข้อมูลสายพันธุ์</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <!-- <i class="fas fa-fw fa-wrench"></i> -->
            <!-- <i class="fas fa-fw fa-cog"></i> -->
            <i class="fa-solid fa-folder"></i>
            <span>บันทึกข้อมูลการเลี้งแพะ</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="Save_Goat.php">บันทึกแพะขุน</a>
                <a class="collapse-item" href="Save_FMgoat.php">บันทึกแพะพ่อ-แม่พันธุ์</a>
                <a class="collapse-item" href="Save_feeding.php">การให้อาหาร</a>
                <a class="collapse-item" href="Save_VM.php">การให้ยาและวัคซีน</a>
                <a class="collapse-item" href="Save_disease.php">การเป็นโรค</a>
                <a class="collapse-item" href="Save_money.php">รายรับ-รายจ่าย</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fa-solid fa-basket-shopping"></i>
            <span>การขายแพะ</span></a>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>การออกรายงาน</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a class="nav-link" href="logout.php" data-toggle="modal" data-target="#logoutModal">
            <!-- <i class='bx bx-log-out bx-sm'></i> -->
            <i class="fas fa-fw fa-solid fa-arrow-right-from-bracket"></i>
            <span>ออกจากระบบ</span>
        </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ออกจากระบบ</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">คุณต้องการที่จะออกระบบหรือไม่</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                <a class="btn btn-danger" href="logout.php">ออกจากระบบ</a>
            </div>
        </div>
    </div>
</div>