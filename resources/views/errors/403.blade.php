<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('backend/assets/images/favicon-32x32.png') }}" type="image/png" />

    <!-- Loader -->
    <link href="{{ asset('backend/assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('backend/assets/js/pace.min.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/bootstrap-extended.css') }}" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!-- App CSS -->
    <link href="{{ asset('backend/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/icons.css') }}" rel="stylesheet">

    <title>403 Page</title>
</head>

@php
    $setting = App\Models\SiteSetting::find(1);
    $fb = $setting->facebook ?? '#';
    $tt = $setting->tiktok ?? '#';
    $ig = $setting->instagram ?? '#';
    $copy = $setting->copyright ?? '';
@endphp

<body>
    <!-- wrapper -->
    <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded fixed-top rounded-0 shadow-sm">
            <div class="container-fluid">
                <a href="/" class="d-flex align-items-center text-decoration-none">
                    <div>
                        <img src="{{ asset('backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                    </div>
                    <div>
                        <h4 class="logo-text">HotelHub</h4>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1"
                    aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent1">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"> <a class="nav-link active" aria-current="page" href="/"><i
                                    class='bx bx-home-alt me-1'></i>Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="error-404 d-flex align-items-center justify-content-center">
            <div class="container">
                <div class="card py-5">
                    <div class="row g-0">
                        <div class="col col-xl-5">
                            <div class="card-body p-4">
                                <h1 class="display-1"><span class="text-primary">4</span><span
                                        class="text-danger">0</span><span class="text-success">3</span></h1>
                                <h2 class="font-weight-bold display-4">Not Permission</h2>
                                <p>User does not have the right permissions.
                                </p>
                                <div class="mt-5"> <a href="/" class="btn btn-primary btn-lg px-md-5 radius-30">Go
                                        Home</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7">
                            <img src="{{ asset('backend/assets/images/403_img.png') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                    <!--end row-->
                </div>
            </div>
        </div>
        <div class="bg-white p-3 fixed-bottom border-top shadow">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">Follow Us :</li>
                    <li class="list-inline-item"><a href="{{ $fb }}"><i class='bx bxl-facebook me-1'></i>Facebook</a>
                    </li>
                    <li class="list-inline-item"><a href="{{ $tt }}"><i class='bx bxl-tiktok me-1'></i>Tiktok</a>
                    </li>
                    <li class="list-inline-item"><a href="{{ $ig }}"><i class='bx bxl-instagram me-1'></i>Instagram</a>
                    </li>
                </ul>
                <p class="mb-0">{{ $copy }}</p>
            </div>
        </div>
    </div>
    <!-- end wrapper -->
    <!-- Bootstrap JS -->
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>