<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Qrion - Sign In</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f8fcfa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      display: flex;
      width: 90%;
      max-width: 1200px;
      gap: 40px;
      align-items: center;
    }

    /* Bagian gambar */
    .images {
      flex: 1.2;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-template-rows: auto auto;
      gap: 20px;
    }

    .images img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .images img.large {
      grid-column: span 2;
      height: 250px;
    }

    /* Bagian form */
    .login-box {
      flex: 1;
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .login-box .logo {
      margin-bottom: 20px;
    }

    .login-box .logo img {
      width: 160px;
    }

    .login-box h2 {
      font-size: 24px;
      margin-bottom: 10px;
      color: #0a3d62;
    }

    .login-box p {
      font-size: 14px;
      color: #555;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 18px;
      text-align: left;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      outline: none;
      transition: 0.3s;
    }

    .form-group input:focus {
      border-color: #10c67c;
      box-shadow: 0 0 5px rgba(16, 198, 124, 0.3);
    }

    .btn {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      background: linear-gradient(90deg, #10c67c, #05a36b);
      color: #fff;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn:hover {
      opacity: 0.9;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .container {
        flex-direction: column;
      }

      .images {
        grid-template-columns: 1fr;
      }

      .images img.large {
        grid-column: span 1;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <!-- Bagian Gambar -->
    <div class="images">
      <img src="assets/payday.png" alt="Payday">
      <img src="assets/payment.png" alt="Card Payment">
      <img src="assets/schedule.png" alt="Schedule" class="large">
    </div>

    <!-- Bagian Form Login -->
    <div class="login-box">
      <div class="logo">
        <img src="assets/logo-qrion.png" alt="Qrion Logo">
      </div>

      <h2>Sign In</h2>
      <p>Start by signing in to your account.</p>

      <form>
        <div class="form-group">
          <input type="text" placeholder="Username or Email Address">
        </div>

        <div class="form-group">
          <input type="password" placeholder="Password">
        </div>

        <button type="submit" class="btn">Sign In</button>
      </form>
    </div>
  </div>

</body>
</html>
