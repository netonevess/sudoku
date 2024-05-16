<?php

namespace Netonevess\Sudoku;

use Netonevess\Sudoku\Level\LevelInterface;
use Random\Randomizer;

class Game{
    private Randomizer $randomizer;
    private Board $board;
    private LevelInterface $level;

    public function __construct(LevelInterface $level)
    {
        $this->randomizer = new Randomizer();
        $this->level = $level;
        $this->create();
    }

    public function getBoard(): Board
    {
        return $this->board;
    }
    public function fill(GameAction $gameAction): board
    {
        return $this->board->fill($gameAction);
    }

    private function create(): void
    {
        // crate blank matrix
        $this->board = Board::getBoard();

        // fill matrix with level amount of random itens
        while ($this->board->getFilled() < $this->level->amount()) {
            $action = GameAction::builder($this->getRandom(), $this->getRandom(), $this->getRandom());
            $this->fill( $action );
        }
    }
    private function getRandom(): int
    {
        $ramdom = $this->randomizer->getInt(1,9);
        return $ramdom;
    }
}
