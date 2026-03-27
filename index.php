<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abuso di sostanze</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <h1>ABUSO DI SOSTANZE IN ITALIA</h1>
    <h2>Nazionale</h2>
    <h3>Generale (2020-2024)</h3>
   <?php
$conteggi = [];

$file = fopen("abuso_sostanze.csv", "r");

while(($dati = fgetcsv($file, 0, ";")) !== false){
    $sostanza = $dati[6];

    if(isset($conteggi[$sostanza])){
        $conteggi[$sostanza]++;
    } else {
        $conteggi[$sostanza] = 1;
    }
}

fclose($file);

arsort($conteggi);
$labels = array_keys($conteggi);
$valori = array_values($conteggi);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0"></script>

<canvas id="myChart" style="width:50%;max-width:450px; max-height: 600px;"></canvas>

<script>
let xValues = <?php echo json_encode($labels); ?>;
let yValues = <?php echo json_encode($valori); ?>;

const barColors = [
    "#b91d47",
    "#00aba9",
    "#2b5797",
    "#e8c3b9",
    "#1e7145",
    "#ffcc00",
    "#ff6600",
    "#66ccff"
];

new Chart("myChart", {
    type: "pie",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: "Distribuzione utilizzo sostanze"
            }
        }
    }
});
</script>

    <h3>Per anno</h3>
    
        <form action=""  method="POST">
            <select name="anno_nazionale" onchange="this.form.submit()">
                <option value="123">-- Scegli un anno --</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
            </select>
        </form>

    <?php
    if (isset($_POST['anno_nazionale'])) {
        $anno = htmlspecialchars($_POST["anno_nazionale"]) ?? '';
        if (!empty($anno)) {
            switch ($anno) {
                case '2020':
                    echo "a";
                    break;
                case '2021':
                    echo "b";
                    break;
                case '2022':
                    # code...
                    break;
                case '2023':
                    # code...
                    break;
                case '2024':
                    # code...
                    break;
                case '123':
                    break;
                default:
                    die("Errore nella selezione dell'anno per il grafico nazionale");
                    break;
            }
        }
    }
    ?>

    <h2>Regionale</h2>
    <form action="" method="post">
        <select name="regione">
            <option value="">-- Scegli la regione --</option>
            <option value="Valle d'Aosta">Valle d'Aosta</option>
            <option value="Piemonte">Piemonte</option>
            <option value="Lombardia">Lombardia</option>
            <option value="Trentino-Alto Adige">Trentino-Alto Adige</option>
            <option value="Friuli-Venezia Giulia">Friuli-Venezia Giulia</option>
            <option value="Veneto">Veneto</option>
            <option value="Liguria">Liguria</option>
            <option value="Emilia-Romagna">Emilia-Romagna</option>
            <option value="Toscana">Toscana</option>
            <option value="Umbria">Umbria</option>
            <option value="Marche">Marche</option>
            <option value="Lazio">Lazio</option>
            <option value="Abruzzo">Abruzzo</option>
            <option value="Campania">Campania</option>
            <option value="Molise">Molise</option>
            <option value="Basilicata">Basilicata</option>
            <option value="Puglia">Puglia</option>
            <option value="Calabria">Calabria</option>
            <option value="Sardegna">Sardegna</option>
            <option value="Sicilia">Sicilia</option>
        </select>
        <input type="submit" value="Leggi i dati">
    </form>

    <?php
        fclose($file);
    ?>
</body>
</html>-->