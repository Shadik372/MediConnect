      <a href="dashboard-patient.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>Book an Appointment</h1>
        <p>Pick a doctor, an available time slot, and confirm your visit.</p>
      </div>

      <?php if (!empty($bookMessage)): ?>
        <p style="padding:10px;border-radius:8px;background:<?php echo $bookIsError ? '#fee2e2' : '#dcfce7'; ?>;color:<?php echo $bookIsError ? '#dc2626' : '#166534'; ?>;">
          <?php echo e($bookMessage); ?>
        </p>
      <?php endif; ?>

      <div class="card section-block">
        <form method="post" action="patient-book-appointment.php">
          <div class="field">
            <label for="doctor_id">Doctor</label>
            <select name="doctor_id" id="doctor_id" required>
              <option value="">-- choose a doctor --</option>
              <?php foreach ($allDoctors as $doc): ?>
                <option value="<?php echo (int) $doc['id']; ?>" <?php echo ((int)($_GET['doctor_id'] ?? 0) === (int)$doc['id']) ? 'selected' : ''; ?>>
                  Dr. <?php echo e($doc["full_name"]); ?> — <?php echo e($doc["specialization"]); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <h3 style="margin-top:15px;">Choose a date</h3>
          <div>
            <input type="date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" required>
          </div>

          <h3>Choose a time slot</h3>
          <div class="slot-grid">
            <?php
            $slots = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30"];
            foreach ($slots as $slot):
              $taken = in_array($slot, $bookedSlots ?? []);
            ?>
              <label class="slot<?php echo $taken ? ' taken' : ''; ?>" style="cursor:<?php echo $taken ? 'not-allowed' : 'pointer'; ?>;">
                <input type="radio" name="appointment_time" value="<?php echo $slot; ?>:00" <?php echo $taken ? 'disabled' : 'required'; ?> style="display:none;">
                <?php echo date("g:i A", strtotime($slot)); ?>
              </label>
            <?php endforeach; ?>
          </div>

          <div class="field" style="margin-top:15px;">
            <label>Visit type</label>
            <select name="visit_type">
              <option value="in-clinic">In-clinic</option>
              <option value="video">Video consultation</option>
            </select>
          </div>
          <div class="field">
            <label>Reason for visit (optional)</label>
            <input type="text" name="reason" placeholder="e.g. Follow-up, chest pain">
          </div>

          <button type="submit" name="book_appointment" value="1" class="btn btn-primary">Confirm booking</button>
        </form>
      </div>

      <div class="section-block">
        <h2>Your upcoming appointments</h2>
        <div class="card">
          <?php if (empty($upcoming)): ?>
            <p style="padding:15px;color:#777;">No upcoming appointments yet.</p>
          <?php endif; ?>
          <?php foreach ($upcoming as $appt): ?>
            <div class="list-row">
              <div class="avatar"><?php echo e(initials($appt["doctor_name"])); ?></div>
              <div class="info">
                <div class="name">Dr. <?php echo e($appt["doctor_name"]); ?> — <?php echo e($appt["specialization"]); ?></div>
                <div class="sub"><?php echo e(format_date($appt["appointment_date"])); ?> · <?php echo e(format_time($appt["appointment_time"])); ?> · <?php echo e(ucfirst($appt["visit_type"])); ?></div>
              </div>
              <span class="tag <?php echo tag_class($appt["status"]); ?>"><?php echo $appt["status"] === "pending" ? "Awaiting confirmation" : ucfirst($appt["status"]); ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <script>
        // simple visual selection for slot labels (radio still drives the real value)
        document.querySelectorAll('.slot-grid .slot').forEach(function (label) {
          label.addEventListener('click', function () {
            document.querySelectorAll('.slot-grid .slot').forEach(l => l.classList.remove('selected'));
            if (!label.classList.contains('taken')) label.classList.add('selected');
          });
        });
      </script>
