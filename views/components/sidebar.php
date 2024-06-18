<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">ALS BOOKING</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>

            <?php if ($_SESSION['role'] == 'user') { ?>
                <li class=<?= $actual_link ==  $config['base_url'] ? 'active' : '' ?>><a class="nav-link" href="<?= $config['base_url'] ?>"><i class="fa fa-bus"></i> <span>Pesan Tiket</span></a></li>
                <li class=<?= strpos($actual_link, "views/transactions/") ? 'active' : '' ?>><a class="nav-link" href="<?= $config['base_url'] . 'views/transactions' ?>"><i class="far fa-credit-card"></i> <span>Transakasi</span></a></li>

            <?php } else { ?>

                <li class=<?= strpos($actual_link, "views/admin/dashboard/") ? 'active' : '' ?>><a class="nav-link" href="<?= $config['base_url'] . 'views/admin/dashboard' ?>"><i class="fa fa-safari" aria-hidden="true"></i><span>Dashboard</span></a></li>

                <li class="menu-header">Master Data</li>

                <li class=<?= strpos($actual_link, "views/admin/bus/") ? 'active' : '' ?>><a class="nav-link" href="<?= $config['base_url'] . 'views/admin/bus' ?>"><i class="fa fa-bus" aria-hidden="true"></i> <span>Bus</span></a></li>

                <!-- <li class=<?= strpos($actual_link, "views/admin/stations/") ? 'active' : '' ?>><a class="nav-link" href="<?= $config['base_url'] . 'views/admin/stations' ?>"><i class="fa fa-building" aria-hidden="true"></i> <span>Stations</span></a></li> -->

                <li class=<?= strpos($actual_link, "views/admin/departures/") ? 'active' : '' ?>><a class="nav-link" href="<?= $config['base_url'] . 'views/admin/departures' ?>"><i class="fa fa-map-marker" aria-hidden="true"></i><span>Departures</span></a></li>

                <li class=<?= strpos($actual_link, "views/admin/provinces/") ? 'active' : '' ?>><a class="nav-link" href="<?= $config['base_url'] . 'views/admin/provinces' ?>"><i class="fa fa-map" aria-hidden="true"></i> <span>Provinces</span></a></li>

                <li class=<?= strpos($actual_link, "views/admin/operating-schedules/") ? 'active' : '' ?>><a class="nav-link" href="<?= $config['base_url'] . 'views/admin/operating-schedules' ?>"><i class="fa fa-clock" aria-hidden="true"></i> <span>Operating Schedule</span></a></li>

                <li class="menu-header">Reports</li>
                <li class=<?= strpos($actual_link, "views/admin/sales/") ? 'active' : '' ?>><a class="nav-link" href="<?= $config['base_url'] . 'views/admin/sales' ?>"><i class="fa fa-book" aria-hidden="true"></i> <span>Sales</span></a></li>
            <?php } ?>
        </ul>
    </aside>
</div>