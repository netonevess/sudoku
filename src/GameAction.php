<?php

/**
 * GameNumber means that this could be a coordinate or a number (1-9)
 */
namespace Netonevess\Sudoku;

class GameAction
{
    public GameNumber $x;
    public GameNumber $y;
    public GameNumber $value;


    function __construct(int $x, int $y, int $value){
        $this->x = GameNumber::get($x);
        $this->y = GameNumber::get($y);
        $this->value = GameNumber::get($value);
    }

    public static function builder(int $x, int $y, int $value): self
    {
        return new GameAction($x, $y, $value);
    }
    public function getX(): int
    {
        return (int) $this->x->__toString();
    }
    public function getY(): int
    {
        return (int) $this->y->__toString();
    }
    public function getValue(): int
    {
        return (int) $this->value->__toString();
    }
}
