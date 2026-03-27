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

<h2>Nazionale</h2>
<h3>Generale (2020-2024)</h3>

<?php
// ==========================
// GRAFICO TORTA (TUO ORIGINALE)
// ==========================
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

<canvas id="myChart" style="width:50%;max-width:450px;max-height:600px;"></canvas>

<script>
let xValues = <?php echo json_encode($labels); ?>;
let yValues = <?php echo json_encode($valori); ?>;

const barColors = [
    "#b91d47","#00aba9","#2b5797","#e8c3b9",
    "#1e7145","#ffcc00","#ff6600","#66ccff"
];

new Chart("myChart", {
    type: "pie",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    }
});
</script>

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

<h3>Andamento per anno</h3>
<canvas id="graficoAnno" style="max-width: 700px; max-height:375px;"></canvas>

<h3>Per anno e categoria</h3>
<canvas id="graficoCategorie" style="max-width: 700px; max-height:375px;"></canvas>

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
