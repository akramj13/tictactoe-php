<?php include 'game.php'; ?>
<link rel="stylesheet" href="game.css">
<div class="game-container">
    <?php displayBoard(); ?>
    <?php displayResult(); ?>
    <a href="?reset=true" class="reset-button">Reset Game</a>
</div>