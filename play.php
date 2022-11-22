<?php
require_once "Slots.php";

$startGame = new  Slots();
$startGame->gameBoard();
echo "Welcome to slots!" . PHP_EOL;
echo "Enter n to quite: " . PHP_EOL;
echo "You have ". $startGame->getCash() . "$" . PHP_EOL;
$choseBetAmount = implode(", ",$startGame->getChoseBet());

while (true) {
    $bet = readline("Please select the amount you would like to bet:  ($choseBetAmount): ");
    $PromptActive = true;
    while ($PromptActive){
        $startGame->quit($bet);
        if (in_array((int)$bet, $startGame->getChoseBet()) && (int)$bet <= $startGame->getCash()){
            $PromptActive = false;
            continue;
        }
        $bet = readline("Try again: ");
    }
    $isGameActive = true;
    while ($isGameActive) {
        $startGame->spinSlots();
        echo $startGame->displayBoard();
        $startGame->winningConditions($bet);
        echo $startGame->showPayouts($bet);

        echo "You have: " . $startGame->getCash() ."$";
        if ($startGame->getCash() < min($startGame->getChoseBet())) {
            echo "You don't have any money";
            exit;
        }
        $question = readline("Spin ? (y/n): ");
        $isPromptActive = true;
        while ($isPromptActive) {
            $startGame->quit($question);

            strtoupper($question) == "Y" ? $isPromptActive = false:
                (strtoupper($question) == "N" ? $isGameActive = $isPromptActive = false : $question = readline("Try again: "));

            if ($bet > $startGame->getCash()) {
                echo "You don't have enough money to play";
                $isPromptActive = $isGameActive = false;
            }
        }

    }
}