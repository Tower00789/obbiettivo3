<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abuso di sostanze</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h1>ABUSO DI SOSTANZE IN ITALIA</h1>

<?php
// ==========================
// LETTURA DATI PER I GRAFICI A LINEE
// ==========================
$file = fopen("abuso_sostanze.csv", "r");
fgetcsv($file, 0, ";");

$totali_per_anno = [];
$dati_categoria = [];
$dati_regioni = [];

$popolazione = [
        "LOMBARDIA"=>10000000,"LAZIO"=>5900000,"CAMPANIA"=>5600000,
        "SICILIA"=>4800000,"VENETO"=>4900000,"Emilia-Romagna"=>4400000,
        "Piemonte"=>4300000,"Puglia"=>3900000,"Toscana"=>3600000,
        "Calabria"=>1900000,"Sardegna"=>1600000,"Liguria"=>1500000,
        "Marche"=>1500000,"Abruzzo"=>1300000,"Friuli-Venezia Giulia"=>1200000,
        "Trentino-Alto Adige"=>1100000,"Umbria"=>870000,"Basilicata"=>540000,
        "Molise"=>290000,"Valle d'Aosta"=>125000
    ];

while(($dati = fgetcsv($file, 0, ";")) !== false){
    $anno = $dati[0];
    $regione = $dati[2];
    $categoria = $dati[6];
    $utenti = (int)$dati[7];

    $totali_per_anno[$anno] = ($totali_per_anno[$anno] ?? 0) + $utenti;

    $dati_categoria[$categoria][$anno] = ($dati_categoria[$categoria][$anno] ?? 0) + $utenti;

    $dati_regioni[$regione][$anno] = ($dati_regioni[$regione][$anno] ?? 0) + $utenti;
}

fclose($file);

ksort($totali_per_anno);
$anni = array_keys($totali_per_anno);
$valori_anno = array_values($totali_per_anno);

// categorie
$datasets_categorie = [];
foreach($dati_categoria as $categoria => $valori){
    $data = [];
    foreach($anni as $a){
        $data[] = $valori[$a] ?? 0;
    }

    $datasets_categorie[] = [
        "label" => $categoria,
        "data" => $data,
        "fill" => false
    ];
}

// regioni


$datasets_regioni = [];
foreach($dati_regioni as $regione => $valori){
    $data = [];
    foreach($anni as $a){
        $data[] = $valori[$a] ?? 0;

    }

    $datasets_regioni[] = [
        "label" => $regione,
        "data" => $data,
        "fill" => false
    ];
}
?>

<h2>Regionale</h2>

<!-- Selettore Regione -->
<form method="get">
    <label for="regione">Seleziona Regione:</label>
    <select name="regione" id="regione" onchange="this.form.submit()">
        <option value="">-- Scegli una regione --</option>
        <?php
        $regioni_disponibili = array_keys($dati_regioni);
        sort($regioni_disponibili);
        foreach($regioni_disponibili as $reg):
            $selected = (isset($_GET['regione']) && $_GET['regione'] === $reg) ? 'selected' : '';
        ?>
            <option value="<?php echo htmlspecialchars($reg); ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($reg); ?></option>
        <?php endforeach; ?>
    </select>
</form>

<?php if(isset($_GET['regione']) && !empty($_GET['regione'])): ?>
    <?php
    $regione_selezionata = $_GET['regione'];

    // Grafico a torta generale per la regione (2020-2024) - simile al nazionale
    $conteggi_regione = [];
    $file = fopen("abuso_sostanze.csv", "r");
    while(($dati = fgetcsv($file, 0, ";")) !== false){
        if(strtoupper(trim($dati[2])) === strtoupper(trim($regione_selezionata))){
            $sostanza = trim($dati[6]);
            $conteggi_regione[$sostanza] = ($conteggi_regione[$sostanza] ?? 0) + 1;
        }
    }
    fclose($file);

    arsort($conteggi_regione);
    $labels_regione = array_keys($conteggi_regione);
    $valori_regione = array_values($conteggi_regione);
    ?>

    <h3><?php echo htmlspecialchars($regione_selezionata); ?> - Generale (2020-2024)</h3>
    <canvas id="graficoRegioneTorta" style="width:50%;max-width:450px;max-height:600px;"></canvas>

    <script>
    let xValuesRegione = <?php echo json_encode($labels_regione); ?>;
    let yValuesRegione = <?php echo json_encode($valori_regione); ?>;

    const barColorsRegione = [
        "#b91d47","#00aba9","#2b5797","#e8c3b9",
        "#1e7145","#ffcc00","#ff6600","#66ccff"
    ];

    new Chart("graficoRegioneTorta", {
        type: "pie",
        data: {
            labels: xValuesRegione,
            datasets: [{
                backgroundColor: barColorsRegione,
                data: yValuesRegione
            }]
        }
    });
    </script>

    <?php
    // Dati per il grafico annuale della regione
    if(isset($_GET['anno']) && !empty($_GET['anno'])){
        $anno_selezionato = $_GET['anno'];
        $conteggi_annuali_regione = [];
        $file = fopen("abuso_sostanze.csv", "r");
        while(($dati = fgetcsv($file, 0, ";")) !== false){
            if(strtoupper(trim($dati[2])) === strtoupper(trim($regione_selezionata)) && $dati[0] == $anno_selezionato){
                $sostanza = trim($dati[6]);
                $conteggi_annuali_regione[$sostanza] = ($conteggi_annuali_regione[$sostanza] ?? 0) + 1;
            }
        }
        fclose($file);

        arsort($conteggi_annuali_regione);
        $labels_annuali = array_keys($conteggi_annuali_regione);
        $valori_annuali = array_values($conteggi_annuali_regione);

        if(!empty($labels_annuali)){
    ?>
        <h3><?php echo htmlspecialchars($regione_selezionata); ?> - Anno <?php echo htmlspecialchars($anno_selezionato); ?></h3>
        <canvas id="graficoRegioneAnno" style="width:50%;max-width:450px;max-height:600px;"></canvas>

        <script>
        let xValuesAnno = <?php echo json_encode($labels_annuali); ?>;
        let yValuesAnno = <?php echo json_encode($valori_annuali); ?>;

        new Chart("graficoRegioneAnno", {
            type: "pie",
            data: {
                labels: xValuesAnno,
                datasets: [{
                    backgroundColor: barColorsRegione,
                    data: yValuesAnno
                }]
            }
        });
        </script>
    <?php
        } else {
            echo "<p>Nessun dato disponibile per l'anno selezionato.</p>";
        }
    }
    ?>

    <!-- Grafici regionali: andamento per anno, per categoria, per sostanza -->
    <h3><?php echo htmlspecialchars($regione_selezionata); ?> - Andamento per anno</h3>
    <canvas id="graficoRegioneAnnoLine" style="max-width: 700px; max-height:375px;"></canvas>

    <h3><?php echo htmlspecialchars($regione_selezionata); ?> - Per anno e categoria</h3>
    <canvas id="graficoRegioneSostanze" style="max-width: 700px; max-height:375px;"></canvas>

    <script>
    // Dati per i grafici a linee della regione selezionata
    let anniRegione = <?php
        $anni_regione_line = [];
        foreach($anni as $a){
            if(isset($dati_regioni[$regione_selezionata][$a])){
                $anni_regione_line[] = $a;
            }
        }
        echo json_encode($anni_regione_line);
    ?>;

    // Totale utenti per anno nella regione
    let totaleRegioneAnno = <?php
        $totale_regione_anno = [];
        foreach($anni_regione_line as $a){
            $totale_regione_anno[] = $dati_regioni[$regione_selezionata][$a] ?? 0;
        }
        echo json_encode($totale_regione_anno);
    ?>;

    // Categorie per anno nella regione
    let datiCategoriaRegione = <?php
        $dati_categoria_regione = [];
        foreach($dati_categoria as $categoria => $valori_cat){
            $data_cat = [];
            $hasData = false;
            foreach($anni_regione_line as $a){
                $val = $valori_cat[$a] ?? 0;
                $data_cat[] = $val;
                if($val > 0) $hasData = true;
            }
            if($hasData){
                $dati_categoria_regione[] = [
                    "label" => $categoria,
                    "data" => $data_cat,
                    "fill" => false
                ];
            }
        }
        echo json_encode($dati_categoria_regione);
    ?>;

    // Sostanze per anno nella regione
    let datiSostanzaRegione = <?php
        // Ricostruiamo i dati per sostanza dalla regione selezionata
        $dati_sostanza_regione_raw = [];
        $file = fopen("abuso_sostanze.csv", "r");
        fgetcsv($file, 0, ";");
        while(($dati = fgetcsv($file, 0, ";")) !== false){
            if(strtoupper(trim($dati[2])) === strtoupper(trim($regione_selezionata))){
                $anno = $dati[0];
                $sostanza = trim($dati[6]);
                $utenti = (int)$dati[7];
                $dati_sostanza_regione_raw[$sostanza][$anno] = ($dati_sostanza_regione_raw[$sostanza][$anno] ?? 0) + $utenti;
            }
        }
        fclose($file);

        $dati_sostanza_regione = [];
        foreach($dati_sostanza_regione_raw as $sostanza => $valori_sost){
            $data_sost = [];
            $hasData = false;
            foreach($anni_regione_line as $a){
                $val = $valori_sost[$a] ?? 0;
                $data_sost[] = $val;
                if($val > 0) $hasData = true;
            }
            if($hasData){
                $dati_sostanza_regione[] = [
                    "label" => $sostanza,
                    "data" => $data_sost,
                    "fill" => false
                ];
            }
        }
        echo json_encode($dati_sostanza_regione);
    ?>;

    // GRAFICO 1 Regionale - Andamento per anno
    new Chart("graficoRegioneAnnoLine", {
        type: "line",
        data: {
            labels: anniRegione,
            datasets: [{
                label: "Totale utenti",
                data: totaleRegioneAnno,
                borderColor: "blue",
                tension: 0.3
            }]
        }
    });

    // GRAFICO 2 Regionale - Per anno e categoria
    new Chart("graficoRegioneCategorie", {
        type: "line",
        data: {
            labels: anniRegione,
            datasets: datiCategoriaRegione
        }
    });

    // GRAFICO 3 Regionale - Per anno e sostanza
    new Chart("graficoRegioneSostanze", {
        type: "line",
        data: {
            labels: anniRegione,
            datasets: datiSostanzaRegione
        }
    });
    </script>

<?php else: ?>
    <p>Seleziona una regione per visualizzare i dati.</p>
<?php endif; ?>

<script>
// GRAFICO 1
new Chart("graficoAnno", {
    type: "line",
    data: {
        labels: <?php echo json_encode($anni); ?>,
        datasets: [{
            label: "Totale utenti",
            data: <?php echo json_encode($valori_anno); ?>,
            borderColor: "blue",
            tension: 0.3
        }]
    }
});

// GRAFICO 2
new Chart("graficoCategorie", {
    type: "line",
    data: {
        labels: <?php echo json_encode($anni); ?>,
        datasets: <?php echo json_encode($datasets_categorie); ?>
    }
});

// GRAFICO 3
new Chart("graficoRegioni", {
    type: "line",
    data: {
        labels: <?php echo json_encode($anni); ?>,
        datasets: <?php echo json_encode($datasets_regioni); ?>
    }
});
</script>

</body>
</html>
