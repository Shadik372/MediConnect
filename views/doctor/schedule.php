      <a href="dashboard-doctor.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>My Schedule</h1>
        <p>Set the hours you're available each day so patients can book you.</p>
      </div>

      <?php if (!empty($scheduleMessage)): ?>
        <p style="padding:10px;border-radius:8px;background:#dcfce7;color:#166534;"><?php echo e($scheduleMessage); ?></p>
      <?php endif; ?>

      <form method="post" action="doctor-schedule.php">
        <div class="card">
          <?php foreach ($schedule as $day): ?>
            <?php $key = strtolower($day["day_of_week"]); ?>
            <div class="schedule-day">
              <div class="day-name"><?php echo e($day["day_of_week"]); ?></div>
              <label>
                <input type="checkbox" name="available_<?php echo $key; ?>" <?php echo $day["is_available"] ? "checked" : ""; ?>> Available
              </label>
              <input type="time" name="start_<?php echo $key; ?>" value="<?php echo substr($day["start_time"], 0, 5); ?>">
              <span>to</span>
              <input type="time" name="end_<?php echo $key; ?>" value="<?php echo substr($day["end_time"], 0, 5); ?>">
            </div>
          <?php endforeach; ?>
        </div>

        <div style="margin-top:20px;">
          <button type="submit" name="save_schedule" value="1" class="btn btn-primary">Save schedule</button>
        </div>
      </form>
