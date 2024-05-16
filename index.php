<?php

use Netonevess\Sudoku\Board;
use Netonevess\Sudoku\Game;
use Netonevess\Sudoku\GameNumber;
use Netonevess\Sudoku\Level\Easy;
use Random\Randomizer;

require_once ('vendor/autoload.php');

$climate = new League\CLImate\CLImate;

$game = new Game(new Easy());
$shape = $game->getBoard();
//echo json_encode($shape).PHP_EOL;

//$shape = json_decode(file_get_contents("./game.json"), true);

$climate->table($shape->getMatrix());
$climate->out(sprintf("Filled: %s/%s", $shape->getFilled(),$shape->getCellsNumber()));
