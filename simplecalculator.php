<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP Calculator - Table Layout</title>
    <style>
        table {
            border-collapse: collapse;
            width: 300px;
            margin: 0 auto;
        }
        td {
            padding: 10px;
            text-align: center;
        }
        input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Simple PHP Calculator</h2>
    <form action="" method="POST">
        <table border="1">
            <tr>
                <td colspan="4">
                    <label for="num1">First Number:</label><br>
                    <input type="number" id="num1" name="num1" required>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <label for="num2">Second Number:</label><br>
                    <input type="number" id="num2" name="num2" required>
                </td>
            </tr>
            <tr>
                <td><input type="submit" name="operation" value="+"></td>
                <td><input type="submit" name="operation" value="-"></td>
                <td><input type="submit" name="operation" value="*"></td>
                <td><input type="submit" name="operation" value="/"></td>
            </tr>
        </table>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and sanitize input data
        $num1 = (float)$_POST['num1'];
        $num2 = (float)$_POST['num2'];
        $operation = $_POST['operation'];
        $result = '';

        // Perform the calculation based on the selected operation
        switch ($operation) {
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
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                } else {
                    $result = "Error: Division by zero!";
                }
                break;
            default:
                $result = "Invalid operation selected!";
                break;
        }

        // Display the result
        echo "<h3 style='text-align: center;'>Result: $num1 $operation $num2 = $result</h3>";
    }
    ?>
</body>
</html>