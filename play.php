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
    $isPActive = true;
    while ($isPActive){
        $startGame->quit($bet);
        if (in_array((int)$bet, $startGame->getChoseBet()) && (int)$bet <= $startGame->getCash()){
            $isPActive = false;
            continue;
        }
        $bet = readline("Try again: ");
    }
    $isGActive = true;
    while ($isGActive) {
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
        $pActive = true;
        while ($pActive) {
            $startGame->quit($question);

            strtoupper($question) == "Y" ? $pActive = false:
                (strtoupper($question) == "N" ? $isGActive = $pActive = false : $question = readline("Try again: "));

            if ($bet > $startGame->getCash()) {
                echo "You don't have enough money to play";
                $pActive = $isGActive = false;
            }
        }

    }
}