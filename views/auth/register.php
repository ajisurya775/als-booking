<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); ?>
    <?php include "../../configs/config_url.php" ?>
    <?php include "../components/header.php" ?>
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <h3>ALS BOOKING TICKET</h3>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Login</h4>

                            </div>

                            <div class="card-body">

                                <?php if (isset($_SESSION['error']) && $_SESSION['error']) { ?>
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            <?= $_SESSION['error'] ?>
                                            <?php unset($_SESSION['error']) ?>
                                        </div>
                                    </div>
                                <?php } ?>


                                <form method="POST" action="<?= $config['base_url'] . 'controllers/AuthController.php?action=register' ?>" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input id="name" type="name" class="form-control" value="<?= $_SESSION['register_form']['name'] ?? '' ?>" name="name" tabindex="1" required autofocus>
                                        <div class="invalid-feedback">
                                            Please fill in your name
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" value="<?= $_SESSION['register_form']['email'] ?? '' ?>" name="email" tabindex="1" required autofocus>
                                        <div class="invalid-feedback">
                                            Please fill in your email
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                        <div class="invalid-feedback">
                                            please fill in your password
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password Confirmation</label>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password_confirm" tabindex="2" required>
                                        <div class="invalid-feedback">
                                            please fill in your password Confirmation
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Register
                                        </button>
                                    </div>
                                    Already have account? <a href="<?= $config['base_url'] . 'auth/login.php' ?>">Login</a>

                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    </div>
    </div>

    <?php include "../components/script.php" ?>


</body>

</html>