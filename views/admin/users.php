      <a href="dashboard-admin.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>User Management</h1>
        <p>Search, activate/deactivate, or remove any account.</p>
      </div>

      <form method="get" action="admin-users.php" class="toolbar">
        <input type="text" name="q" placeholder="Search by name or email..." value="<?php echo e($_GET['q'] ?? ''); ?>">
        <select name="role">
          <option>All roles</option>
          <?php foreach (["patient", "doctor", "receptionist", "admin"] as $r): ?>
            <option <?php echo (($_GET['role'] ?? '') === $r) ? 'selected' : ''; ?>><?php echo ucfirst($r); ?></option>
          <?php endforeach; ?>
        </select>
        <button class="btn btn-primary" type="submit">Search</button>
      </form>

      <div class="card">
        <table class="table">
          <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Email</th>
            <th>Status</th>
            <th></th>
          </tr>
          <?php if (empty($users)): ?>
            <tr><td colspan="5" style="color:#777;">No users found.</td></tr>
          <?php endif; ?>
          <?php foreach ($users as $u): ?>
            <tr>
              <td><?php echo e($u["full_name"]); ?></td>
              <td><?php echo e(ucfirst($u["role"])); ?></td>
              <td><?php echo e($u["email"]); ?></td>
              <td><span class="tag <?php echo tag_class($u["status"]); ?>"><?php echo $u["status"] === "approved" ? "Active" : ucfirst($u["status"]); ?></span></td>
              <td>
                <form method="post" action="admin-users.php" style="display:inline;">
                  <input type="hidden" name="user_id" value="<?php echo (int) $u['id']; ?>">
                  <?php if ($u["status"] === "approved"): ?>
                    <button type="submit" name="manage_action" value="deactivate" class="btn btn-outline btn-sm">Deactivate</button>
                  <?php else: ?>
                    <button type="submit" name="manage_action" value="activate" class="btn btn-outline btn-sm">Activate</button>
                  <?php endif; ?>
                  <button type="submit" name="manage_action" value="delete" class="btn btn-outline btn-sm"
                    onclick="return confirm('Delete this user permanently?')">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
