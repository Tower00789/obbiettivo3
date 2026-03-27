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
        <select name="regione" onchange="this.form.submit()">
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
    </form>

    <?php
    if (isset($_POST['regione']) && !empty($_POST['regione'])) {
        $regione_selezionata = htmlspecialchars($_POST['regione']);

        // Grafico generale regionale (2020-2024)
        $conteggi_regionali = [];

        $file = fopen("abuso_sostanze.csv", "r");

        while(($dati = fgetcsv($file, 0, ";")) !== false){
            $regione = $dati[2];
            $sostanza = $dati[6];

            if(strtoupper($regione) == strtoupper($regione_selezionata)) {
                if(isset($conteggi_regionali[$sostanza])){
                    $conteggi_regionali[$sostanza]++;
                } else {
                    $conteggi_regionali[$sostanza] = 1;
                }
            }
        }

        fclose($file);

        arsort($conteggi_regionali);
        $labels_regionali = array_keys($conteggi_regionali);
        $valori_regionali = array_values($conteggi_regionali);

        if(!empty($labels_regionali)) {
            echo "<h3>Generale (2020-2024) - $regione_selezionata</h3>";
            ?>
            <canvas id="myChartRegionale" style="width:50%;max-width:450px; max-height: 600px;"></canvas>

            <script>
            let xValuesRegionali = <?php echo json_encode($labels_regionali); ?>;
            let yValuesRegionali = <?php echo json_encode($valori_regionali); ?>;

            new Chart("myChartRegionale", {
                type: "pie",
                data: {
                    labels: xValuesRegionali,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValuesRegionali
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: "Distribuzione utilizzo sostanze - <?php echo $regione_selezionata; ?>"
                        }
                    }
                }
            });
            </script>
            <?php

            // Sezione per anno regionale
            echo "<h3>Per anno - $regione_selezionata</h3>";
            ?>
            <form action="" method="POST">
                <input type="hidden" name="regione" value="<?php echo $regione_selezionata; ?>">
                <select name="anno_regionale" onchange="this.form.submit()">
                    <option value="123">-- Scegli un anno --</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                </select>
            </form>
            <?php

            if (isset($_POST['anno_regionale'])) {
                $anno_regionale = htmlspecialchars($_POST["anno_regionale"]) ?? '';
                if (!empty($anno_regionale) && $anno_regionale != '123') {
                    $conteggi_anno_regionali = [];

                    $file = fopen("abuso_sostanze.csv", "r");

                    while(($dati = fgetcsv($file, 0, ";")) !== false){
                        $anno = $dati[0];
                        $regione = $dati[2];
                        $sostanza = $dati[6];

                        if($anno == $anno_regionale && strtoupper($regione) == strtoupper($regione_selezionata)) {
                            if(isset($conteggi_anno_regionali[$sostanza])){
                                $conteggi_anno_regionali[$sostanza]++;
                            } else {
                                $conteggi_anno_regionali[$sostanza] = 1;
                            }
                        }
                    }

                    fclose($file);

                    arsort($conteggi_anno_regionali);
                    $labels_anno_regionali = array_keys($conteggi_anno_regionali);
                    $valori_anno_regionali = array_values($conteggi_anno_regionali);

                    if(!empty($labels_anno_regionali)) {
                        ?>
                        <canvas id="myChartAnnoRegionale" style="width:50%;max-width:450px; max-height: 600px;"></canvas>

                        <script>
                        let xValuesAnnoRegionali = <?php echo json_encode($labels_anno_regionali); ?>;
                        let yValuesAnnoRegionali = <?php echo json_encode($valori_anno_regionali); ?>;

                        new Chart("myChartAnnoRegionale", {
                            type: "pie",
                            data: {
                                labels: xValuesAnnoRegionali,
                                datasets: [{
                                    backgroundColor: barColors,
                                    data: yValuesAnnoRegionali
                                }]
                            },
                            options: {
                                plugins: {
                                    title: {
                                        display: true,
                                        text: "Distribuzione utilizzo sostanze - <?php echo $regione_selezionata . ' (' . $anno_regionale . ')'; ?>"
                                    }
                                }
                            }
                        });
                        </script>
                        <?php
                    } else {
                        echo "<p>Nessun dato disponibile per $regione_selezionata nel $anno_regionale</p>";
                    }
                }
            }
        } else {
            echo "<p>Nessun dato disponibile per la regione selezionata</p>";
        }
    }
    ?>
</body>
</html>
