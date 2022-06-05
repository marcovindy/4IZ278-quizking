<?php
class Answer
{
    public $id;
    public $answer;
    public $correct;
    const BR = '<br />';

    public function __construct($id, $answer, $correct)
    {
        $this->id = $id;
        $this->answer = $answer;
        $this->correct = $correct;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function getCorrect()
    {
        return $this->correct;
    }

    public function print()
    {
        echo '<div class="classroom">';
        echo $this->id . self::BR;
        echo $this->answer . self::BR;
        echo $this->correct . self::BR;
        echo '</div>';
    }
}
?>