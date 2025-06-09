export type SudokuMatrix = string[][];
export type Position = [number, number];

export class SudokuValidator {
  private static readonly SUBGRID_SIZE = 3;

  constructor(private readonly input: SudokuMatrix) {}

  evaluate(): string {
    const maxColIndex = this.input.length - 1;
    const maxRowIndex = this.input[0]?.length - 1

    // Check if the rows are valid
    for (let rowIndex in this.input) {
      if (!this.areUnique([0, Number(rowIndex)], [maxColIndex, Number(rowIndex)])) {
        return 'Invalid';
      }
    }

    // Check if the columns are valid
    for (let columnIndex in this.input[0]) {
      if (!this.areUnique([Number(columnIndex), 0], [Number(columnIndex), maxRowIndex])) {
        return 'Invalid';
      }
    }

    // Check if the subgrids are valid
    for (let y = 0; y < this.input.length; y += SudokuValidator.SUBGRID_SIZE) {
      for (let x = 0; x < this.input[y].length; x += SudokuValidator.SUBGRID_SIZE) {
        if (!this.areUnique([x, y], [x + 2, y + 2])) {
          return 'Invalid';
        }
      }
    }
    return 'Valid';
  }

  private areUnique(cornerA: Position, cornerB: Position): boolean
  {
    const rowSet = new Set<string>();
    for (let y = cornerA[1]; y <= cornerB[1]; ++y) {
      for (let x = cornerA[0]; x <= cornerB[0]; ++x) {
        const value = this.input[y][x];
        if (value !== '.' && rowSet.has(value)) {
          return false;
        }
        rowSet.add(value);
      }
    }
    return true;
  }
}
