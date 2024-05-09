<!DOCTYPE html>
<html lang="en">

<head>
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
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
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
                    <div class="form-group">
                      <label>Dari</label>
                      <select class="form-control">
                        <option>Medan</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Tujuan</label>
                      <select class="form-control">
                        <option>Kenopan</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Orang Dewasa</label>
                      <input type="number" class="form-control">
                    </div>

                    <div class="form-group">
                      <label>Anak-anak</label>
                      <input type="number" class="form-control">
                    </div>

                    <button class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Hasil Pencarian</h4>
                  </div>
                  <div class="card-body">
                    <div class="section-title mt-0">Default</div>
                    <article class="article">
                      <div class="article-header">
                        <div class="article-image" data-background="assets/img/news/img08.jpg">
                        </div>
                        <div class="article-title">
                          <h2><a href="#">Medan Kenopan</a></h2>
                        </div>
                      </div>
                      <div class="article-details">
                        <p>Rp 500.000</p>
                        <p>Sisa 1 kursi</p>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                          cillum dolore eu fugiat nulla pariatur.
                        </p>
                        <div class="article-cta">
                          <a href="#" class="btn btn-primary">Pesan</a>
                        </div>
                      </div>
                    </article>
                    <article class="article">
                      <div class="article-header">
                        <div class="article-image" data-background="assets/img/news/img08.jpg">
                        </div>
                        <div class="article-title">
                          <h2><a href="#">Medan Kenopan</a></h2>
                        </div>
                      </div>
                      <div class="article-details">
                        <p>Rp 500.000</p>
                        <p>Sisa 1 kursi</p>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                          cillum dolore eu fugiat nulla pariatur.
                        </p>
                        <div class="article-cta">
                          <a href="#" class="btn btn-primary">Pesan</a>
                        </div>
                      </div>
                    </article>
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