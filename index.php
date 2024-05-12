<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once "configs/connection.php"; ?>
  <?php include "configs/config_url.php" ?>
  <?php include "components/header.php" ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <!-- <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li> -->
          </ul>
        </form>
        <?php include "components/navbar.php" ?>
      </nav>

      <?php include "components/sidebar.php" ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Selamat Datang Di ALS</h1>
          </div>

          <div class="section-body">
            <h2 class="section-title">Mau pergi kemana Hari ini?</h2>
            <p class="section-lead">Silahkan isi tujuan keberangkatan anda!</p>

            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <form method="POST" action="<?= $config['base_url'] . 'controllers/DepartureController.php?action=search' ?>" class="needs-validation" novalidate="">

                      <div class="form-group">
                        <label>Dari</label>
                        <select class="form-control" name="from_province_id">
                          <option value="1">Medan</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Tujuan</label>
                        <?php
                        $stmt = $pdo->prepare("select * from provinces where not id=:id");
                        $stmt->execute(['id' => 1]);

                        $provinces = $stmt->fetchAll();

                        ?>
                        <select class="form-control" name="to_province_id">

                          <?php foreach ($provinces as $key => $value) {
                          ?>
                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Tanggal Berangkat</label>
                        <?php
                        $stmt = $pdo->prepare("SELECT * FROM cart_departures WHERE user_id = :user_id");
                        $stmt->execute([':user_id' => $_SESSION['id']]);
                        $cart = $stmt->fetch();

                        ?>
                        <input type="date" class="form-control" value="<?= $cart['date_departure'] ?? '' ?>" name="date_departure" required autofocus>

                        <div class="invalid-feedback">
                          Silahkan isi tanggal keberangkatan anda
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Jumlah Penumpang</label>
                        <input type="number" class="form-control" value="<?= $cart['quantity'] ?? '' ?>" name="quantity" min="1" required autofocus>
                        <div class="invalid-feedback">
                          Silahkan isi jumlah penumpang
                        </div>
                      </div>

                      <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Cari</button>
                    </form>

                  </div>
                </div>
              </div>

            </div>
          </div>
        </section>
      </div>
    </div>

    <div class="section-body">
    </div>
    </section>
  </div>
  <?php include "components/" ?>
  </div>
  </div>

  <?php include "components/script.php" ?>

</body>

</html>