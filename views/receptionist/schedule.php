      <a href="dashboard-receptionist.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>Daily Schedule Overview</h1>
        <p>Every doctor's bookings for today, in one view.</p>
      </div>

      <div class="card">
        <table class="table">
          <tr>
            <th>Time</th>
            <th>Doctor</th>
            <th>Patient</th>
            <th>Type</th>
            <th>Status</th>
          </tr>
          <?php if (empty($todaysSchedule)): ?>
            <tr><td colspan="5" style="color:#777;">No appointments today.</td></tr>
          <?php endif; ?>
          <?php foreach ($todaysSchedule as $s): ?>
            <tr>
              <td><?php echo e(format_time($s["appointment_time"])); ?></td>
              <td>Dr. <?php echo e($s["doctor_name"]); ?></td>
              <td><?php echo e($s["patient_name"]); ?></td>
              <td><?php echo e(ucfirst($s["visit_type"])); ?></td>
              <td><span class="tag <?php echo tag_class($s["status"]); ?>"><?php echo e(ucfirst($s["status"])); ?></span></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
