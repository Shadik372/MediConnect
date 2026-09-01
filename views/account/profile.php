      <div class="page-header">
        <h1>Profile Settings</h1>
        <p>View and update your personal account information.</p>
      </div>

      <?php if (!empty($profileMessage)): ?>
        <p style="padding:10px;border-radius:8px;background:#dcfce7;color:#166534;"><?php echo e($profileMessage); ?></p>
      <?php endif; ?>

      <div class="card" style="max-width:650px;">
        <form method="post" action="profile.php">
          <div class="field-row">
            <div class="field">
              <label>Full name</label>
              <input type="text" name="full_name" value="<?php echo e($user['full_name']); ?>" required>
            </div>
            <div class="field">
              <label>Phone number</label>
              <input type="text" name="phone" value="<?php echo e($user['phone']); ?>" required>
            </div>
          </div>
          <div class="field">
            <label>Email address</label>
            <input type="email" name="email" value="<?php echo e($user['email']); ?>" required>
          </div>
          <div class="field">
            <label>Role</label>
            <input type="text" value="<?php echo e(ucfirst($user['role'])); ?>" disabled>
          </div>
          <button type="submit" name="save_profile" value="1" class="btn btn-primary" style="margin-top:10px;">Save changes</button>
          <a href="passchange.php" class="btn btn-outline" style="margin-top:10px;">Change password</a>
        </form>
      </div>
