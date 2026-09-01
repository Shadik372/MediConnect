      <a href="dashboard-patient.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>My Prescriptions</h1>
        <p>Digital prescriptions issued by your doctors after each visit.</p>
      </div>

      <div class="card">
        <table class="table">
          <tr>
            <th>Prescription</th>
            <th>Doctor</th>
            <th>Date issued</th>
            <th>Medicines</th>
          </tr>
          <?php if (empty($prescriptions)): ?>
            <tr><td colspan="4" style="color:#777;">No prescriptions yet.</td></tr>
          <?php endif; ?>
          <?php foreach ($prescriptions as $rx): ?>
            <tr>
              <td>#RX-<?php echo str_pad($rx["id"], 4, "0", STR_PAD_LEFT); ?></td>
              <td>Dr. <?php echo e($rx["doctor_name"]); ?></td>
              <td><?php echo e(format_date($rx["date_issued"])); ?></td>
              <td><?php echo e(get_medicine_names_string($conn, $rx["id"])); ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
