<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="Jembatan Akuntabilitas Bumdesma">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="dbm, sidbm, sidbm.net, demo.sidbm.net, app.sidbm.net, asta brata teknologi, abt, dbm, kepmendesa 136, kepmendesa nomor 136 tahun 2022">
    <meta name="author" content="Enfii">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ $logo }}">
    <link rel="icon" type="image/png" href="{{ $logo }}">
    <title> Aplikasi LKM V.9.10</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    
    <!-- Icons -->
    <link href="/argon/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/argon/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Argon CSS -->
    <link href="/argon/css/argon-dashboard.min.css" rel="stylesheet" />
    
    <style>
        .bg-gradient-primary {
            background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .logo-container img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: white;
            padding: 10px;
            box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
        }
        .card-header h4 {
            margin-bottom: 0.25rem;
            font-weight: 700;
        }
        .card-header h5 {
            margin-bottom: 0;
            color: #8898aa;
            font-weight: 400;
        }
    </style>
</head>

<body class="bg-default">
    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-primary py-7 py-lg-8">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">Selamat Datang!</h1>
                            <p class="text-lead text-light">Silahkan login untuk mengakses aplikasi</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-header bg-transparent pb-4">
                            <div class="logo-container">
                                <img src="{{ $logo }}" alt="Logo" />
                            </div>
                            <div class="text-center">
                                <h4 class="mb-0">{{ $kec->nama_lembaga_sort }}</h4>
                                <h5 class="mt-2">{{ $kec->nama_kec }}</h5>
                            </div>
                        </div>
                        
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="text-center text-muted mb-4">
                                <small>Masukan <b>Username</b> dan <b>Password</b></small>
                            </div>
                            
                            <form role="form" method="POST" action="/login">
                                @csrf
                                
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Username" type="text" name="username" id="username" required autofocus>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Password" type="password" name="password" id="password" required>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" name="login" class="btn btn-primary my-4">SIGN IN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <a href="#" class="text-light">
                                <small>&copy; {{ date('Y') }} PT. Asta Brata Teknologi &mdash; {{ str_pad($kec->id, 4, '0', STR_PAD_LEFT) }}</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Core -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="/argon/js/core/bootstrap.bundle.min.js"></script>
    
    <!-- Argon JS -->
    <script src="/argon/js/argon-dashboard.min.js"></script>
    
    <!-- SweetAlert -->
    <script src="/assets/js/plugins/sweetalert.min.js"></script>
    
    <script>
        if (localStorage.getItem('devops') !== 'true') {
            $(document).bind("contextmenu", function(e) {
                return false;
            });

            $(document).keydown(function(event) {
                if (event.keyCode == 123) { // Prevent F12
                    return false;
                }
                if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
                    return false;
                }
                if (event.ctrlKey && event.shiftKey && event.keyCode == 67) { // Prevent Ctrl+Shift+C  
                    return false;
                }
                if (event.ctrlKey && event.shiftKey && event.keyCode == 74) { // Prevent Ctrl+Shift+J
                    return false;
                }
            });
        }
    </script>

    @if (session('pesan'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            function Toastr(icon, text) {
                font = "1.2rem Nimrod MT";

                canvas = document.createElement("canvas");
                context = canvas.getContext("2d");
                context.font = font;
                width = context.measureText(text).width;
                formattedWidth = Math.ceil(width) + 100;

                Toast.fire({
                    icon: icon,
                    title: text,
                    width: formattedWidth
                })
            }

            Toastr('success', "{{ session('pesan') }}")
        </script>
    @endif
</body>

</html>
