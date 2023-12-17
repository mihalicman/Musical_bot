<?php
  session_start();
  
  if (isset($_SESSION['user'])) {
    header('Location: user.php');
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/register.css">
    <link rel="stylesheet" href="./assets/css/nav-bar.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/message.css">
    <link href="http://fonts.cdnfonts.com/css/roboto" rel="stylesheet">
    <title>Registration</title>
</head>
<body>

    <div class="wrapper">

    <?php include 'assets/views/nav-bar.php';?>

        <div class="main">
            <form action="./vendor/sign/signup.php" method="POST">
                <div id="registracija">
                  <h1>Reģistrācija</h1>
                  <?php 
                    if (isset($_SESSION['message'])) {
                      echo '
                      <div class = msg-cover>
                        <p class="msg"> ' . $_SESSION['message'] .'</p>
                      </div>';
                    }
                    unset($_SESSION['message']);
                  ?>
                  <p>Ievadiet savus datus lai izveidotu profilu.</p>
                  <hr>
              
                  <label for="e-pasts"><b>E-pasts</b></label>
                  <input type="text" placeholder="Ievadiet e-pastu" name="email" id="e-pasts" required onpaste="return false;">

                  <label for="e-pasts"><b>Atkārtojiet E-pastu</b></label>
                  <input type="text" placeholder="Ievadiet e-pastu vēlreiz" name="email_confirm" id="e-pasts" required onpaste="return false;">

                  <label for="lietotajvards"><b>Lietotājvārds</b></label>
                  <input type="text" placeholder="Ievadiet lietotājvārdu" name="username" id="lietotajvards" required onpaste="return false;">
              
                  <label for="parole"><b>Parole</b></label>
                  <input type="password" placeholder="Ievadiet paroli" name="password" id="parole" required onpaste="return false;">
              
                  <label for="atkartota-parole"><b>Atkārtojiet paroli</b></label>
                  <input type="password" placeholder="Ievadiet paroli vēlreiz" name="password_confirm" id="atkartota-parole" required onpaste="return false;">

                  <hr>
                  <p>Veidojot profilu jūs piekrītat <a href="" style="color: rgb(203, 233, 255);">lietošanas un privātuma noteikumiem</a>.</p>
                  <button type="submit" class="registracijas_poga">Reģistrēties</button>

                  <div class="pieslegties_logs">
                    <p>Profils jau izveidots? <a style="color: rgb(203, 233, 255); cursor: pointer;" onclick="pieslegties()">Pieslēgties</a>.</p>
                  </div>
                </div>
            </form>

            <form action="./vendor/sign/signin.php" method="POST">
                <div id="pieslegties" style="display:none;">
                  <h1>Pieslēgties</h1>
                  <p>Ievadiet lietotājvārdu un paroli.</p>
                  <hr>

                  <label for="lietotajvards"><b>Lietotājvārds</b></label>
                  <input type="text" placeholder="Ievadiet lietotājvārdu" name="username" id="lietotajvards" required onpaste="return false;">
              
                  <label for="parole"><b>Parole</b></label>
                  <input type="password" placeholder="Ievadiet paroli" name="password" id="parole" required onpaste="return false;">
                  <?php 
                    if (isset($_SESSION['message'])) {
                      echo '<p class="msg"> ' . $_SESSION['message'] .'</p>';
                    }
                    unset($_SESSION['message']);
                  ?>
                  <hr>
                  
                  <p><a style="color: rgb(203, 233, 255); cursor: pointer;" onclick="atjaunot_paroli()">Aizmirsāt lietotājvārdu un paroli</a>?</p>
                  <button type="submit" name="Pieslegties" class="pieslegties_poga">Pieslēgties</button>

                                
                  <div class="registracijas_logs">
                    <p>Neesiet vēl reģistrējušies? <a style="color: rgb(203, 233, 255); cursor: pointer;" onclick="registreties()">Reģistrēties</a>.</p>
                  </div>
                </div>
            </form>

              <div id="atjaunot_paroli" style="display:none;">
                <h1 style="margin-top:10%;">Atjaunot paroli</h1>
                <p>Ievadiet e-pastu, lai atjaunotu paroli.</p>
                <hr>

                <label for="e-pasts"><b>E-pasts</b></label>
                <input type="text" placeholder="Ievadiet e-pastu" name="e-pasts" id="e-pasts" required onpaste="return false;">
                <hr>
              
                <button type="submit" class="atjaunot_poga" onclick="mainit_paroli()">Atjaunot</button>
              </div>

            <form action="register.html">
                <div id="mainit_paroli" style="display:none;">
                  <h1 style="margin-top:5%;">Mainīt paroli</h1>
                  <p>Ievadiet jauno paroli jūsu profilam.</p>
                  <hr>

                  <label for="parole"><b>Parole</b></label>
                  <input type="password" placeholder="Ievadiet paroli" name="parole" id="parole" required onpaste="return false;">
              
                  <label for="atkartota-parole"><b>Atkārtojiet paroli</b></label>
                  <input type="password" placeholder="Ievadiet paroli vēlreiz" name="atkartota-parole" id="atkartota-parole" required onpaste="return false;">
                  <hr>
              
                  <button type="submit" class="mainit_poga">Mainīt</button>
                  <?php 
                    if (isset($_SESSION['message'])) {
                      echo '<p class="msg"> ' . $_SESSION['message'] .'</p>';
                    }
                    unset($_SESSION['message']);
                  ?>
                </div>
            </form>
            
        </div>

        <?php include 'assets/views/footer.html';?>
        
    </div>
    <?php 
      if (isset($_SESSION['message'])) {
        echo '<p class="msg"> ' . $_SESSION['message'] .'</p>';
      }
      unset($_SESSION['message']);
    ?>
    <script src="./assets/js/jquery.js"></script>
</body>
</html>