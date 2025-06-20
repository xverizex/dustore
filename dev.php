<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel Dream Studios - Dustore</title>
    <script type="text/javascript" src="https://vk.com/js/api/openapi.js?168"></script>
    <link rel="stylesheet" href="/swad/css/devpage.css">
</head>

<body>
    <?php require_once('swad/static/elements/header.php'); ?>
    <section class="studio-hero">
        <!-- TODO: studio banner in the future? -->
        <!-- <div class="studio-banner" style="background-image: url('https://images.unsplash.com/photo-1552820728-8b83bb6b773f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80')"></div> -->
        <div class="container">
            <div class="studio-content">
                <div class="studio-main">
                    <div class="studio-header">
                        <div class="studio-logo">
                            <img class="studio-logo" src="/swad/static/img/hg-icon.jpg" alt="">
                        </div>
                        <div class="studio-info-header">
                            <h1>Dust Games Studio</h1>
                            <div class="studio-badges">
                                <div class="studio-badge">Основана в 2023</div>
                                <div class="studio-badge">7 сотрудников</div>
                                <div class="studio-badge">2 проекта</div>
                            </div>
                            <div class="studio-stats">
                                <div class="stat-item">
                                    <div class="stat-value">4.9</div>
                                    <div class="stat-label">Рейтинг</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">2</div>
                                    <div class="stat-label">Проекта</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">5.2 тыс</div>
                                    <div class="stat-label">Загрузок</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">96%</div>
                                    <div class="stat-label">Рекомендаций</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="studio-description">
                        <p>Описание студии должно быть уникальным и захватывающим!</p>
                        <p>Наши проекты отличаются большим количеством нововведений, продуманным дизайном и вниманием к деталям. Мы гордимся каждым нашим творением и постоянно стремимся к совершенству, внедряя инновационные решения и прислушиваясь к пользователям.</p>
                    </div>

                    <div class="studio-history">
                        <h2>Наша история</h2>
                        <p>Тут каждая студия может написать свою историю и рассказать всему миру о своих достижениях!</p>
                    </div>

                    <div class="team-section">
                        <h2>Наша команда</h2>
                        <div class="team-members">
                            <div class="team-member">
                                <div class="member-avatar">👨‍💻</div>
                                <h3>Иван Иванов</h3>
                                <p>Основатель & CEO</p>
                            </div>
                            <div class="team-member">
                                <div class="member-avatar">👩‍🎨</div>
                                <h3>Иван Иванов</h3>
                                <p>Главный дизайнер</p>
                            </div>
                            <div class="team-member">
                                <div class="member-avatar">👨‍💻</div>
                                <h3>Иван Иванов</h3>
                                <p>Lead Developer</p>
                            </div>
                        </div>
                    </div>

                    <div class="projects-section">
                        <h2>Наши проекты</h2>
                        <div class="projects-grid">
                            <div class="project-card" onclick="location.href='/game/'">
                                <div class="project-image" style="background: url('https://sun9-20.userapi.com/s/v1/if2/nzU3MRfQv8Cta8d5Ebh4hErtBPSYpZW-1l6ckT5y07f9QMk9nzCa1hyA_L6vx4Hn-4Q3fXCfc58d0uosLmFrYD7i.jpg?quality=95&as=32x18,48x27,72x40,108x61,160x90,240x135,360x202,480x270,540x304,640x360,720x405,1080x607,1280x720&from=bu&u=iumkDXlOU2FTU-ihRb8Zt1Yhr4fKvw18dFtzoKf1ZoY&cs=640x0') no-repeat center center / cover;"></div>
                                <div class="project-info">
                                    <h3 class="project-title">Howl-Growl</h3>
                                    <div class="project-rating">GQI: 98/100</div>
                                    <p>Визуальная новелла с уникальным сюжетом и множеством интересных механик</p>
                                </div>
                            </div>

                            <div class="project-card" onclick="location.href='/game/'">
                                <div class="project-image" style="background: url('/swad/static/img/logo.svg') no-repeat center center / cover;"></div>
                                <div class="project-info">
                                    <h3 class="project-title">DUSTORE</h3>
                                    <div class="project-rating">GQI: 100/100</div>
                                    <p>Российская игровая платформа, где каждый инди-разработчик может разместить свою игру</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="studio-sidebar">
                    <div style="background: rgba(255,255,255,0.05); border-radius: 15px; padding: 25px; margin-bottom: 30px;">
                        <h3>Обратная связь</h3>
                        <div style="margin-top: 20px;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                                <div style="font-size: 1.5rem;">🌐</div>
                                <div>https://dustore.ru/d/dgscorp</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                                <div style="font-size: 1.5rem;">✉️</div>
                                <div>support@dustore.ru</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                                <div style="font-size: 1.5rem;">📱</div>
                                <div>Telegram: @dgscorp</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="font-size: 1.5rem;">🏢</div>
                                <div>Россия</div>
                            </div>
                            <div id="vk_groups" style="padding: 1rem;"></div>
                            <script type="text/javascript">
                                VK.Widgets.Group("vk_groups", {
                                    mode: 3,
                                    height: 400,
                                    color1: "FFFFFF",
                                    color2: "000000",
                                    color3: "c32178"
                                }, 218097832);
                            </script>
                        </div>
                    </div>

                    <div style="background: rgba(255,255,255,0.05); border-radius: 15px; padding: 25px; margin-bottom: 30px;">
                        <h3>Награды и достижения</h3>
                        <div style="margin-top: 20px;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                                <div style="font-size: 2rem;">🏆</div>
                                <div>Лучшая инди-студия 2025</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; padding-bottom: 15px;">
                                <div style="font-size: 2rem;">💡</div>
                                <div>Инновация в геймдеве (2025)</div>
                            </div>
                        </div>
                    </div>

                    <div style="background: rgba(255,255,255,0.05); border-radius: 15px; padding: 25px;">
                        <h3>Статьи</h3>
                        <div style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 10px; margin-top: 20px;">
                            <div style="text-align: center; padding: 15px; background: rgba(0,0,0,0.2); border-radius: 10px;">
                                <div style="font-size: 1rem;">Тут каждая студия-разработчик сможет разместить свою статью</div>
                            </div>
                            <div style="text-align: center; padding: 15px; background: rgba(0,0,0,0.2); border-radius: 10px;">
                                <div style="font-size: 1rem;">Это может быть объявление игрокам или новостной пост</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once('swad/static/elements/footer.php'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Анимация элементов при загрузке
            const animateElements = [
                ...document.querySelectorAll('.studio-logo, .stat-item'),
                ...document.querySelectorAll('.team-member'),
                ...document.querySelectorAll('.project-card')
            ];

            animateElements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = `all 0.5s ease ${index * 0.1}s`;

                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>
</body>

</html>