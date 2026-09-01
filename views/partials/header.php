<?php
// Expects these variables to already be set by the page that includes this file:
// $pageTitle (string), $theme (patient|doctor|receptionist|admin), $active (nav key)
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo e($pageTitle); ?> — MediConnect</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="theme-<?php echo e($theme); ?>">

  <div class="topbar">
    <button class="hamburger" onclick="document.getElementById('sidebar').classList.toggle('hidden')">☰</button>
    <a href="index.php" class="logo"><span class="logo-box"></span> MediConnect</a>
    <div class="spacer"></div>
    <div class="user-box">
      <div class="avatar"><?php echo e(initials(current_name())); ?></div>
      <?php echo e(current_name()); ?> <span class="badge"><?php echo e(ucfirst($theme)); ?></span>
    </div>
  </div>

  <div class="layout">

    <div class="sidebar" id="sidebar">
      <?php include __DIR__ . "/nav_$theme.php"; ?>
    </div>

    <div class="main">
