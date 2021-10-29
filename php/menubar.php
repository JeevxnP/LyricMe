<div class="set">
  <nav>
    <div class="menu-logo-wrapper">
      <a href="index.php">
        <img class="menu-logo" src="../img/poster_nav.jpeg" alt="logo">
      </a>
    </div>
    <div class="menu-list-wrapper">
      <ul class="menu-list">
        <?php
            // if not logged in then session variable logged_in won't be created yet
          if (isset($_SESSION['logged_in'])) {
            if ($_SESSION['logged_in'] == true) {
              echo '<li class="menu-list-item">
                      <a href="logout.php">
                        <img src="../img/logout.svg" alt="logout">
                        <p class="logout" style="color: white;">Logout</p>
                      </a>
                    </li>';
              }
            else {
              echo '<li class="menu-list-item">
                      <a href="login-index.php">
                        <img src="../img/login.svg" alt="login">
                        <p class="login" style="color: white;">Login</p>
                      </a>
                    </li>
                    <li class="menu-list-item">
                      <a href="registration.php">
                        <img src="../img/register.svg" alt="register">
                        <p class="register" style="color: white;">Register</p>
                      </a>
                    </li>';
              }
          }
          else {
            echo '<li class="menu-list-item">
                    <a href="login-index.php">
                      <img src="../img/login.svg" alt="login">
                      <p class="login" style="color: white;">Login</p>
                    </a>
                  </li>
                  <li class="menu-list-item">
                    <a href="registration.php">
                      <img src="../img/register.svg" alt="register">
                      <p class="register" style="color: white;">Register</p>
                    </a>
                  </li>';
          }
        ?>
<!--         <li class="menu-list-item">
          <a href="about.html">
            <img src="../img/about.svg" alt="about">
            <p class="about" style="color: white;">About</p>
          </a>
        </li> -->
      </ul>
    </div>
  </nav>
</div>