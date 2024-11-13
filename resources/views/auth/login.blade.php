<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Kaiadmin - Glassmorphism Login</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css')}}" />

    <style>
      /* Glassmorphism background */
      body {
        background: linear-gradient(135deg, #89f7fe, #66a6ff);
        background-size: cover;
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        margin: 0;
      }

      /* Glassmorphism card */
      .glass-card {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        padding: 20px;
        color: black;
        max-width: 400px;
        width: 100%;
      }

      .glass-footer {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        padding: 20px;
        color: black;
        max-width: 100%;
        width: 100%;
      }

      /* Adjusted form input for visibility on glass background */
      .form-control {
        background: rgba(255, 255, 255, 0.2);
        color: black;
        border: none;
        border-radius: 10px;
      }

      .form-control::placeholder {
        color: rgba(14, 13, 13, 0.7);
      }



    </style>
  </head>

<body>
  <div class="glass-card">
    <h3 class="fw-bold mb-3 text-center">
      <img src="{{ asset('assets/img/bgwithoutbg.png') }}" alt="logo" style="width: 80%;" />
    </h3>
    <h3 class="text-center mb-2">Login</h3>
    <form action="{{ route('login') }}" method="post">
        @csrf
      <div class="form-group ">
        <label for="email2">Email Address</label>
        <input type="email" class="form-control" name="email" id="email2" placeholder="Enter Email" />
        <small id="emailHelp2" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group ">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Password" />
      </div>
      <div class="form-group text-center">
        <button class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>

  <footer class="footer fixed-bottom glass-footer">
    <div class="container-fluid d-flex justify-content-between">
        <div class="copyright">
            2024, made with <i class="fa fa-heart heart text-danger"></i> by
            <a href="https://techomaxsolution.com">Techomax Solution</a>
        </div>
        <div>
            &copy; Copyright by
            <a target="_blank" href="">Digirdp</a>.
        </div>
    </div>
</footer>

  <!-- JS Files -->
  <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
</body>
</html>
