<?php

namespace Netonevess\Sudoku;

use Exception;

class Board 
{
    /**
     *
     * @var array[] $matrix
     */
    private array $matrix;

    private int $cellsNumber;
    private int $filledCells;

    /**
     * @var array[]
     */
    private array $shape;

    function __construct(array $matrix)
    {
        $this->matrix = $matrix;
        $this->shape = [
            1 => [1, 2, 3],
            2 => [4, 5, 6],
            3 => [7, 8, 9]
        ];
        $this->changeEvent();
    }

    public function fill(GameAction $gameAction): self
    {
        if($this->isAllowedAction($gameAction)){
            $this->matrix[$gameAction->getX()][$gameAction->getY()] = $gameAction->getValue();
            $this->changeEvent();
        }
        return $this;
    }
    public function isAllowedAction(GameAction $gameAction): bool
    {
        if($this->isCompleted()){
            return false;
        }

        $horizontal = $this->getHorizontal($gameAction->x);
        if(in_array($gameAction->getValue(), $horizontal)){
            return false;
        }

        $vertical = $this->getVertical($gameAction->y);
        if(in_array($gameAction->getValue(), $vertical)){
            return false;
        }

        $square = $this->getSquareFromCoordinates($gameAction->x, $gameAction->y);
        if(in_array($gameAction->getValue(), $square)){
            return false;
        }

        return true;
    }

    public function getMatrix()
    {
        return $this->matrix;
    }
    public function isCompleted(): bool
    {
        return $this->cellsNumber === $this->filledCells;
    }

    public function getFilled():int
    {
        return $this->filledCells;
    }
    public function getCellsNumber(): int
    {
        return $this->cellsNumber;
    }
    public function getVertical(GameNumber $number): array
    {
       return array_column($this->matrix, $number->__toString());
    }
    public function getHorizontal(GameNumber $number): array
    {
        return $this->matrix[$number->__toString()];
    }
    public function getSquareFromCoordinates(GameNumber $x, GameNumber $y){
        $selectedSquare = $this->identifySquare($x, $y);
        
        $result = [];
        foreach($this->matrix as $lineNumber => $yValues){
            $selectedDirectional = $this->identifyDirectionID(GameNumber::get($selectedSquare));
            $lineIndex = min($this->shape[$selectedDirectional]) - 1;
            $splited = array_slice($yValues, $lineIndex, 3, true);
            $firstKey = array_key_first($splited);

            $currentSquare = $this->identifySquare(GameNumber::get($lineNumber), GameNumber::get($firstKey));
            if($currentSquare === $selectedSquare){
                $result = array_merge($result, $splited);
            }

        }
        return $result;
    }
    public function getValueFromCoordinates(GameNumber $x, GameNumber $y){
        $value = $this->matrix[$x->__toString()][$y->__toString()];
        return GameNumber::get($value);
    }

    public static function getBoard(): self
    {
        return new Board(array_fill(1,9, array_fill(1,9, "")));
    }

    private function identifySquare(GameNumber $x, GameNumber $y): int
    {
        $horizontal = $this->identifyDirectionID($x);
        $vertical = $this->identifyDirectionID($y);

        return ($horizontal * $vertical);
    }
    private function identifyDirectionID(GameNumber $coordinate){
        $find = (int) $coordinate->__toString();
        $shape = $this->shape;

        foreach ($shape as $key => $values) {
            if(in_array($find, $values)){
                return $key;
            }
        }

        throw new Exception("Invalid Direction Number informed". $find);
    }
    private function changeEvent(): void
    {
        $merged = array_merge(...$this->matrix);
        $this->cellsNumber = count($merged);
        $this->filledCells = count(array_filter($merged));
    }
}
