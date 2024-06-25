<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../../configs/config_url.php" ?>
    <?php include "../components/header.php" ?>
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
                <?php include "../components/navbar.php" ?>
            </nav>

            <?php include "../components/sidebar.php" ?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Selamat Datang Di ALS</h1>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <?php if (isset($_SESSION['validation_name'])) { ?>
                                    <div class="alert alert-info alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            <?= $_SESSION['validation_name'] ?> with order number
                                            <?= $_SESSION['order_number'] ?>
                                            <?php unset($_SESSION['validation_name']) ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Scan Order</h4>
                                    </div>
                                    <div class="card-body" style="margin-left: auto;margin-right: auto;">
                                        <div class="scanner-container">
                                            <video id="camera"></video>
                                            <div class="scanner-box"></div>
                                        </div>
                                        <p id="result" style="display: none;"></p>
                                        <p id="error-message" style="color: red;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <style>
            .scanner-container {
                position: relative;
                width: 300px;
                height: 300px;
                border: 1px solid;
                box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
                border-radius: 10px;
            }

            #camera {
                width: 100%;
                height: 100%;
                border-radius: 10px;
                object-fit: cover;
            }

            .scanner-box {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 60%;
                height: 60%;
                border: 2px dashed #00FF00;
                transform: translate(-50%, -50%);
                box-sizing: border-box;
            }
        </style>

        <div class="section-body">
        </div>
        </section>
    </div>
    <?php include "../components/footer.php" ?>
    </div>
    </div>

    <?php include "../components/script.php" ?>

    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <script>
        window.addEventListener('load', function() {
            const codeReader = new ZXing.BrowserMultiFormatReader();
            const videoElement = document.getElementById('camera');
            const resultElement = document.getElementById('result');
            const errorMessageElement = document.getElementById('error-message');

            if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) {
                errorMessageElement.textContent = 'Enumerasi perangkat tidak didukung oleh browser ini.';
                return;
            }

            codeReader
                .listVideoInputDevices()
                .then(videoInputDevices => {
                    if (videoInputDevices.length === 0) {
                        errorMessageElement.textContent = 'Tidak ada perangkat video yang ditemukan.';
                        return;
                    }

                    const firstDeviceId = videoInputDevices[0].deviceId;
                    codeReader.decodeFromVideoDevice(firstDeviceId, 'camera', (result, err) => {
                        if (result) {
                            resultElement.textContent = result.text;
                            console.log(result);

                            const currentDomain = window.location.origin;
                            const targetUrl = `${currentDomain}/controllers/OrderController.php?action=verified&id=${result.text}`;
                            window.location.href = targetUrl;
                        }
                        if (err && !(err instanceof ZXing.NotFoundException)) {
                            console.error(err);
                            errorMessageElement.textContent = err.message;
                        }
                    });
                })
                .catch(err => {
                    console.error(err);
                    errorMessageElement.textContent = 'Tidak dapat enumerasi perangkat: ' + err.message;
                });
        });
    </script>

</body>

</html>