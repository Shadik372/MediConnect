      <a href="dashboard-patient.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>Find a Doctor</h1>
        <p>Search by name or specialization to find a doctor and book a slot.</p>
      </div>

      <form method="get" action="patient-find-doctor.php" class="toolbar">
        <input type="text" name="q" placeholder="Search by doctor name..." value="<?php echo e($_GET['q'] ?? ''); ?>">
        <select name="spec">
          <option>All specializations</option>
          <?php foreach (["Cardiology", "Dermatology", "Pediatrics", "Orthopedics", "General Physician"] as $s): ?>
            <option <?php echo (($_GET['spec'] ?? '') === $s) ? 'selected' : ''; ?>><?php echo $s; ?></option>
          <?php endforeach; ?>
        </select>
        <button class="btn btn-primary" type="submit">Search</button>
      </form>

      <div class="card">
        <?php if (empty($doctors)): ?>
          <p style="padding:15px;color:#777;">No doctors found.</p>
        <?php endif; ?>
        <?php foreach ($doctors as $doc): ?>
          <div class="doctor-card">
            <div class="avatar"><?php echo e(initials($doc["full_name"])); ?></div>
            <div class="info">
              <div class="name">Dr. <?php echo e($doc["full_name"]); ?></div>
              <div class="sub"><?php echo e($doc["specialization"]); ?> · <?php echo (int) $doc["experience_years"]; ?> years experience · ⭐ <?php echo e($doc["rating"]); ?></div>
            </div>
            <a href="patient-book-appointment.php?doctor_id=<?php echo (int) $doc['id']; ?>" class="btn btn-primary btn-sm">Book</a>
          </div>
        <?php endforeach; ?>
      </div>
