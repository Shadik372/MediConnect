      <div class="welcome">
        <span class="badge">Doctor dashboard</span>
        <h1>Welcome, Dr. <?php echo explode(" ", current_name())[0]; ?>.</h1>
        <p>You have <?php echo count($queue); ?> patient(s) in today's queue.</p>
        <a href="doctor-queue.php" class="btn btn-primary">View today's queue</a>
      </div>

      <div class="stats">
        <div class="card stat-box">
          <div class="number"><?php echo count($queue); ?></div>
          <div class="label">Patients today</div>
        </div>
        <div class="card stat-box">
          <div class="number"><?php echo count($patients); ?></div>
          <div class="label">Total patients seen</div>
        </div>
      </div>

      <section>
        <h2>What you can do</h2>
        <div class="grid">
          <div class="card feature">
            <div class="icon">📅</div>
            <h3>My Schedule</h3>
            <p>Set the hours you're available each day.</p>
            <a href="doctor-schedule.php" class="btn btn-outline">Manage schedule</a>
          </div>
          <div class="card feature">
            <div class="icon">🧑‍🤝‍🧑</div>
            <h3>Patient Queue</h3>
            <p>Patients booked for today, in order of appointment time.</p>
            <a href="doctor-queue.php" class="btn btn-outline">Open queue</a>
          </div>
          <div class="card feature">
            <div class="icon">💊</div>
            <h3>Write Prescription</h3>
            <p>Issue a digital prescription for a patient.</p>
            <a href="doctor-write-prescription.php" class="btn btn-outline">Write one</a>
          </div>
          <div class="card feature">
            <div class="icon">📁</div>
            <h3>Patient Records</h3>
            <p>Search for a patient to view their history.</p>
            <a href="doctor-records.php" class="btn btn-outline">View records</a>
          </div>
        </div>
      </section>

      <section>
        <h2>Today's queue</h2>
        <div class="card">
          <?php if (empty($queue)): ?>
            <p style="padding:15px;color:#777;">No patients booked for today.</p>
          <?php endif; ?>
          <?php foreach ($queue as $q): ?>
            <div class="list-row">
              <div class="avatar"><?php echo e(initials($q["patient_name"])); ?></div>
              <div class="info">
                <div class="name"><?php echo e($q["patient_name"]); ?></div>
                <div class="sub"><?php echo e(format_time($q["appointment_time"])); ?> · <?php echo e(ucfirst($q["visit_type"])); ?></div>
              </div>
              <span class="tag <?php echo tag_class($q["status"]); ?>"><?php echo $q["status"] === "checked-in" ? "Checked in" : ucfirst($q["status"]); ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
