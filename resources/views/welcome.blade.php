<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nzeru Ed - Learn Online Part-Time</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Nzeru Ed Theme Colors */
    :root {
      --primary-color: #6f42c1; /* Purple */
      --secondary-color: #f7c948; /* Yellow */
      --accent-color: #23a6f0; /* Blue */
      --bg-color: #fdfdfc;
      --text-color: #1b1b18;
      --card-bg: #fff;
    }

    body {
      font-family: 'Roboto', sans-serif;
      background-color: var(--bg-color);
      color: var(--text-color);
    }

    .hero {
      background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
      color: white;
      padding: 80px 0;
      text-align: center;
    }

    .hero h1 {
      font-weight: 700;
      font-size: 3rem;
      margin-bottom: 20px;
    }

    .hero p {
      font-size: 1.2rem;
      margin-bottom: 30px;
    }

    .card-login {
      max-width: 400px;
      margin: 20px auto;
      padding: 30px;
      border-radius: 12px;
      background-color: var(--card-bg);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .btn-primary {
      background-color: var(--primary-color);
      border: none;
    }

    .btn-primary:hover {
      background-color: #5a34a0;
    }

    .btn-register {
      background-color: var(--secondary-color);
      color: #000;
    }

    .btn-register:hover {
      background-color: #e0b637;
      color: #000;
    }

    .form-label {
      font-weight: 500;
    }

    footer {
      text-align: center;
      padding: 20px 0;
      margin-top: 40px;
      color: #666;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Welcome to Nzeru Ed</h1>
    <p>Online part-time classes for secondary school students. Learn at your own pace, anytime, anywhere!</p>
    <a href="#login" class="btn btn-lg btn-light me-2">Get Started</a>
    <a href="#register" class="btn btn-lg btn-outline-light">Register Now</a>
  </section>

  <!-- Login Section -->
<section id="login" class="mt-5">
  <div class="card-login" style="max-width:400px; margin:auto; padding:30px; background: #f3e8ff; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
    <h3 class="text-center mb-4">Login to Your Account</h3>
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3">
        <label for="loginEmail" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" id="loginEmail" placeholder="Enter email" required>
      </div>
      <div class="mb-3">
        <label for="loginPassword" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Password" required>
      </div>
      <button type="submit" class="btn w-100" style="background: linear-gradient(90deg, #6a0dad, #1e90ff); color:white; border:none;">Login</button>
    </form>

    <p class="text-center mt-3">
      <a href="{{ route('password.request') }}" class="text-decoration-none" style="color:#6a0dad;">Forgot password?</a>
    </p>

    <div class="text-center mt-4">
      <p>Don't have an account?</p>
      <a href="{{ route('register') }}" class="btn" style="background: #1e90ff; color:white; border:none;">Register</a>
    </div>
  </div>
</section>


  <!-- Register Section -->
  <section id="register" class="mt-5">
    <div class="card-login">
      <h3 class="text-center mb-4">Create an Account</h3>
      <form>
        <div class="mb-3">
          <label for="registerName" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="registerName" placeholder="Your Name">
        </div>
        <div class="mb-3">
          <label for="registerEmail" class="form-label">Email address</label>
          <input type="email" class="form-control" id="registerEmail" placeholder="Enter email">
        </div>
        <div class="mb-3">
          <label for="registerPassword" class="form-label">Password</label>
          <input type="password" class="form-control" id="registerPassword" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-register w-100">Register</button>
        <p class="text-center mt-3">Already have an account? <a href="#login" class="text-decoration-none">Login</a></p>
      </form>
    </div>
  </section>

  <footer>
    &copy; 2025 Nzeru Ed. All rights reserved.
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
