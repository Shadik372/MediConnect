      <a href="dashboard-receptionist.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>Patient Check-in</h1>
        <p>Mark arriving patients as checked in so doctors see an accurate queue.</p>
      </div>

      <div class="card">
        <?php if (empty($todaysAppointments)): ?>
          <p style="padding:15px;color:#777;">No confirmed appointments for today yet.</p>
        <?php endif; ?>
        <?php foreach ($todaysAppointments as $a): ?>
          <div class="list-row">
            <div class="avatar"><?php echo e(initials($a["patient_name"])); ?></div>
            <div class="info">
              <div class="name"><?php echo e($a["patient_name"]); ?></div>
              <div class="sub"><?php echo e(format_time($a["appointment_time"])); ?> · Dr. <?php echo e($a["doctor_name"]); ?> · <?php echo e(ucfirst($a["visit_type"])); ?></div>
            </div>
            <?php if ($a["status"] === "checked-in"): ?>
              <span class="tag tag-confirmed">Checked in</span>
            <?php else: ?>
              <span class="tag tag-pending">Not arrived</span>
              <form method="post" action="receptionist-checkin.php" style="display:inline;">
                <input type="hidden" name="appointment_id" value="<?php echo (int) $a['id']; ?>">
                <button type="submit" name="checkin" value="1" class="btn btn-primary btn-sm">Check in</button>
              </form>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
