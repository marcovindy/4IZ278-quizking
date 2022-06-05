<?php
class Question
{
    public $id;
    public $question;
    public $answers;
    const BR = '<br />';

    public function __construct($id, $question, $answers)
    {
        $this->id = $id;
        $this->question = $question;
        $this->answers = $answers;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getAnswers()
    {
        return $this->answers;
    }

    public function print()
    {
        echo '<div class="classroom">';
        echo $this->id . self::BR;
        echo $this->question . self::BR;
        echo $this->answers . self::BR;
        echo '</div>';
    }
}
?>