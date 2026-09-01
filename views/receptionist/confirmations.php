      <a href="dashboard-receptionist.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>Appointment Confirmations</h1>
        <p>Review booking requests and confirm or decline them.</p>
      </div>

      <div class="card">
        <?php if (empty($pending)): ?>
          <p style="padding:15px;color:#777;">Nothing pending. 🎉</p>
        <?php endif; ?>
        <?php foreach ($pending as $p): ?>
          <div class="list-row">
            <div class="avatar"><?php echo e(initials($p["patient_name"])); ?></div>
            <div class="info">
              <div class="name"><?php echo e($p["patient_name"]); ?> → Dr. <?php echo e($p["doctor_name"]); ?></div>
              <div class="sub">Requested <?php echo e(format_date($p["appointment_date"])); ?> · <?php echo e(format_time($p["appointment_time"])); ?> · <?php echo e(ucfirst($p["visit_type"])); ?></div>
            </div>
            <span class="tag tag-pending">Needs review</span>
            <div class="actions-group">
              <form method="post" action="receptionist-confirmations.php" style="display:inline;">
                <input type="hidden" name="appointment_id" value="<?php echo (int) $p['id']; ?>">
                <button type="submit" name="action" value="confirm" class="btn btn-primary btn-sm">Confirm</button>
                <button type="submit" name="action" value="decline" class="btn btn-outline btn-sm">Decline</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
