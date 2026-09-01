      <a href="dashboard-patient.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>Visit History</h1>
        <p>A record of all your past consultations.</p>
      </div>

      <div class="card">
        <?php if (empty($completed)): ?>
          <p style="padding:15px;color:#777;">No past consultations yet.</p>
        <?php endif; ?>
        <?php foreach ($completed as $appt): ?>
          <div class="list-row">
            <div class="avatar"><?php echo e(initials($appt["doctor_name"])); ?></div>
            <div class="info">
              <div class="name">Dr. <?php echo e($appt["doctor_name"]); ?> — <?php echo e($appt["specialization"]); ?></div>
              <div class="sub"><?php echo e(format_date($appt["appointment_date"])); ?> · <?php echo e(ucfirst($appt["visit_type"])); ?></div>
            </div>
            <span class="tag tag-confirmed">Completed</span>
          </div>
        <?php endforeach; ?>
      </div>
