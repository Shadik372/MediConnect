      <a href="dashboard-doctor.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>Today's Patient Queue</h1>
        <p>Patients booked for today, in order of appointment time.</p>
      </div>

      <div class="card">
        <?php if (empty($queue)): ?>
          <p style="padding:15px;color:#777;">No patients booked for today.</p>
        <?php endif; ?>
        <?php foreach ($queue as $q): ?>
          <div class="list-row">
            <div class="avatar"><?php echo e(initials($q["patient_name"])); ?></div>
            <div class="info">
              <div class="name"><?php echo e($q["patient_name"]); ?></div>
              <div class="sub"><?php echo e(format_time($q["appointment_time"])); ?> · <?php echo e(ucfirst($q["visit_type"])); ?> <?php echo $q['reason'] ? '· ' . e($q['reason']) : ''; ?></div>
            </div>
            <span class="tag <?php echo tag_class($q["status"]); ?>"><?php echo $q["status"] === "checked-in" ? "Checked in" : ($q["status"] === "confirmed" ? "Confirmed" : "Waiting"); ?></span>
            <div class="actions-group">
              <a href="doctor-write-prescription.php?appointment_id=<?php echo (int) $q['id']; ?>&patient_id=<?php echo (int) $q['patient_id']; ?>"
                 class="btn <?php echo $q['status'] === 'checked-in' ? 'btn-primary' : 'btn-outline'; ?> btn-sm">Start</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
