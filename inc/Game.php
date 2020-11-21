<?php

//class responsible for the game functionality
class Game
{
  //the Phrase object is stored in $phrase
  private $phrase;
  //how many lives you have
  private $lives = 5;

  public function __construct(Phrase $phrase) 
  {
    $this->phrase = $phrase;
  }

  //displays the keyboard
  public function displayKeyboard()
  {
    $output = '<div id="qwerty" class="section">';
    $output .= '<form method="post" action="play.php"';
    $output .= '<div class="keyrow">';
    $output .= $this->handleKey('q');
    $output .= $this->handleKey('w');
    $output .= $this->handleKey('e');
    $output .= $this->handleKey('r');
    $output .= $this->handleKey('t');
    $output .= $this->handleKey('y');
    $output .= $this->handleKey('u');
    $output .= $this->handleKey('i');
    $output .= $this->handleKey('o');
    $output .= $this->handleKey('p');
    $output .= '</div>';
    $output .= '<div class="keyrow">';
    $output .= $this->handleKey('a');
    $output .= $this->handleKey('s');
    $output .= $this->handleKey('d');
    $output .= $this->handleKey('f');
    $output .= $this->handleKey('g');
    $output .= $this->handleKey('h');
    $output .= $this->handleKey('j');
    $output .= $this->handleKey('k');
    $output .= $this->handleKey('l');
    $output .= '</div>';
    $output .= '<div class="keyrow">';
    $output .= $this->handleKey('z');
    $output .= $this->handleKey('x');
    $output .= $this->handleKey('c');
    $output .= $this->handleKey('v');
    $output .= $this->handleKey('b');
    $output .= $this->handleKey('n');
    $output .= $this->handleKey('m');
    $output .= '</div>';
    $output .= '</form>';
    $output .= '</div>'; 

    return $output;
  }

  //displays how many hearts you have got
  public function displayScore() 
  {
    $lost_hearts = $this->phrase->numberLost();
    $full_hearts = $this->lives - $lost_hearts;

    $output = '<div id="scoreboard" class="section">';
    $output .= '<ol>';

    for($i = 1; $i <= $full_hearts; $i++) {
      $output .= '<li class="tries"><img src="images/liveHeart.png" height="35px" widght="30px"></li>';
    }
    for($i = 1; $i <= $lost_hearts; $i++) {
      $output .= '<li class="tries"><img src="images/lostHeart.png" height="35px" widght="30px"></li>';
    }

    $output .= '</ol>';
    $output .= '</div>';

    return $output;
  }

  // displays the individual character button
  public function handleKey($letter) 
  {
    if (in_array($letter, $this->phrase->selected)) {
      if ($this->phrase->checkLetter($letter)) {
        return '<button name="key" value="'.$letter.'" class="key correct" disabled="true">'.$letter.'</button>';
      } else {
        return '<button name="key" value="'.$letter.'" class="key incorrect" disabled="true">'.$letter.'</button>';
      }
    } else {
      return '<button name="key" value="'.$letter.'" class="key">'.$letter.'</button>';
    }
  }

  //checks whther you have lost
  public function checkForLose() 
  {
    if ($this->lives - $this->phrase->numberLost() <= 0) {
      return true;
    } else {
      return false;
    }
  }

  //outputs the end message
  public function gameOver() 
  {
    if ($this->checkForLose()) {
      $output = '<h1 id="game-over-message">The phrase was: "'.$this->phrase->getCurrentPhrase().'". Better luck next time!</h1>';
      $output .= '<form action="play.php" method="post">';
      $output .= '<input id="btn__reset" type="submit" name="start" value="Start Game" />';
      $output .= '</form>';
      return $output;
    } else if ($this->checkForWin()) {
      $output = '<h1 id="game-over-message">Congratulations on guessing: "'.$this->phrase->getCurrentPhrase().'"</h1>';
      $output .= '<form action="play.php" method="post">';
      $output .= '<input id="btn__reset" type="submit" name="start" value="Start Game" />';
      $output .= '</form>';
      return $output;
    } else {
      return false;
    }
  }

  //checks whther you have won
  public function checkForWin()
  {
    if(count(array_intersect($this->phrase->selected, $this->phrase->getLetterArray())) == count($this->phrase->getLetterArray())) {
      return true;
    } else {
      return false;
    }
  }
}