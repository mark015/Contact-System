<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Get the current page name
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Contacts</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">
          <li class="nav-item <?php echo ($currentPage == 'addContact.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="addContact.php" id="addContact">Add Contact</a>
          </li>
          <li class="nav-item <?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="contact.php" id="viewContacts">Contacts</a>
          </li>
          <li class="nav-item <?php echo ($currentPage == 'logout.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="logout.php" id="logout">Logout</a>
          </li>
      </ul>
  </div>
</nav>
