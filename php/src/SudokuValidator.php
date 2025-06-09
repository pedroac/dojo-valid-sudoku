<?php

namespace TwentyFiveFriday;

class Position
{
    public function __construct(
        public int $x,
        public int $y
    ) {}
}

class SudokuValidator
{
    const SUB_BOX_SIZE = 3;

    /**
     * @param string[][] $sudoku
     */
    public function __construct(private array $sudoku) {}
    
    public function validate(): string {
        $maxColIndex = count($this->sudoku[0] ?? []) - 1;
        $maxRowIndex = count($this->sudoku) - 1;

        // Check if the rows are valid
        for ($y = 0; $y <= $maxRowIndex; ++$y) {
            if (!$this->areUnique(new Position(0, $maxRowIndex), new Position($maxColIndex - 1, $maxRowIndex))) {
                return 'Invalid';
            }
        }

        // Check if the columns are valid
        for ($x = 0; $x <= $maxRowIndex; ++$x) {
            if (!$this->areUnique(new Position($x, 0), new Position($x, $maxRowIndex))) {
                return 'Invalid';
            }
        }

        // Check if the sub-boxes are valid
        for ($y = 0; $y <= $maxRowIndex; $y += self::SUB_BOX_SIZE) {
            for ($x = 0; $x <= $maxColIndex; $x += self::SUB_BOX_SIZE) {
                if (!$this->areUnique(
                    new Position($x, $y),
                    new Position($x + self::SUB_BOX_SIZE - 1, $y + self::SUB_BOX_SIZE - 1)
                )) {
                    return 'Invalid';
                }
            }
        }

        return 'Valid';
    }

    private function areUnique(Position $cornerA, Position $cornerB): bool 
    {
        $set = [];
        for ($y = $cornerA->y; $y <= $cornerB->y; ++$y) {
            for ($x = $cornerA->x; $x <= $cornerB->x; ++$x) {
                $value = $this->sudoku[$y][$x];
                if ($value === '.') {
                    continue;
                }
                if (isset($set[$value])) {
                    return false;
                }
                $set[$value] = true;
            }
        }
        return true;
    }
}