<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= isset($pageTitle) ? $pageTitle : "Yummy Restaurant"; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>
<nav class="navbar border-bottom border-body">  
<div class="container-fluid">
    <a class="navbar-brand">
        <?php
        if (isset($_SESSION['admin_username'])) {
            echo "Welcome, " . $_SESSION['admin_username'];
        } else {
            echo "Welcome, Admin";
        }
        ?>
    </a>
    <div class="d-flex">
      <a href="../../profile.php" class="nav-link">
        <i class="bi bi-person-circle"></i>
      </a>
    </div>
  </div>
</nav>

