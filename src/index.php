<?php

function isSQLInjection($input) {
    $sqlRegex = '/\b(SELECT|INSERT|UPDATE|DELETE|FROM|WHERE|DROP)\b/i';

    return preg_match($sqlRegex, $input) !== 0;
}

function isXSS($input) {
    $xssRegex = '/<script.*?>|<\/script.*?>/i';

    return preg_match($xssRegex, $input) !== 0;
}

function isValidInput($input) {
    return !isXSS($input) && !isSQLInjection($input);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form was submitted, process the search term
    if (isset($_POST['searchTerm'])) {
        $searchTerm = $_POST['searchTerm'];

        // Check for invalid input
        if (!isValidInput($searchTerm)) {
            echo "Invalid input. Please enter a valid search term.";
            // Clear the input and remain on the home page for new input
            echo <<<HTML
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Homepage</title>
                </head>
                <body>
                    <form action="" method="POST">
                        <label for="searchTerm">Enter a search term:</label>
                        <input type="text" id="searchTerm" name="searchTerm" value="" required>
                        <input type="submit" value="Search">
                    </form>
                </body>
                </html>
HTML;
        } else {
            // No XSS or SQL injection detected, proceed to display the result page
            echo "You searched for: " . $searchTerm;
            echo '<br><a href="index.php">Return to Home Page</a>';
        }
    } else {
        echo "Please enter a search term.";
    }
} else {
    // Display the search form
    echo <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
        <title>Homepage</title>
    </head>
    <body>
        <form action="" method="POST">
            <label for="searchTerm">Enter a search term:</label>
            <input type="text" id="searchTerm" name="searchTerm" required>
            <input type="submit" value="Search">
        </form>
    </body>
    </html>
HTML;
}
?>
