<?php
class Slots {
    private array $valueOccurrences = ["G","G","G","G","G","L","L","L","X","X","X","O","O","$"]; //Elements
    private array $payouts = ["$" => 100, "O" => 50, "X" => 40, "L" => 10, "G" => 5]; // Payouts

    private int $cash = 5000;

    private int $payout = 0;

    // Rows & Columns
    private int $rows = 3;
    private int $columns = 4;

    private array $slots = [];

    private array $winningCombos = [
        [[0, 0], [0, 1], [0, 2], [0, 3]],
        [[1, 0], [1, 1], [1, 2], [1, 3]],
        [[2, 0], [2, 1], [2, 2], [2, 3]],
        [[0, 0], [0, 1], [1, 2], [2, 3]],
        [[2, 0], [2, 1], [1, 2], [0, 3]],
        [[0, 0], [1, 1], [2, 2], [2, 3]],
        [[2, 0], [1, 1], [0, 2], [0, 3]]
    ];

    private array $choseBet = [1 => 5, 2 => 10, 3 => 50, 4 => 100, 5 => 1000];

    /**
     * @return int
     */
    public function getCash(): int
    {
        return $this->cash;
    }

    /**
     * @return array
     */
    public function getChoseBet(): array
    {
        return $this->choseBet;
    }
    // Game board
    public function gameBoard(): void {
        $board = [];
        for ($rows = 0; $rows < $this->rows; $rows++){
            for ($columns = 0; $columns < $this->columns; $columns++){
                $board[$rows][$columns] = "";
            }
        }
        $this->slots = $board;
    }
    public function displayBoard(): string {

        $board = str_repeat(" ---", $this->columns) . PHP_EOL;
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $board .= "| {$this->slots[$i][$j]} ";
            }
            $board .= "|\n" . str_repeat(" ---", $this->columns) . "\n";
        }
        return $board;
    }

    public function spinSlots(): void {
        for ($i = 0; $i < count($this->slots); $i++){
            for ($j = 0; $j < count($this->slots[$i]); $j++){
                $this->slots[$i][$j] = $this->valueOccurrences[array_rand($this->valueOccurrences)];
            }
        }
    }

    public function winningConditions(int $bet): void {
        $won = 0;
        foreach ($this->winningCombos as $combos){
            $combo = [];
            foreach ($combos as $position) {
                $combo[] = $this->slots[$position[0]][$position[1]];
            }
            if (count(array_unique($combo)) == 1) {
                $won += $this->payouts[$combo[0]] * array_search($bet, $this->choseBet);
            }
        }
    }

    public function showPayouts(int $bet): string {
        if ($this->payout === 0){
            $this->cash = $this->cash - $bet;
            return "Lost: " .$bet. "$" . PHP_EOL;
        }
        $this->cash = $this->cash + $this->payout;
        return "YOU WON ". $this->payout . "$" . PHP_EOL;
    }

    public function quit($input): void {
        if ($input === "n" || $input === "N"){
            echo "Here is you're ". $this->cash . "$ back to you." .PHP_EOL;
            exit;
        }
    }
}
