<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cellphone-Like PHP Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .calculator {
            width: 260px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .display {
            background-color: #222;
            color: white;
            text-align: right;
            padding: 20px;
            font-size: 2.5em;
            min-height: 60px;
            border-bottom: 1px solid #ccc;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background-color: #222;
        }
        .buttons button {
            background-color: #333;
            color: white;
            font-size: 1.5em;
            padding: 20px;
            border: none;
            cursor: pointer;
        }
        .buttons button:hover {
            background-color: #444;
        }
        .buttons .operator {
            background-color: #ff9500;
        }
        .buttons .operator:hover {
            background-color: #e58b00;
        }
        .buttons .equals {
            background-color: #ff9500;
            grid-column: span 2;
        }
        .buttons .equals:hover {
            background-color: #e58b00;
        }
        .buttons .zero {
            grid-column: span 2;
        }
        .buttons .decimal {
            grid-column: span 2;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <div class="display">
            <?php
            session_start();

            // Initialize variables
            $display = $_SESSION['display'] ?? '0';
            $num1 = $_SESSION['num1'] ?? '';
            $operator = $_SESSION['operator'] ?? '';
            $num2 = $_SESSION['num2'] ?? '';
            $result = $_SESSION['result'] ?? '';
            $show_result = $_SESSION['show_result'] ?? false;

            // Check if form has been submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['clear'])) {
                    // Clear the calculator
                    $display = '0';
                    $num1 = '';
                    $operator = '';
                    $num2 = '';
                    $result = '';
                    $show_result = false;
                } elseif (isset($_POST['equals'])) {
                    // Perform the calculation
                    if ($operator && $num2 !== '') {
                        switch ($operator) {
                            case '+':
                                $result = $num1 + $num2;
                                break;
                            case '-':
                                $result = $num1 - $num2;
                                break;
                            case '*':
                                $result = $num1 * $num2;
                                break;
                            case '/':
                                $result = $num2 != 0 ? $num1 / $num2 : "Error";
                                break;
                        }
                        // Update display with the result and reset for next calculation
                        $display = $num1 . $operator . $num2 . ' = ' . $result;
                        $num1 = $result;
                        $operator = '';
                        $num2 = '';
                        $show_result = true;
                    }
                } elseif (isset($_POST['operator'])) {
                    // Store the operator and update display immediately
                    if ($num1 !== '' && !$show_result) {
                        $operator = $_POST['operator'];
                        $display = $num1 . ' ' . $operator;
                        $num2 = ''; // Reset num2 since a new operation is starting
                    }
                } else {
                    // Handle number and decimal button presses
                    $value = $_POST['value'];
                    if ($show_result) {
                        // If result is displayed, start a new calculation
                        $num1 = '';
                        $num2 = '';
                        $show_result = false;
                    }
                    if ($operator) {
                        // If operator is set, build num2
                        if ($value === '.' && strpos($num2, '.') === false) {
                            $num2 .= $value;
                        } elseif ($value !== '.') {
                            $num2 .= $value;
                        }
                        $display = $num1 . ' ' . $operator . ' ' . $num2;
                    } else {
                        // If operator is not set, build num1
                        if ($value === '.' && strpos($num1, '.') === false) {
                            $num1 .= $value;
                        } elseif ($value !== '.') {
                            $num1 .= $value;
                        }
                        $display = $num1;
                        if (empty($display)) {
                            $display = '0';
                        }
                    }
                }

                // Save the state in session
                $_SESSION['display'] = $display;
                $_SESSION['num1'] = $num1;
                $_SESSION['operator'] = $operator;
                $_SESSION['num2'] = $num2;
                $_SESSION['result'] = $result;
                $_SESSION['show_result'] = $show_result;
            }

            // Show the entire calculation or result
            echo $display;
            ?>
        </div>
        <form method="POST">
            <div class="buttons">
                <button type="submit" name="clear">C</button>
                <button type="submit" name="operator" value="/">/</button>
                <button type="submit" name="operator" value="*">*</button>
                <button type="submit" name="operator" value="-">-</button>

                <button type="submit" name="value" value="7">7</button>
                <button type="submit" name="value" value="8">8</button>
                <button type="submit" name="value" value="9">9</button>
                <button type="submit" name="operator" value="+">+</button>

                <button type="submit" name="value" value="4">4</button>
                <button type="submit" name="value" value="5">5</button>
                <button type="submit" name="value" value="6">6</button>

                <button type="submit" name="value" value="1">1</button>
                <button type="submit" name="value" value="2">2</button>
                <button type="submit" name="value" value="3">3</button>

                <button type="submit" name="value" value="0" class="zero">0</button>
                <button type="submit" name="value" value="." class="decimal">.</button>
                <button type="submit" name="equals" class="equals">=</button>
            </div>
        </form>
    </div>
</body>
</html>
