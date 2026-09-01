      <a href="dashboard-admin.php" class="back-link">← Back to dashboard</a>
      <div class="page-header">
        <h1>Platform Reports</h1>
        <p>Usage and appointment volume for the current period.</p>
      </div>

      <div class="stats">
        <div class="card stat-box">
          <div class="number"><?php echo $totalUsers; ?></div>
          <div class="label">Total registered users</div>
        </div>
        <div class="card stat-box">
          <div class="number"><?php echo $appointmentsThisMonth; ?></div>
          <div class="label">Appointments this month</div>
        </div>
        <div class="card stat-box">
          <div class="number"><?php echo $activeDoctors; ?></div>
          <div class="label">Active doctors</div>
        </div>
      </div>

      <div class="card">
        <table class="table">
          <tr>
            <th>Metric</th>
            <th>Count</th>
          </tr>
          <tr>
            <td>Patients registered</td>
            <td><?php echo $patientCount; ?></td>
          </tr>
          <tr>
            <td>Doctors (approved)</td>
            <td><?php echo $activeDoctors; ?></td>
          </tr>
          <tr>
            <td>Receptionists</td>
            <td><?php echo $receptionistCount; ?></td>
          </tr>
          <tr>
            <td>Appointments this month</td>
            <td><?php echo $appointmentsThisMonth; ?></td>
          </tr>
        </table>
      </div>
