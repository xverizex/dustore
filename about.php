<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dustore - О платформе</title>
    <link rel="stylesheet" href="swad/css/pages.css">
    <?php require_once('swad/controllers/ymcounter.php'); ?>
    <style>

    </style>
</head>

<body>
    <?php require_once('swad/static/elements/header.php'); ?>

    <main>
        <section class="about-hero">
            <div class="container">
                <h1>О платформе Dustore</h1>
                <p>Инновационная игровая экосистема, созданная для объединения разработчиков и игроков</p>
            </div>
        </section>

        <section class="mission">
            <div class="container">
                <h2>Наша миссия</h2>
                <p class="mission-statement">"Создать пространство, где талантливые разработчики могут реализовать свои идеи, а игроки — открывать для себя уникальные проекты"</p>
                <p>Dustore — это не просто магазин игр, а полноценная экосистема для инди-разработчиков и ценителей качественного геймдева. Мы стремимся разрушить барьеры между создателями и игроками, предоставляя инструменты для прямого взаимодействия и совместного творчества.</p>
            </div>
        </section>

        <section class="team">
            <div class="container">
                <h2>Команда DUSTORE</h2>
                <p>Наша команда состоит из энтузиастов игровой индустрии, которые верят в потенциал независимой разработки</p>

                <h1>Dust Games Studio
                    <a href="https://vk.com/dgscorp" class="team-link">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="32"
                            height="32"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#ffffff"
                            stroke-width="1"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M14 19h-4a8 8 0 0 1 -8 -8v-5h4v5a4 4 0 0 0 4 4h0v-9h4v4.5l.03 0a4.531 4.531 0 0 0 3.97 -4.496h4l-.342 1.711a6.858 6.858 0 0 1 -3.658 4.789h0a5.34 5.34 0 0 1 3.566 4.111l.434 2.389h0h-4a4.531 4.531 0 0 0 -3.97 -4.496v4.5z" />
                        </svg>
                    </a>
                    <a href="https://t.me/dgscorp" class="team-link">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="32"
                            height="32"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#ffffff"
                            stroke-width="1"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                        </svg>
                    </a>
                </h1>
                <div class="team-grid">
                    <div class="team-member">
                        <img src="swad/static/img/team/eshwardwilliams_dgstore.webp" alt="Эш :)" class="team-avatar">
                        <h3 class="team-name">Эш (Eshward Williams)</h3>
                        <p class="team-role">Основатель & CEO</p>
                        <p>Идейный вдохновитель проекта, отвечает за стратегическое развитие платформы</p>
                        <a class="team-link" href="https://t.me/dgscorp">https://t.me/dgscorp</a>
                    </div>
                </div>
                <div style="margin-top: 50px;"></div>
                <h1>Crazy Projects Lab Russia
                    <a href="https://vk.com/crazyprojectslab" class="team-link">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="32"
                            height="32"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#ffffff"
                            stroke-width="1"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M14 19h-4a8 8 0 0 1 -8 -8v-5h4v5a4 4 0 0 0 4 4h0v-9h4v4.5l.03 0a4.531 4.531 0 0 0 3.97 -4.496h4l-.342 1.711a6.858 6.858 0 0 1 -3.658 4.789h0a5.34 5.34 0 0 1 3.566 4.111l.434 2.389h0h-4a4.531 4.531 0 0 0 -3.97 -4.496v4.5z" />
                        </svg>
                    </a>
                </h1>
                <div class="team-grid">
                    <div class="team-member">
                        <img src="/swad/static/img/team/alexanderlivanov_cplrus.webp" alt="Санечка I :)" class="team-avatar">
                        <h3 class="team-name">Александр Ливанов</h3>
                        <p class="team-role">Ведущий программист</p>
                        <p>Архитектура платформы, дизайн и разработка</p>
                        <a class="team-link" href="https://t.me/indepcode">https://t.me/indepcode</a>
                    </div>

                    <div class="team-member">
                        <img src="/swad/static/img/team/alexanderpartikevich_cplrus.webp" alt="Санечка II :)" class="team-avatar">
                        <h3 class="team-name">Александр Партикевич</h3>
                        <p class="team-role">Арт-директор</p>
                        <p>Логотипы и визуальная концепция проекта</p>
                        <a class="team-link" href="https://t.me/Portfolio_Aleksandr_Partikevich">https://t.me/Aleksandr_MotionGraphics</a>
                    </div>
                </div>
                <div style="margin-top: 50px;"></div>
            </div>

            <h1>Партнёры</h1>
            <p>Тут могли бы быть вы</p>
            <!-- <marquee behavior="alternate">
                <img src="/swad/static/img/team/alexanderpartikevich_cplrus.webp" alt="" class="team-avatar">
            </marquee> -->
        </section>

        <section class="values">
            <div class="container">
                <h2>Наши ценности</h2>
                <p>Это именно то, что делает нас необычным и ценным игроком на рынке</p>

                <div class="values-grid">
                    <div class="value-card">
                        <div class="value-icon">💡</div>
                        <h3 class="value-title">Инновации</h3>
                        <p>Мы активно внедряем новые фичи и технологии, чтобы сделать платформу лучше для всех участников</p>
                    </div>

                    <div class="value-card">
                        <div class="value-icon">🤝</div>
                        <h3 class="value-title">Сообщество</h3>
                        <p>Верим в силу сообщества и создаем инструменты для взаимодействия разработчиков и игроков</p>
                    </div>

                    <div class="value-card">
                        <div class="value-icon">⚖️</div>
                        <h3 class="value-title">Справедливость</h3>
                        <p>Строим прозрачную систему с честными условиями для всех участников экосистемы</p>
                    </div>

                    <div class="value-card">
                        <div class="value-icon">🎮</div>
                        <h3 class="value-title">Страсть к играм</h3>
                        <p>Мы сами большие фанаты игр и создаем платформу, которую хотели бы видеть как игроки</p>
                    </div>

                    <div class="value-card">
                        <div class="value-icon">👩‍💻</div>
                        <h3 class="value-title">Взаимопомощь</h3>
                        <p>Пытаемся создать единый информационный ресурс, где разработчики смогут обмениваться опытом и информацией</p>
                    </div>

                    <div class="value-card">
                        <div class="value-icon">🎨</div>
                        <h3 class="value-title">Отзывчивость</h3>
                        <p>Мы заинтересованы в создании лучшей платформы, поэтому прислушиваемся к советам и критике</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="timeline">
            <div class="container">
                <h2>Наша история и планы</h2>
                <p>Ключевые этапы развития платформы</p>

                <div class="timeline-item">
                    <div class="timeline-date">
                        <h3>с 22.12.2024:</h3>
                    </div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Идея и начало</h3>
                        <p>Формирование концепции платформы, первые наработки архитектуры и дизайна.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-date">
                        <h3>с 15.02.2025:</h3>
                    </div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Разработка</h3>
                        <p>Создание первой рабочей версии платформы, работа над базовым функционалом.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-date">
                        <h3>с 06.05.2025:</h3>
                    </div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Регистрация</h3>
                        <p>Зарегистрировано доменное имя dustore.ru. Взят курс на доработку MVP платформы.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-date">
                        <h3>с 01.07.2025:</h3>
                    </div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Программа Предварительной Оценки (ППО)</h3>
                        <p>Запускаем первых разработчиков на специальных условиях, допиливаем всё напильником.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-date">
                        <h3>с 01.08.2025:</h3>
                    </div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Открытое бета-тестирование</h3>
                        <p>Открываем доступ к платформе для всех разработчиков и игроков. Будет больше всего фич и доработок.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-date">
                        <h3>с 01.10.2025:</h3>
                    </div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Официальный релиз</h3>
                        <p>Полностью рабочая и функционирующая экосистема. Курс на популяризацию платформы.</p>
                    </div>
                </div>
            </div>

            <h2 style="text-align: center; margin-top: 50px;">Каждый может стать не просто частью игровой платформы, а своим вкладом повлиять на её разработку!</h2>
        </section>
    </main>

    <?php require_once('swad/static/elements/footer.php'); ?>

    <script>
        // Анимация для элементов страницы
        document.addEventListener('DOMContentLoaded', function() {
            const animateOnScroll = (elements) => {
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.3;

                    if (elementPosition < screenPosition) {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }
                });
            };

            // Инициализация анимаций
            const teamMembers = document.querySelectorAll('.team-member');
            const valueCards = document.querySelectorAll('.value-card');
            const timelineItems = document.querySelectorAll('.timeline-item');

            // Установка начального состояния
            teamMembers.forEach(member => {
                member.style.opacity = '0';
                member.style.transform = 'translateY(30px)';
                member.style.transition = 'all 0.6s ease';
            });

            valueCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s ease';
            });

            timelineItems.forEach(item => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-30px)';
                item.style.transition = 'all 0.6s ease';
            });

            // Первая анимация при загрузке
            setTimeout(() => {
                animateOnScroll(teamMembers);
                animateOnScroll(valueCards);
                animateOnScroll(timelineItems);
            }, 300);

            // Анимация при скролле
            window.addEventListener('scroll', () => {
                animateOnScroll(teamMembers);
                animateOnScroll(valueCards);
                animateOnScroll(timelineItems);
            });
        });
    </script>
</body>

</html>