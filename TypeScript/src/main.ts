import { SudokuValidator, SudokuMatrix } from "./valid-sudoku";

const input = process.argv[2];

const data: SudokuMatrix = JSON.parse(input);

const game = new SudokuValidator(data);
const result = game.evaluate();

console.log(result);
