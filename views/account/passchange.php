      <a href="profile.php" class="back-link">← Back to profile</a>
      <div class="page-header">
        <h1>Change Password</h1>
        <p>Update the password you use to log in.</p>
      </div>

      <?php if (!empty($passMessage)): ?>
        <p style="padding:10px;border-radius:8px;background:<?php echo $passIsError ? '#fee2e2' : '#dcfce7'; ?>;color:<?php echo $passIsError ? '#dc2626' : '#166534'; ?>;">
          <?php echo e($passMessage); ?>
        </p>
      <?php endif; ?>

      <div class="card" style="max-width:500px;">
        <form method="post" action="passchange.php">
          <div class="field">
            <label>Current password</label>
            <input type="password" name="current_password" required>
          </div>
          <div class="field">
            <label>New password</label>
            <input type="password" name="new_password" required minlength="6">
          </div>
          <div class="field">
            <label>Confirm new password</label>
            <input type="password" name="confirm_password" required minlength="6">
          </div>
          <button type="submit" name="change_password" value="1" class="btn btn-primary">Save password</button>
        </form>
      </div>
