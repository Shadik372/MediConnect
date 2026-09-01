      <div class="welcome">
        <span class="badge">Admin dashboard</span>
        <h1>Welcome, <?php echo explode(" ", current_name())[0]; ?>.</h1>
        <p><?php echo count($pendingDoctors); ?> doctor account(s) are waiting on approval and the platform logged <?php echo $activityToday; ?> activity events today.</p>
        <a href="admin-approvals.php" class="btn btn-primary">Review pending approvals</a>
      </div>

      <div class="stats">
        <div class="card stat-box">
          <div class="number"><?php echo count($pendingDoctors); ?></div>
          <div class="label">Doctor approvals pending</div>
        </div>
        <div class="card stat-box">
          <div class="number"><?php echo $totalUsers; ?></div>
          <div class="label">Total registered users</div>
        </div>
        <div class="card stat-box">
          <div class="number"><?php echo $activityToday; ?></div>
          <div class="label">Activity events today</div>
        </div>
      </div>

      <section>
        <h2>What you can do</h2>
        <div class="grid">
          <div class="card feature">
            <div class="icon">🩺</div>
            <h3>Doctor Approvals</h3>
            <p>Review new doctor registrations before they go live.</p>
            <a href="admin-approvals.php" class="btn btn-outline">Review requests</a>
          </div>
          <div class="card feature">
            <div class="icon">👥</div>
            <h3>User Management</h3>
            <p>Search, edit, or remove any patient, doctor, or receptionist.</p>
            <a href="admin-users.php" class="btn btn-outline">Manage users</a>
          </div>
          <div class="card feature">
            <div class="icon">📊</div>
            <h3>System Activity Monitor</h3>
            <p>Track logins, bookings, and errors across the platform.</p>
            <a href="admin-activity.php" class="btn btn-outline">View activity</a>
          </div>
          <div class="card feature">
            <div class="icon">📈</div>
            <h3>Platform Reports</h3>
            <p>See usage and appointment volume for the term.</p>
            <a href="admin-reports.php" class="btn btn-outline">Open reports</a>
          </div>
        </div>
      </section>

      <section>
        <h2>Pending doctor approvals</h2>
        <div class="card">
          <?php if (empty($pendingDoctors)): ?>
            <p style="padding:15px;color:#777;">Nothing pending. 🎉</p>
          <?php endif; ?>
          <?php foreach ($pendingDoctors as $d): ?>
            <div class="list-row">
              <div class="avatar"><?php echo e(initials($d["full_name"])); ?></div>
              <div class="info">
                <div class="name">Dr. <?php echo e($d["full_name"]); ?> — <?php echo e($d["specialization"]); ?></div>
                <div class="sub">Registered on <?php echo e(format_date($d["created_at"])); ?></div>
              </div>
              <span class="tag tag-pending">Awaiting review</span>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
