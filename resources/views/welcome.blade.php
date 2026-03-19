<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Becky Yoga Class</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root {
      --primary: #7c9a6a;
      --secondary: #f2d6a1;
      --accent: #9bb7a4;
    }

    body {
      font-family: 'Roboto', sans-serif;
    }

    .hero {
      min-height: 100vh;
      padding: 40px 20px;
      background: linear-gradient(120deg, var(--primary), var(--accent));
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .hero-content {
      max-width: 420px;
      width: 100%;
    }

    h1 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 15px;
    }

    p {
      font-size: 1rem;
      margin-bottom: 30px;
      line-height: 1.6;
    }

    .btn {
      width: 100%;
      padding: 14px;
      font-size: 1rem;
      border-radius: 10px;
      margin-bottom: 12px;
    }

    .btn-login {
      background-color: var(--primary);
      color: #fff;
      border: none;
    }

    .btn-register {
      background-color: var(--secondary);
      color: #000;
      border: none;
    }

    footer {
      text-align: center;
      font-size: 0.85rem;
      color: #eee;
      margin-top: 25px;
    }

    /* Larger screens */
    @media (min-width: 768px) {
      h1 {
        font-size: 2.6rem;
      }

      p {
        font-size: 1.1rem;
      }

      .btn {
        width: auto;
        min-width: 180px;
        margin: 0 6px;
      }
    }
  </style>
</head>
<body>

<section class="hero">
  <div class="hero-content">
    <h1>Welcome to Becky Yoga Class 🌿</h1>
    <p>Move gently. Breathe deeply. Begin your yoga journey.</p>

    <a href="{{ route('login') }}" class="btn btn-login">Login</a>
    <a href="{{ route('register') }}" class="btn btn-register">Join the Class</a>

    <footer>
      © 2025 Becky Yoga
    </footer>
  </div>
</section>

</body>
</html>
