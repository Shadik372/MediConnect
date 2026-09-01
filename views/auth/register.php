<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register — MediConnect</title>
  <link rel="stylesheet" href="assets/css/styles.css">
  <style>
    .errM { color: red; font-size: 12px; }
    .roleField { display: none; }
    .roleField.show { display: block; }
  </style>
</head>

<body class="theme-patient">

  <div class="auth-page">
    <div class="auth-box">
      <a href="index.php" class="logo"><span class="logo-box"></span> MediConnect</a>
      <div class="divider"></div>
      <h1>Create your account</h1>
      <p>Pick the role that matches how you'll use MediConnect.</p>

      <?php if (!empty($registerErrors)): ?>
        <?php foreach ($registerErrors as $err): ?>
          <p class="errM"><?php echo e($err); ?></p>
        <?php endforeach; ?>
      <?php endif; ?>

      <form method="post" action="register.php">
        <div class="role-pick">
          <p>
            <input type="radio" name="role" id="role-patient" value="patient" checked onclick="showRoleField('patient')">
            <label for="role-patient"><span class="icon">🧑‍🦱</span> Patient</label>
          </p>
          <p>
            <input type="radio" name="role" id="role-doctor" value="doctor" onclick="showRoleField('doctor')">
            <label for="role-doctor"><span class="icon">🩺</span> Doctor</label>
          </p>
          <input type="radio" name="role" id="role-reception" value="receptionist" onclick="showRoleField('none')">
          <label for="role-reception"><span class="icon">🗂️</span> Reception</label>
          <input type="radio" name="role" id="role-admin" value="admin" onclick="showRoleField('none')">
          <label for="role-admin"><span class="icon">🛡️</span> Admin</label>
        </div>

        <div class="field-row">
          <div class="field">
            <label for="fname">Full name</label>
            <input type="text" id="fname" name="fname" placeholder="Jane Doe" required maxlength="50">
          </div>
          <div class="field">
            <label for="phone">Phone number</label>
            <input type="text" id="phone" name="phone" placeholder="01XXXXXXXXX" required>
          </div>
        </div>

        <div class="field">
          <label for="remail">Email address</label>
          <input type="email" id="remail" name="remail" placeholder="you@example.com" required>
        </div>

        <div class="field roleField show" id="patientField">
          <label for="dob">Date of birth</label>
          <input type="date" id="dob" name="dob">
        </div>

        <div class="field roleField" id="doctorField">
          <label for="spec">Specialization (doctors only)</label>
          <select id="spec" name="spec">
            <option>General Physician</option>
            <option>Cardiology</option>
            <option>Dermatology</option>
            <option>Pediatrics</option>
            <option>Orthopedics</option>
          </select>
        </div>

        <div class="field-row">
          <div class="field">
            <label for="pass">Password</label>
            <input type="password" id="pass" name="pass" placeholder="••••••••" required minlength="6">
          </div>
          <div class="field">
            <label for="re_pass">Confirm password</label>
            <input type="password" id="re_pass" name="re_pass" placeholder="••••••••" required minlength="6">
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Create account</button>
      </form>

      <div class="auth-footer">
        Already have an account? <a href="login.php">Log in</a>
      </div>
    </div>
  </div>

  <script>
    function showRoleField(role) {
      document.getElementById('patientField').classList.remove('show');
      document.getElementById('doctorField').classList.remove('show');
      if (role === 'patient') document.getElementById('patientField').classList.add('show');
      if (role === 'doctor') document.getElementById('doctorField').classList.add('show');
    }
  </script>
</body>

</html>
