<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dustore - Каталог игр</title>
    <link rel="stylesheet" href="swad/css/explore.css">
    <?php require_once('swad/controllers/ymcounter.php'); ?>
</head>

<body>
    <?php require_once('swad/static/elements/header.php'); ?>

    <main>
        <section class="games-header">
            <div class="container">
                <h1>Откройте для себя новый мир!</h1>
                <p>Исследуйте лучшие игры от независимых разработчиков</p>
            </div>
        </section>

        <section class="games-list">
            <div class="container">
                <div class="games-controls">
                    <div class="search-bar">
                        <span class="search-icon">🔍</span>
                        <input type="text" placeholder="Введите название игры или тикер разработчика...">
                    </div>
                    <!-- <button class="filter-btn">
                        <span>Фильтры</span>
                        <span>▼</span>
                    </button> -->
                </div>
                <!-- TODO: сделать фильтры -->
                <!-- <div class="categories">
                    <div class="category active">Все</div>
                    <div class="category">Экшен</div>
                    <div class="category">RPG</div>
                    <div class="category">Стратегии</div>
                    <div class="category">Инди</div>
                    <div class="category">Гонки</div>
                    <div class="category">Симуляторы</div>
                    <div class="category">Хоррор</div>
                    <div class="category">Приключения</div>
                    <div class="category">Казуальные</div>
                </div> -->

                <div class="games-grid">
                    <div class="game-card" onclick="window.location.replace('testgame');">
                        <div class="game-image">
                            <img src="https://via.placeholder.com/400x225/74155d/ffffff?text=Super+Game" alt="Super Game">
                            <div class="game-badge">Новинка</div>
                        </div>
                        <div class="game-info">
                            <h3 class="game-title">Super Game</h3>
                            <p class="game-developer">От Super Studio</p>
                            <div class="game-footer">
                                <div class="game-rating">★ 4.7</div>
                                <div class="game-price">149 ₽</div>
                            </div>
                        </div>
                    </div>

                    <div class="game-card">
                        <div class="game-image">
                            <img src="https://via.placeholder.com/400x225/c32178/ffffff?text=Space+Explorer" alt="Space Explorer">
                            <div class="game-badge">Бесплатно</div>
                        </div>
                        <div class="game-info">
                            <h3 class="game-title">Space Explorer</h3>
                            <p class="game-developer">От Space Devs</p>
                            <div class="game-footer">
                                <div class="game-rating">★ 4.3</div>
                                <div class="game-price free">Бесплатно</div>
                            </div>
                        </div>
                    </div>
                </div>
<!-- 
                <div class="pagination">
                    <div class="page-btn">←</div>
                    <div class="page-btn active">1</div>
                    <div class="page-btn">2</div>
                    <div class="page-btn">3</div>
                    <div class="page-btn">4</div>
                    <div class="page-btn">5</div>
                    <div class="page-btn">→</div>
                </div> -->
            </div>
        </section>
    </main>

    <?php require_once('swad/static/elements/footer.php'); ?>

    <script>
        // Анимация для карточек игр
        document.addEventListener('DOMContentLoaded', function() {
            const gameCards = document.querySelectorAll('.game-card');

            gameCards.forEach((card, index) => {
                // Добавляем небольшую задержку для каждой карточки
                card.style.transitionDelay = `${index * 0.05}s`;
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                // Анимация появления
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            });

            // Обработка категорий
            const categories = document.querySelectorAll('.category');
            categories.forEach(category => {
                category.addEventListener('click', function() {
                    categories.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Обработка пагинации
            const pageBtns = document.querySelectorAll('.page-btn');
            pageBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    if (!this.classList.contains('active')) {
                        document.querySelector('.page-btn.active').classList.remove('active');
                        this.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>

</html>