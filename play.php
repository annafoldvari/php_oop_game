<?php
  require('inc/Game.php');
  require('inc/Phrase.php');

  session_start();
  
  //If new game button has been pressed unsets the session variables
  if ($_POST['start']) {
    unset($_SESSION['selected']);
    unset($_SESSION['phrase']);
  }
  
  //initiates a session variable for selected letters
  if (!isset($_SESSION['selected'])) {
    $_SESSION['selected'] = array();
  }
  
  //pressed key is added to selected letters session variable
  if($_POST['key']) {
    $_SESSION['selected'][] = $_POST['key'];
  }

  //new phrase object and game object created
  $phrase = new Phrase($_SESSION['phrase'], $_SESSION['selected']);
  $game = new Game($phrase);
  
    
  if(!isset($_SESSION['phrase'])) {
    $_SESSION['phrase'] = $phrase->getCurrentPhrase();
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Phrase Hunter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
</head>

<script>

  //Listens to keypress on keyboard when a character pressed initiates a click on the relevant button; 
  document.addEventListener('keydown', generateClick);
  
  function generateClick(e){
    let code = e.code;
    let letter = code.substr(3).toLowerCase();
    if(letter >= 'a' && letter <= 'z') {
      let button = document.querySelector(`button[value="${letter}"]`);
      button.click();
    }
  }
</script>

<body class="playpage">
<div class="main-container">
    <div id="banner" class="section">
        <h2 class="header">Phrase Hunter</h2>
    </div>
    <?php 
      if($game->gameOver()) {
        echo $game->gameOver();
      } else {
        echo $phrase->addPhraseToDisplay();
        echo $game->displayKeyboard();
        echo $game->displayScore();
      }
    ?>
</div>

</body>
</html>
