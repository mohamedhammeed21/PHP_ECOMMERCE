<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">

        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <div class="upper-bar">
      


      <div class="container">

      <a class="navbar-brand" href="index.php"><?php echo lang('HOME_ADMIN') ?></a>
    </div>




    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav"><?php 

  $cat= getcat();
  foreach ($cat as $a ) {

    echo "<li><a href='categories.php?pageid=".$a['ID']."&name=".$a['Name']."'>".$a['Name']."</a></li>";
            
  }


?>
        
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">drop me <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['id']; ?>">Edit Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>