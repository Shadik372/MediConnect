<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log in — MediConnect</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="theme-patient">

  <div class="auth-page">
    <div class="auth-box">
      <a href="index.php" class="logo"><span class="logo-box"></span> MediConnect</a>
      <div class="divider"></div>
      <h1>Welcome back</h1>
      <p>Log in with your account. We'll take you to the right dashboard based on your role.</p>

      <?php if (!empty($_SESSION["flash"])): ?>
        <p style="color:#166534;background:#dcfce7;padding:10px;border-radius:8px;">
          <?php echo e($_SESSION["flash"]); unset($_SESSION["flash"]); ?>
        </p>
      <?php endif; ?>

      <?php if (!empty($loginError)): ?>
        <p style="color:red;"><?php echo e($loginError); ?></p>
      <?php endif; ?>

      <form method="post" action="login.php">
        <div class="field">
          <label for="email">Email address</label>
          <input type="email" id="email" name="email" placeholder="you@example.com"
                 value="<?php echo e($_COOKIE['remember_email'] ?? ''); ?>" required>
        </div>
        <div class="field">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>
        <div class="field">
          <label><input type="checkbox" name="remember"> Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Log in</button>
      </form>

      <div class="auth-footer">
        Don't have an account? <a href="register.php">Register here</a>
      </div>
    </div>
  </div>
</body>

</html>
