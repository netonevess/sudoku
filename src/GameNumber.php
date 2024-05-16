<?php

/**
 * GameNumber means that this could be a coordinate or a number (1-9)
 */
namespace Netonevess\Sudoku;

class GameNumber implements \Stringable
{
    private int $number;
    function __construct(int $number){
        if($number > 9 || $number < 1){
            throw new \InvalidArgumentException("Game Number Invalid.");
        }
        $this->number = $number;
    }

    public static function get(int $number): GameNumber
    {
        return new GameNumber($number);
    }
    public function __toString(): string
    {
        return (string) $this->number;
    }
}
