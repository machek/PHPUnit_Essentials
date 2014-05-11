<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sandbox</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container" style="width:500px">
    <div style="width:250px; float: right;">
        <h1 class="page-header">Selenium Sandbox</h1>

        <h2>Input</h2>

        <form method="post" action="" role="form">
            <div class="form-group">
                <label for="number_a">Number A</label>
                <input name="number_a" id="number_a" type="number" class="form-control" />
                <br/>
                <label for="number_b">Number B</label>
                <input name="number_b" id="number_b" type="number" class="form-control" />
            </div>
            <div class="form-group">
                <label for="addition">Addition</label>
                <input type="checkbox" value="addition" id="addition" name="operation[]"/>
                <label for="subtraction">Subtraction</label>
                <input type="checkbox" value="substitution" id="substitution" name="operation[]"/>
                <label for="multiplication">Multiplication</label>
                <input type="checkbox" value="multiplication" id="multiplication" name="operation[]"/>
                <label for="division">Division</label>
                <input type="checkbox" value="division" id="division" name="operation[]"/>
            </div>
            <div class="form-group">
                <input type="submit" value="Calculate" class="btn"/>
            </div>
        </form>
    </div>
    <div style="width:200px;">
        <h2>Result</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (!isset($_POST['number_a'])
            || !isset($_POST['number_b'])
            || !isset($_POST['operation'])
        )
        {
            throw new InvalidArgumentException('Missing required argument');
        }

        $number_a = floatval($_POST['number_a']);
        $number_b = floatval($_POST['number_b']);

        echo "<p>Number A: {$number_a}<br/>Number B: {$number_b}</p>";
        foreach ($_POST['operation'] as $operation)
        {
            switch ($operation)
            {
                case 'addition':
                    echo 'Addition = <span id="result_addition">' . ($number_a + $number_b) . '</span><br />';
                    break;
                case 'substitution':
                    echo 'Subtraction = <span id="result_substitution">' . ($number_a - $number_b) . '</span><br />';
                    break;
                case 'multiplication':
                    echo 'Multiplication = <span id="result_multiplication">' . ($number_a * $number_b) . '</span><br />';
                    break;
                case 'division':
                    echo 'Division = <span id="result_division">' . ($number_a / $number_b) . '</span><br />';
                    break;
            }
        }
    }
    ?>
    </div>
</div>
</body>
</html>