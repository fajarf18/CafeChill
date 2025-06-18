<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login/Signup Form</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
<!-- partial:index.partial.html -->
<div class="form-structor">
  <!-- Sign Up Section -->
  <div class="signup">
    <h2 class="form-title" id="signup"><span>or</span>Sign up</h2>
    <form action="psignup.php" method="POST">
      <div class="form-holder">
        <input type="text" name="nama" class="input" placeholder="Nama" required />
        <input type="email" name="email" class="input" placeholder="Email" required />
        <input type="password" name="password" class="input" placeholder="Password" minlength="6" required />

      </div>
      <button class="submit-btn">Sign up</button>
    </form>
  </div>

  <!-- Login Section -->
  <div class="login slide-up">
    <div class="center">
      <h2 class="form-title" id="login"><span>or</span>Log in</h2>
      <form action="plogin.php" method="POST">
        <div class="form-holder">
          <input type="email" name="email" class="input" placeholder="Email" required />
          <input type="password" name="password" class="input" placeholder="Password" required />
        </div>
        <button type="submit" class="submit-btn">Log in</button>
      </form>
    </div>
  </div>
</div>
<!-- partial -->
<script src="./script.js"></script>

</body>
</html>
