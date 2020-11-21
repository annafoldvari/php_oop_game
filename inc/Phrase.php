<?php

//class responsible for the phrase functionality
class Phrase
{
  //stores the current phrase
  private $currentPhrase;

  //stores the selected letters;
  public $selected = array();

  //possible phrases to choose from for current phrase
  public $phrases = [
    'Boldness be my friend',
    'Leave no stone unturned',
    'Broken crayons still color',
    'The adventure begins',
    'Love without limits'
  ];
  
  public function __construct($current_phrase = null, $selected_letters = null) 
  {
    if ($current_phrase) {
      $this->currentPhrase = $current_phrase;
    } else {
      $this->currentPhrase = $this->phrases[array_rand($this->phrases)];
    }

    if ($selected_letters) {
      $this->selected = $selected_letters;
    }

    if(!isset($this->currentPhrase)) {
      $this->currentPhrase = "dream big";
    }
  }

  public function getCurrentPhrase() 
  {
    return $this->currentPhrase;
  }

  //Displays the phrase
  public function addPhraseToDisplay()
  {
    $characters = str_split(strtolower($this->currentPhrase));

    $output = '<div id="phrase" class="section"><ul>';

    foreach($characters as $character) {
      if($character == " "){
        if (in_array($character, $this->selected)){
          $output .= "<li class='show space'>$character</li>";
        } else {
          $output .= "<li class='hide space'>$character</li>";         
        }
      } else {
        if (in_array($character, $this->selected)){
          $output .= "<li class='show letter'>$character</li>";
        } else {
          $output .= "<li class='hide letter'>".$character."</li>";
        }
      }
    }
    $output .= "</ul></div>";
    return $output;
  }

  //check whether a letter is in the letters of the phrase
  public function checkLetter($letter)
  {
    $letter_array = $this->getLetterArray();

    return in_array($letter, $letter_array);
  }

  //creates an array from the unique letters of the phrase
  public function getLetterArray() 
  {
    return array_unique(str_split(str_replace(' ', '', strtolower($this->currentPhrase))));
  }

  //checks how many wrong answers you had
  public function numberLost() 
  {
    return count(array_diff($this->selected, $this->getLetterArray()));
  }
}