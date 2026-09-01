      <a href="dashboard-admin.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>System Activity Monitor</h1>
        <p>Track logins, bookings, registrations, and errors across the platform.</p>
      </div>

      <div class="stats">
        <div class="card stat-box">
          <div class="number"><?php echo $activityToday; ?></div>
          <div class="label">Events logged today</div>
        </div>
        <div class="card stat-box">
          <div class="number"><?php echo $bookingsToday; ?></div>
          <div class="label">Bookings today</div>
        </div>
        <div class="card stat-box">
          <div class="number"><?php echo $errorsToday; ?></div>
          <div class="label">Errors logged today</div>
        </div>
      </div>

      <div class="card">
        <table class="table">
          <tr>
            <th>Time</th>
            <th>Event</th>
            <th>User</th>
            <th>Type</th>
          </tr>
          <?php if (empty($activity)): ?>
            <tr><td colspan="4" style="color:#777;">No activity logged yet.</td></tr>
          <?php endif; ?>
          <?php foreach ($activity as $a): ?>
            <tr>
              <td><?php echo e(date("g:i A", strtotime($a["created_at"]))); ?></td>
              <td><?php echo e($a["description"]); ?></td>
              <td><?php echo e($a["full_name"] ?? "—"); ?></td>
              <td><span class="tag <?php echo $a["activity_type"] === "error" ? "tag-pending" : "tag-confirmed"; ?>"><?php echo e(ucfirst($a["activity_type"])); ?></span></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
