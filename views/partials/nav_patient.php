<h4>Main</h4>
<a href="dashboard-patient.php" class="nav-link<?php echo $active === 'overview' ? ' active' : ''; ?>"><span class="icon">🏠</span> Overview</a>
<a href="patient-find-doctor.php" class="nav-link<?php echo $active === 'find-doctor' ? ' active' : ''; ?>"><span class="icon">🔍</span> Find a Doctor</a>
<a href="patient-book-appointment.php" class="nav-link<?php echo $active === 'appointments' ? ' active' : ''; ?>"><span class="icon">📅</span> My Appointments</a>
<a href="patient-prescriptions.php" class="nav-link<?php echo $active === 'prescriptions' ? ' active' : ''; ?>"><span class="icon">💊</span> Prescriptions</a>
<a href="patient-visit-history.php" class="nav-link<?php echo $active === 'history' ? ' active' : ''; ?>"><span class="icon">📖</span> Visit History</a>
<h4>Account</h4>
<a href="profile.php" class="nav-link<?php echo $active === 'profile' ? ' active' : ''; ?>"><span class="icon">⚙️</span> Profile Settings</a>
<a href="logout.php" class="nav-link"><span class="icon">🚪</span> Log out</a>
