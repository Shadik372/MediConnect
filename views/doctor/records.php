      <a href="dashboard-doctor.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>Patient Records</h1>
        <p>Every patient you've had an appointment with, and their visit history.</p>
      </div>

      <form method="get" action="doctor-records.php" class="toolbar">
        <input type="text" name="q" placeholder="Search patient by name..." value="<?php echo e($_GET['q'] ?? ''); ?>">
        <button class="btn btn-primary" type="submit">Search</button>
      </form>

      <div class="card">
        <table class="table">
          <tr>
            <th>Patient</th>
            <th>Last visit</th>
            <th>Total visits</th>
          </tr>
          <?php if (empty($patients)): ?>
            <tr><td colspan="3" style="color:#777;">No patients yet.</td></tr>
          <?php endif; ?>
          <?php foreach ($patients as $p): ?>
            <tr>
              <td><?php echo e($p["full_name"]); ?></td>
              <td><?php echo $p["last_visit"] ? e(format_date($p["last_visit"])) : "—"; ?></td>
              <td><?php echo (int) $p["total_visits"]; ?><?php echo $p["total_visits"] == 0 ? " (new patient)" : ""; ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
