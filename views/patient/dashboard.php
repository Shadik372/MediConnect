      <div class="welcome">
        <span class="badge">Patient dashboard</span>
        <h1>Welcome back, <?php echo explode(" ", current_name())[0]; ?>.</h1>
        <p>You have <?php echo count($upcoming); ?> upcoming appointment(s) and <?php echo count($prescriptions); ?> prescription(s) on file.</p>
        <a href="patient-book-appointment.php" class="btn btn-primary">Book a new appointment</a>
      </div>

      <div class="stats">
        <div class="card stat-box">
          <div class="number"><?php echo count($upcoming); ?></div>
          <div class="label">Upcoming appointments</div>
        </div>
        <div class="card stat-box">
          <div class="number"><?php echo count($completed); ?></div>
          <div class="label">Past consultations</div>
        </div>
        <div class="card stat-box">
          <div class="number"><?php echo count($prescriptions); ?></div>
          <div class="label">Saved prescriptions</div>
        </div>
      </div>

      <section>
        <h2>What you can do</h2>
        <div class="grid">
          <div class="card feature">
            <div class="icon">🔍</div>
            <h3>Find a Doctor</h3>
            <p>Search by specialization or availability to find the right fit.</p>
            <a href="patient-find-doctor.php" class="btn btn-outline">Search doctors</a>
          </div>
          <div class="card feature">
            <div class="icon">📅</div>
            <h3>Book an Appointment</h3>
            <p>Pick an open slot from a doctor's calendar and confirm it.</p>
            <a href="patient-book-appointment.php" class="btn btn-outline">Book a slot</a>
          </div>
          <div class="card feature">
            <div class="icon">💊</div>
            <h3>My Prescriptions</h3>
            <p>Every digital prescription your doctors have issued, in one place.</p>
            <a href="patient-prescriptions.php" class="btn btn-outline">View prescriptions</a>
          </div>
          <div class="card feature">
            <div class="icon">📖</div>
            <h3>Visit History</h3>
            <p>Look back at past consultations and their notes any time.</p>
            <a href="patient-visit-history.php" class="btn btn-outline">View history</a>
          </div>
        </div>
      </section>

      <section>
        <h2>Upcoming appointments</h2>
        <div class="card">
          <?php if (empty($upcoming)): ?>
            <p style="padding:15px;color:#777;">No upcoming appointments yet.</p>
          <?php endif; ?>
          <?php foreach ($upcoming as $appt): ?>
            <div class="list-row">
              <div class="avatar"><?php echo e(initials($appt["doctor_name"])); ?></div>
              <div class="info">
                <div class="name">Dr. <?php echo e($appt["doctor_name"]); ?> — <?php echo e($appt["specialization"]); ?></div>
                <div class="sub"><?php echo e(format_date($appt["appointment_date"])); ?> · <?php echo e(format_time($appt["appointment_time"])); ?> · <?php echo e(ucfirst($appt["visit_type"])); ?></div>
              </div>
              <span class="tag <?php echo tag_class($appt["status"]); ?>"><?php echo $appt["status"] === "confirmed" ? "Confirmed" : ucfirst($appt["status"]); ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
