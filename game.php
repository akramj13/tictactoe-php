<?php
// Don't start session here as it's already started in index.php
if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = array_fill(0, 9, '');
}
if (!isset($_SESSION['turn'])) {
    $_SESSION['turn'] = 'X';
}
if (!isset($_SESSION['winner'])) {
    $_SESSION['winner'] = '';
}

// Process moves and reset using POST to avoid header issues
function processActions() {
    // Process move if a square is clicked
    if (isset($_GET['square'])) {
        makeMove($_GET['square']);
    }
    
    // Process reset button
    if (isset($_GET['reset'])) {
        resetGame();
    }
}

// Call this function before any output
processActions();

function displayBoard() {
    echo "<div class='board'>";
    for ($i = 0; $i < 3; $i++) {
        echo "<div class='row'>";
        for ($j = 0; $j < 3; $j++) {
            $index = $i * 3 + $j;
            echo "<a href='?square={$index}' class='square'>";
            echo $_SESSION['board'][$index];
            echo "</a>";
        }
        echo "</div>";
    }
    echo "</div>";
    echo "<br>";
}

function makeMove($square) {
    // Only make a move if the game is not over and the square is empty
    if ($_SESSION['winner'] === '' && $_SESSION['board'][$square] === '') {
        $_SESSION['board'][$square] = $_SESSION['turn'];
        
        // Check for win or draw after the move
        if (checkWin()) {
            $_SESSION['winner'] = $_SESSION['turn'];
        } elseif (checkDraw()) {
            $_SESSION['winner'] = 'draw';
        } else {
            // Switch turns
            $_SESSION['turn'] = $_SESSION['turn'] === 'X' ? 'O' : 'X';
        }
    }
}

function checkWin() {
    $winPatterns = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8],
        [2, 4, 6]
    ];

    foreach ($winPatterns as $pattern) {
        $a = $_SESSION['board'][$pattern[0]];
        $b = $_SESSION['board'][$pattern[1]];
        $c = $_SESSION['board'][$pattern[2]];

        if ($a === $b && $b === $c && $a !== '') {
            return true;
        }
    }
    return false;
}

function checkDraw() {
    return !in_array('', $_SESSION['board']) && !checkWin();
}

function resetGame() {
    $_SESSION['board'] = array_fill(0, 9, '');
    $_SESSION['turn'] = 'X';
    $_SESSION['winner'] = '';
}

function displayResult() {
    if ($_SESSION['winner'] === 'draw') {
        echo "<p class='result'>It's a draw!</p>";
    } elseif ($_SESSION['winner'] !== '') {
        echo "<p class='result'>Player " . $_SESSION['winner'] . " wins!</p>";
    } else {
        echo "<p class='turn'>Current turn: " . $_SESSION['turn'] . "</p>";
    }
}
?>