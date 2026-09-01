      <div class="welcome">
        <span class="badge">Receptionist dashboard</span>
        <h1>Welcome, <?php echo explode(" ", current_name())[0]; ?>.</h1>
        <p><?php echo count($pending); ?> bookings need confirming today.</p>
        <a href="receptionist-confirmations.php" class="btn btn-primary">Review confirmations</a>
      </div>

      <div class="stats">
        <div class="card stat-box">
          <div class="number"><?php echo count($pending); ?></div>
          <div class="label">Pending confirmations</div>
        </div>
        <div class="card stat-box">
          <div class="number"><?php echo $appointmentsToday; ?></div>
          <div class="label">Appointments today</div>
        </div>
      </div>

      <section>
        <h2>What you can do</h2>
        <div class="grid">
          <div class="card feature">
            <div class="icon">✅</div>
            <h3>Appointment Confirmations</h3>
            <p>Approve, reschedule, or decline booking requests.</p>
            <a href="receptionist-confirmations.php" class="btn btn-outline">Review requests</a>
          </div>
          <div class="card feature">
            <div class="icon">📝</div>
            <h3>Walk-in Registration</h3>
            <p>Register a walk-in patient into an available opening.</p>
            <a href="receptionist-walkin.php" class="btn btn-outline">Register walk-in</a>
          </div>
          <div class="card feature">
            <div class="icon">📅</div>
            <h3>Daily Schedule Overview</h3>
            <p>See every doctor's bookings for the day in one place.</p>
            <a href="receptionist-schedule.php" class="btn btn-outline">View schedule</a>
          </div>
          <div class="card feature">
            <div class="icon">🚶</div>
            <h3>Patient Check-in</h3>
            <p>Mark arriving patients as checked in for the doctor's queue.</p>
            <a href="receptionist-checkin.php" class="btn btn-outline">Open check-in</a>
          </div>
        </div>
      </section>

      <section>
        <h2>Pending confirmations</h2>
        <div class="card">
          <?php if (empty($pending)): ?>
            <p style="padding:15px;color:#777;">Nothing pending. 🎉</p>
          <?php endif; ?>
          <?php foreach ($pending as $p): ?>
            <div class="list-row">
              <div class="avatar"><?php echo e(initials($p["patient_name"])); ?></div>
              <div class="info">
                <div class="name"><?php echo e($p["patient_name"]); ?> → Dr. <?php echo e($p["doctor_name"]); ?></div>
                <div class="sub">Requested <?php echo e(format_date($p["appointment_date"])); ?> · <?php echo e(format_time($p["appointment_time"])); ?></div>
              </div>
              <span class="tag tag-pending">Needs review</span>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
