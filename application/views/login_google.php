<?php if (!isset($authUrl)){ ?>
<header id="info">
  <a target="_blank" class="user_name" href="<?php echo $userData->link; ?>" /><img class="user_img" src="<?php echo $userData->picture; ?>" width="15%" />
    <?php echo '<p class="welcome"><i>Welcome ! </i>' . $userData->name . "</p>"; ?></a><a class='logout' href='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=<?php echo base_url(); ?>index.php/user_authentication/logout'>Logout</a>
  </header>
  <?php
  echo "<p class='profile'>Profile :-</p>";
  echo "<p><b> First Name : </b>" . $userData->given_name . "</p>";
  echo "<p><b> Last Name : </b>" . $userData->family_name . "</p>";
  echo "<p><b> Gender : </b>" . $userData->gender . "</p>";
  echo "<p><b>Email : </b>" . $userData->email . "</p>";
  } ?>