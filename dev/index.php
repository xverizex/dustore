<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Developer Console</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        :root {
            --space: #0f172a;
            --neon: #7c3aed;
            --hud: #2dd4bf;
            --interface: #1e293b;
        }

        * {
            margin: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--space);
            color: white;
            min-height: 100vh;
        }

        .console {
            max-width: 1440px;
            margin: 0 auto;
            padding: 2rem;
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 2rem;
        }

        /* Навигация */
        .nav-panel {
            border-right: 1px solid var(--interface);
            padding-right: 2rem;
            height: calc(100vh - 4rem);
            position: sticky;
            top: 2rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            transition: 0.2s;
            margin-bottom: 0.5rem;
        }

        .nav-item:hover {
            background: var(--interface);
        }

        /* Основной контент */
        .main-content {
            display: grid;
            gap: 2rem;
        }

        /* Карточка проекта */
        .project-card {
            background: var(--interface);
            border: 1px solid #334155;
            border-radius: 16px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .project-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, 
                transparent 49.9%, 
                var(--neon) 50%, 
                transparent 50.1%
            );
            animation: gridScan 8s infinite linear;
            opacity: 0.1;
        }

        .project-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .project-badge {
            background: #334155;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.9rem;
        }

        .project-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .metric-item {
            text-align: center;
        }

        .metric-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--hud);
            margin-bottom: 0.5rem;
        }

        /* Команда */
        .team-section {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .member-card {
            background: var(--interface);
            border-radius: 12px;
            padding: 1.5rem;
            position: relative;
        }

        .member-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .member-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        .task-list {
            border-top: 1px solid #334155;
            padding-top: 1rem;
        }

        .task-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0;
        }

        /* Графики */
        .analytics-panel {
            background: var(--interface);
            border-radius: 16px;
            padding: 2rem;
            position: relative;
        }

        .chart-container {
            height: 400px;
        }

        @keyframes gridScan {
            0% { transform: translate(0,0); }
            100% { transform: translate(50%,50%); }
        }
    </style>
</head>
<body>
    <div class=" console">
    <!-- Навигация -->
    <nav class="nav-panel">
        <div class="nav-item">
            <span class="material-icons">dashboard</span>
            Обзор
        </div>
        <div class="nav-item">
            <span class="material-icons">sports_esports</span>
            Проекты
        </div>
        <div class="nav-item">
            <span class="material-icons">groups</span>
            Команда
        </div>
        <div class="nav-item">
            <span class="material-icons">analytics</span>
            Аналитика
        </div>
    </nav>

    <!-- Основной контент -->
    <main class="main-content">
        <!-- Проекты -->
        <div class="project-card">
            <div class="project-header">
                <h2>Cyber Revolution</h2>
                <div class="project-badge">
                    <span class="material-icons">public</span>
                    Опубликовано
                </div>
            </div>
            <div class="project-grid">
                <div class="metric-item">
                    <div class="metric-value">142K</div>
                    <div>Просмотры</div>
                </div>
                <div class="metric-item">
                    <div class="metric-value">24K</div>
                    <div>Скачивания</div>
                </div>
                <div class="metric-item">
                    <div class="metric-value">$8.4K</div>
                    <div>Доход</div>
                </div>
                <div class="metric-item">
                    <div class="metric-value">4.8</div>
                    <div>Рейтинг</div>
                </div>
            </div>
        </div>

        <!-- Команда -->
        <div class="team-section">
            <div class="member-card">
                <div class="member-header">
                    <img src="avatar.jpg" class="member-avatar" alt="Аватар">
                    <div>
                        <h4>Александр Ливанов</h4>
                        <p>Tech Lead</p>
                    </div>
                </div>
                <div class="task-list">
                    <div class="task-item">
                        <span class="material-icons">code</span>
                        Оптимизация рендеринга
                    </div>
                    <div class="task-item">
                        <span class="material-icons">bug_report</span>
                        Исправление физики
                    </div>
                </div>
            </div>
        </div>

        <!-- Аналитика -->
        <div class="analytics-panel">
            <h3>Динамика проекта</h3>
            <div class="chart-container">
                <canvas id="analyticsChart"></canvas>
            </div>
        </div>
    </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('analyticsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май'],
                datasets: [{
                        label: 'Активные игроки',
                        data: [12000, 19000, 30000, 28000, 42000],
                        borderColor: '#7c3aed',
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(124, 58, 237, 0.1)'
                    },
                    {
                        label: 'Доход ($)',
                        data: [2400, 3900, 6000, 5400, 9200],
                        borderColor: '#2dd4bf',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#fff'
                        }
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: '#334155'
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    },
                    x: {
                        grid: {
                            color: '#334155'
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    }
                }
            }
        });
    </script>
    </body>

</html>