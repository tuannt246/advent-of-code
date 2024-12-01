<?php

class BingoBoard
{
    const   MARKED = "X";

    private $bingoLength;
    private $board;
    private $countMarkedNumber;
    private $leftSum;

    private function __construct($bingoLength, $board, $sum)
    {
        $this->bingoLength = $bingoLength;
        $this->board = $board;
        $this->countMarkedNumber = 0;
        $this->leftSum = $sum;
    }

    public static function fromArray($board): BingoBoard
    {
        $sum = 0;
        foreach ($board as $key => $row) {
            $board[$key] = array_values(array_filter(explode(" ", $row), function ($value) {
                return $value !== "";
            }));
            $sum += array_sum($board[$key]);
        }

        return new self(count($board), $board, $sum);
    }

    public function call($number)
    {
        foreach ($this->board as $rowIdx => $row) {
            foreach ($row as $columnIdx => $value) {
                if ($value == $number) {
                    $this->board[$rowIdx][$columnIdx] = self::MARKED;
                    $this->countMarkedNumber++;
                    $this->leftSum -= $number;

                    if ($this->countMarkedNumber < $this->bingoLength) {
                        return false;
                    }

                    $bingoRow = true;
                    $bingColumn = true;
                    for ($i = 0; $i < count($row); $i++) {
                        if ($this->board[$rowIdx][$i] != self::MARKED) {
                            $bingoRow = false;
                            break;
                        }

                    }
                    for ($i = 0; $i < count($row); $i++) {
                        if ($this->board[$i][$columnIdx] != self::MARKED) {
                            $bingColumn = false;
                            break;
                        }
                    }

                    if ($bingoRow || $bingColumn) {
                        return $number * $this->leftSum;
                    }
                    break;
                }
            }
        }
        return false;
    }
}
