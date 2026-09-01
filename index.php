<?php require_once __DIR__ . "/includes/session.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MediConnect</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="theme-patient">

  <div class="nav">
    <a href="index.php" class="logo"><span class="logo-box"></span> MediConnect</a>
    <div class="nav-links">
      <a href="#about">About</a>
      <a href="#roles">Who it's for</a>
      <a href="#how">How it works</a>
    </div>
    <div class="nav-actions">
      <?php if (is_logged_in()): ?>
        <a href="dashboard-<?php echo current_role(); ?>.php" class="btn btn-primary">Go to dashboard</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-outline">Log in</a>
        <a href="register.php" class="btn btn-primary">Register</a>
      <?php endif; ?>
    </div>
  </div>

  <div class="hero">
    <div>
      <span class="badge">Academic Project</span>
      <h1>Book a doctor, not a queue.</h1>
      <p class="lead">MediConnect connects patients with doctors for online consultations and appointment booking — with
        separate tools for receptionists and admins too.</p>
      <div class="hero-actions">
        <a href="register.php" class="btn btn-primary">Create your account</a>
        <a href="login.php" class="btn btn-outline">I already have one</a>
      </div>
    </div>
    <div class="card">
      <h3>Today at a glance</h3>
      <div class="list-row">
        <div class="avatar">MC</div>
        <div class="info">
          <div class="name">Live appointment booking</div>
          <div class="sub">Patients, doctors, reception & admin</div>
        </div>
        <span class="tag tag-confirmed">Live</span>
      </div>
    </div>
  </div>

  <div class="section" id="about">
    <div class="section-title">
      <h2>What MediConnect does</h2>
      <p>A simple way to manage the whole consultation process online.</p>
    </div>
    <div class="grid">
      <div class="card feature">
        <div class="icon">🔍</div>
        <h3>Find the right doctor</h3>
        <p>Search doctors by specialization instead of asking around.</p>
      </div>
      <div class="card feature">
        <div class="icon">📅</div>
        <h3>Book real time slots</h3>
        <p>See a doctor's open slots and book one — no phone calls needed.</p>
      </div>
      <div class="card feature">
        <div class="icon">💊</div>
        <h3>Keep your prescriptions</h3>
        <p>Digital prescriptions are saved to your account automatically.</p>
      </div>
      <div class="card feature">
        <div class="icon">🩺</div>
        <h3>Simple doctor tools</h3>
        <p>Doctors manage their schedule and patients from one dashboard.</p>
      </div>
    </div>
  </div>

  <div class="section" id="roles">
    <div class="section-title">
      <h2>Every role gets its own dashboard</h2>
      <p>Same design, different color and tools for each user type.</p>
    </div>
    <div class="role-grid">
      <div class="role-card rc-patient">
        <div class="icon">🧑‍🦱</div>
        <h3>Patient</h3>
        <ul>
          <li>Search doctors</li>
          <li>Book appointments</li>
          <li>View prescriptions</li>
        </ul>
      </div>
      <div class="role-card rc-doctor">
        <div class="icon">🩺</div>
        <h3>Doctor</h3>
        <ul>
          <li>Manage availability</li>
          <li>Consult patients</li>
          <li>Issue prescriptions</li>
        </ul>
      </div>
      <div class="role-card rc-receptionist">
        <div class="icon">🗂️</div>
        <h3>Receptionist</h3>
        <ul>
          <li>Confirm appointments</li>
          <li>Register walk-ins</li>
          <li>Check patients in</li>
        </ul>
      </div>
      <div class="role-card rc-admin">
        <div class="icon">🛡️</div>
        <h3>Admin</h3>
        <ul>
          <li>Approve doctors</li>
          <li>Manage all users</li>
          <li>Monitor activity</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="section" id="how">
    <div class="section-title">
      <h2>How it works</h2>
      <p>Three steps, whoever you are.</p>
    </div>
    <div class="steps">
      <div class="card step">
        <div class="step-number">1</div>
        <h3>Register once</h3>
        <p>Create an account and choose your role.</p>
      </div>
      <div class="card step">
        <div class="step-number">2</div>
        <h3>Go to your dashboard</h3>
        <p>You land on the tools built for your role.</p>
      </div>
      <div class="card step">
        <div class="step-number">3</div>
        <h3>Do the task at hand</h3>
        <p>Book a slot, confirm a visit, or write a prescription.</p>
      </div>
    </div>
  </div>

  <div class="cta-band">
    <h2>Ready to get started?</h2>
    <p>Registration takes less than a minute.</p>
    <div class="hero-actions">
      <a href="register.php" class="btn btn-primary" style="background:#fff; color:#222; border-color:#fff;">Create account</a>
      <a href="login.php" class="btn btn-outline" style="color:#13d5dc; border-color:#666;">Log in</a>
    </div>
  </div>

  <div class="footer">
    <a href="index.php" class="logo"><span class="logo-box"></span> MediConnect</a>
    <p>MediConnect — Academic project.</p>
  </div>

</body>

</html>
