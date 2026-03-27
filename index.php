<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osservatorio Droghe - Home</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #333;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--text-color);
        }

        header {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
        }

        header p {
            margin-top: 10px;
            font-size: 1.2rem;
            opacity: 0.9;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 4rem 2rem;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            text-align: center;
        }

        .intro-text {
            margin-bottom: 3rem;
            font-size: 1.1rem;
            color: #555;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .cards-wrapper {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .data-card {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 2.5rem;
            width: 350px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: inherit;
            border-top: 5px solid transparent;
        }

        .data-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .data-card.national {
            border-top-color: var(--secondary-color);
        }

        .data-card.regional {
            border-top-color: var(--accent-color);
        }

        .icon-box {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 2.5rem;
        }

        .national .icon-box {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--secondary-color);
        }

        .regional .icon-box {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--accent-color);
        }

        .data-card h2 {
            margin: 0 0 1rem 0;
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .data-card p {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.5;
            flex-grow: 1;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .national .btn {
            background-color: var(--secondary-color);
            color: white;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .national .btn:hover {
            background-color: #2980b9;
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .regional .btn {
            background-color: var(--accent-color);
            color: white;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .regional .btn:hover {
            background-color: #c0392b;
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }

        footer {
            text-align: center;
            padding: 1.5rem;
            background-color: var(--primary-color);
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            header h1 { font-size: 2rem; }
            .cards-wrapper { flex-direction: column; align-items: center; }
            .data-card { width: 100%; max-width: 400px; }
        }
    </style>
</head>
<body>

<header>
    <h1>Osservatorio Nazionale Droghe</h1>
    <p>Analisi statistica e visualizzazione dati 2020-2024</p>
</header>

<main>
    <div class="container">
        <div class="intro-text">
            <p>Benvenuti nella piattaforma di analisi dati. Esplora le statistiche relative all'uso di sostanze stupefacenti in Italia.
            Seleziona una delle opzioni sottostanti per visualizzare i report dettagliati a livello nazionale o approfondire l'analisi per singola regione.</p>
        </div>

        <div class="cards-wrapper">
            <!-- Card Nazionale -->
            <a href="pag1.php" class="data-card national">
                <div class="icon-box">🇮🇹</div>
                <h2>Dati Nazionali</h2>
                <p>Visualizza l'andamento complessivo su tutto il territorio italiano. Analisi aggregate per categoria, sostanza e trend temporali dal 2020 al 2024.</p>
                <span class="btn">Accedi ai Dati</span>
            </a>

            <!-- Card Regionale -->
            <a href="pag2.php" class="data-card regional">
                <div class="icon-box">🗺️</div>
                <h2>Dati Regionali</h2>
                <p>Approfondisci l'analisi selezionando una specifica regione. Confronta i dati locali con il quadro nazionale e osserva le peculiarità territoriali.</p>
                <span class="btn">Scegli Regione</span>
            </a>
        </div>
    </div>
</main>

<footer>
    &copy; <?php echo date("Y"); ?> Osservatorio Droghe - Progetto di Analisi Dati
</footer>

</body>
</html>
