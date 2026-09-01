      <a href="dashboard-admin.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>Doctor Approvals</h1>
        <p>Review new doctor registrations before they go live.</p>
      </div>

      <div class="card">
        <?php if (empty($pendingDoctors)): ?>
          <p style="padding:15px;color:#777;">Nothing pending. 🎉</p>
        <?php endif; ?>
        <?php foreach ($pendingDoctors as $d): ?>
          <div class="list-row">
            <div class="avatar"><?php echo e(initials($d["full_name"])); ?></div>
            <div class="info">
              <div class="name">Dr. <?php echo e($d["full_name"]); ?> — <?php echo e($d["specialization"]); ?></div>
              <div class="sub">Registered on <?php echo e(format_date($d["created_at"])); ?> · <?php echo e($d["email"]); ?></div>
            </div>
            <span class="tag tag-pending">Awaiting review</span>
            <div class="actions-group">
              <form method="post" action="admin-approvals.php" style="display:inline;">
                <input type="hidden" name="user_id" value="<?php echo (int) $d['id']; ?>">
                <button type="submit" name="action" value="approve" class="btn btn-primary btn-sm">Approve</button>
                <button type="submit" name="action" value="reject" class="btn btn-outline btn-sm">Reject</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
