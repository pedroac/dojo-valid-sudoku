# Valid Sudoku

## Original text

Determine if a `9 x 9` Sudoku board is valid. Only the filled cells need to be validated **according to the following rules**:

1. Each row must contain the digits `1-9` without repetition.
2. Each column must contain the digits `1-9` without repetition.
3. Each of the nine `3 x 3` sub-boxes of the grid must contain the digits `1-9` without repetition.

**Note:**

- A Sudoku board (partially filled) could be valid but is not necessarily solvable.
- Only the filled cells need to be validated according to the mentioned rules.

![valid_sudoku.png](./valid_sudoku.png)

## Input

The `“.”` represents an empty cell.

```markdown
[["5","3",".",".","7",".",".",".","."]
,["6",".",".","1","9","5",".",".","."]
,[".","9","8",".",".",".",".","6","."]
,["8",".",".",".","6",".",".",".","3"]
,["4",".",".","8",".","3",".",".","1"]
,["7",".",".",".","2",".",".",".","6"]
,[".","6",".",".",".",".","2","8","."]
,[".",".",".","4","1","9",".",".","5"]
,[".",".",".",".","8",".",".","7","9"]]
```

## Output

```markdown
Valid
```

## Constraints

- 1 pilot (coding) + 1 co-pilot (helping) + rest in silence.
- Do not use “else”.
- No more than 2 parameters per method.

## Test Cases

```markdown
[["5","3",".",".","7",".",".",".","."],["6",".",".","1","9","5",".",".","."],[".","9","8",".",".",".",".","6","."],["8",".",".",".","6",".",".",".","3"],["4",".",".","8",".","3",".",".","1"],["7",".",".",".","2",".",".",".","6"],[".","6",".",".",".",".","2","8","."],[".",".",".","4","1","9",".",".","5"],[".",".",".",".","8",".",".","7","9"]]

[["8","3",".",".","7",".",".",".","."],["6",".",".","1","9","5",".",".","."],[".","9","8",".",".",".",".","6","."],["8",".",".",".","6",".",".",".","3"],["4",".",".","8",".","3",".",".","1"],["7",".",".",".","2",".",".",".","6"],[".","6",".",".",".",".","2","8","."],[".",".",".","4","1","9",".",".","5"],[".",".",".",".","8",".",".","7","9"]]
```

## Solution

I implemented a private function, `areUnique`, to check if there are unique values in an area for the grid.

That function has two parameters, two positions representing corners of the evaluated area with two loops.
A set is used to check if repeating value was found while evaluating that area.

```js
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
```

The "." strings are ignored.
If another value is found the set, then the values are not unique -- return `false`.
Otherwise, add the value into the set.
If the values are unique, return `true`.

That function is called to evaluate rows, columns and subgrids.

