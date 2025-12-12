<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dustore — Статистика</title>

    <link rel="stylesheet" href="/swad/css/pages.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .chart-wrapper {
            max-width: 900px;
            margin: 40px auto;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 40px;
        }

        .chart-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .chart-btn {
            padding: 10px 20px;
            border-radius: 20px;
            border: 2px solid var(--primary);
            background: transparent;
            color: white;
            cursor: pointer;
            transition: .3s;
        }

        .chart-btn.active {
            background: var(--primary);
        }

        @media(max-width: 600px) {
            .chart-wrapper {
                padding: 0 15px;
            }
        }
    </style>
</head>

<body>

    <?php require_once('swad/static/elements/header.php'); ?>

    <section>
        <div class="container">
            <h2>Статистика Dustore</h2>

            <div class="chart-buttons">
                <button class="chart-btn active" data-chart="users_new">Регистрации игроков</button>
                <button class="chart-btn" data-chart="studios_new">Студии за день</button>
                <button class="chart-btn" data-chart="games_new">Добавленные игры</button>
                <button class="chart-btn" data-chart="published_new">Опубликованные игры</button>
            </div>

            <div class="chart-wrapper">
                <div class="chart-card">
                    <canvas id="statsChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <script>
        let stats = null;
        let chart = null;

        async function loadStats() {
            const r = await fetch("/swad/controllers/statdata.php"); 
            stats = await r.json();
        }

        function createChart(type) {
            const ctx = document.getElementById("statsChart").getContext("2d");

            if (chart) chart.destroy();

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: stats.map(row => row.date),
                    datasets: [{
                        label: "Количество",
                        data: stats.map(row => row[type]),
                        borderWidth: 3,
                        borderColor: "#c32178",
                        fill: true,
                        backgroundColor: "rgba(195,33,120,0.25)",
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: "#c32178"
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            ticks: {
                                color: "#fff"
                            }
                        },
                        y: {
                            ticks: {
                                color: "#fff"
                            },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: "#fff"
                            }
                        }
                    }
                }
            });
        }

        // Переключение кнопок
        document.querySelectorAll(".chart-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                document.querySelectorAll(".chart-btn").forEach(x => x.classList.remove("active"));
                btn.classList.add("active");
                createChart(btn.dataset.chart);
            });
        });

        // init
        (async () => {
            await loadStats();
            createChart("users_new");
        })();
    </script>

</body>

</html>