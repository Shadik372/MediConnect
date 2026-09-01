      <a href="doctor-queue.php" class="back-link">← Back to queue</a>
      <div class="page-header">
        <h1>Write Prescription</h1>
        <p>Issue a digital prescription — it will be saved to the patient's account.</p>
      </div>

      <?php if (!empty($rxMessage)): ?>
        <p style="padding:10px;border-radius:8px;background:#dcfce7;color:#166534;"><?php echo e($rxMessage); ?></p>
      <?php endif; ?>

      <div class="card">
        <form method="post" action="doctor-write-prescription.php">
          <div class="form-two-col">
            <div class="field">
              <label>Patient</label>
              <select name="patient_id" required>
                <option value="">-- choose from today's queue --</option>
                <?php foreach ($queue as $q): ?>
                  <option value="<?php echo (int) $q['patient_id']; ?>"
                    data-appt="<?php echo (int) $q['id']; ?>"
                    <?php echo ((int)($_GET['patient_id'] ?? 0) === (int) $q['patient_id']) ? 'selected' : ''; ?>>
                    <?php echo e($q["patient_name"]); ?> — <?php echo e(ucfirst($q["visit_type"])); ?>, <?php echo e(format_time($q["appointment_time"])); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="field">
              <label>Date issued</label>
              <input type="date" name="date_issued" value="<?php echo date('Y-m-d'); ?>">
            </div>
          </div>

          <input type="hidden" name="appointment_id" value="<?php echo (int) ($_GET['appointment_id'] ?? 0); ?>">

          <div class="field">
            <label>Diagnosis / notes</label>
            <textarea name="diagnosis" rows="3" placeholder="e.g. Mild hypertension, follow-up in 4 weeks"></textarea>
          </div>

          <h3>Medicines</h3>
          <table class="table" id="medTable">
            <tr>
              <th>Medicine</th>
              <th>Dosage</th>
              <th>Duration</th>
              <th></th>
            </tr>
            <tr>
              <td><input type="text" name="medicine_name[]" placeholder="e.g. Atorvastatin 10mg" style="width:100%; border:1px solid var(--border); border-radius:6px; padding:6px;"></td>
              <td><input type="text" name="dosage[]" placeholder="e.g. 1 tablet at night" style="width:100%; border:1px solid var(--border); border-radius:6px; padding:6px;"></td>
              <td><input type="text" name="duration[]" placeholder="e.g. 30 days" style="width:100%; border:1px solid var(--border); border-radius:6px; padding:6px;"></td>
              <td><button type="button" class="btn btn-outline btn-sm" onclick="this.closest('tr').remove()">Remove</button></td>
            </tr>
          </table>
          <button type="button" class="btn btn-outline btn-sm" style="margin-top:10px;" onclick="addMedicineRow()">+ Add medicine</button>

          <div style="margin-top:25px;">
            <button type="submit" name="issue_prescription" value="1" class="btn btn-primary">Issue prescription</button>
          </div>
        </form>
      </div>

      <script>
        function addMedicineRow() {
          const table = document.getElementById('medTable');
          const row = table.rows[1].cloneNode(true);
          row.querySelectorAll('input').forEach(i => i.value = '');
          table.appendChild(row);
        }
      </script>
