      <a href="dashboard-receptionist.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>Walk-in Registration</h1>
        <p>Register a walk-in patient and add them to today's queue.</p>
      </div>

      <?php if (!empty($walkinMessage)): ?>
        <p style="padding:10px;border-radius:8px;background:<?php echo $walkinIsError ? '#fee2e2' : '#dcfce7'; ?>;color:<?php echo $walkinIsError ? '#dc2626' : '#166534'; ?>;">
          <?php echo e($walkinMessage); ?>
        </p>
      <?php endif; ?>

      <div class="card">
        <form method="post" action="receptionist-walkin.php">
          <div class="form-two-col">
            <div class="field">
              <label>Patient full name</label>
              <input type="text" name="patient_name" placeholder="Jane Doe" required>
            </div>
            <div class="field">
              <label>Phone number</label>
              <input type="tel" name="phone" placeholder="01XXXXXXXXX" required>
            </div>
          </div>
          <div class="form-two-col">
            <div class="field">
              <label>Preferred doctor</label>
              <select name="doctor_id" required>
                <option value="">-- choose a doctor --</option>
                <?php foreach ($allDoctors as $doc): ?>
                  <option value="<?php echo (int) $doc['id']; ?>">Dr. <?php echo e($doc["full_name"]); ?> — <?php echo e($doc["specialization"]); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="field">
              <label>Reason for visit</label>
              <input type="text" name="reason" placeholder="e.g. Chest pain, follow-up">
            </div>
          </div>
          <button type="submit" name="register_walkin" value="1" class="btn btn-primary">Register &amp; add to queue</button>
        </form>
      </div>

      <div class="section-block" style="margin-top:25px;">
        <h2>Registered today</h2>
        <div class="card">
          <?php if (empty($todaysWalkins)): ?>
            <p style="padding:15px;color:#777;">No walk-ins registered yet today.</p>
          <?php endif; ?>
          <?php foreach ($todaysWalkins as $w): ?>
            <div class="list-row">
              <div class="avatar"><?php echo e(initials($w["patient_name"])); ?></div>
              <div class="info">
                <div class="name"><?php echo e($w["patient_name"]); ?></div>
                <div class="sub">Walk-in · Dr. <?php echo e($w["doctor_name"]); ?> · Added at <?php echo e(date("g:i A", strtotime($w["created_at"]))); ?></div>
              </div>
              <span class="tag tag-confirmed">In queue</span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
