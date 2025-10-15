<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $scalaPartenza = $_POST['scalaPartenza'];
    $scalaArrivo = $_POST['scalaArrivo'];
    $temp = $_POST['temp'];
    

    function convertiTemperatura($temp, $scalaPartenza, $scalaArrivo) {
        if ($scalaPartenza == $scalaArrivo) {
            return $temp; 
        }

        switch ($scalaPartenza) {
        case 'C':
            $tempC = $temp;
            break;
        case 'F':
            $tempC = ($temp - 32) * 5 / 9;
            break;
        case 'K':
            $tempC = $temp - 273.15;
            break;
        default:
            return null;
        }

        switch ($scalaArrivo) {
            case 'C':
                return $tempC;
            case 'F':
                return ($tempC * 9 / 5) + 32;
            case 'K':
                return $tempC + 273.15;
            default:
                return null;
        }
    }

    if ($temp === '' || !is_numeric($temp)) {
        $error = "Inserire una temperatura valida.";
    } else {
        $temp = (float) $temp;
        $result = convertiTemperatura($temp, $scalaPartenza, $scalaArrivo);
        if ($result === null) {
            $error = "Errore nella conversione.";
        }
    }

    $handler = fopen("data/conv.txt", "a");
    echo $handler;

    $ip = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set('Europe/Rome');
    $data = date('d/m/y H:i:s');

    $bytes = fwrite($handler , "".$data." - login by ".$ip." \n". "Scala di partenza --> $scalaPartenza \nScala di arrivo --> $scalaArrivo \nTemperatura Inserita --> $temp \nTemperatura convertita --> $result $scalaArrivo \n\n");
    fclose($handler);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="conv.php" method="post">
        <label><h4>Scala di Partenza:</label>
        <select name="scalaPartenza">
            <option value="C">Celsius</option>
            <option value="F">Fahrenheit</option>
            <option value="K">Kelvin</option>


        </select>
        <br><br>
        <label>Scala di Arrivo:</label>
        <select name="scalaArrivo">
            <option value="C">Celsius</option>
            <option value="F">Fahrenheit</option>
            <option value="K">Kelvin</option>
        
        </select>
        <br><br>

        <label>Inserire temperatura da convertire:</label>
        <input type="number" name="temp" step="1">
        <br>
        <br>
        <input type="submit" value="Converti">

    </form>
    <?php
    if (isset($error)) {
        echo "<p>$error</p>";
    } elseif (isset($result)) {
        echo "<p>Temperatura iniziale --> $temp $scalaPartenza</p>";
        echo "<p>Scala di arrivo --> $scalaArrivo</p>";    
        echo "<p>Temperatura convertita --> $result $scalaArrivo</p>";
    }
    
    ?>
    
</body>
</html>


<?php









