<?php
require_once('../swad/controllers/payment.php');
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dustore.Finance</title>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --light: #ecf0f1;
            --dark: #1a2530;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        header {
            background-color: var(--primary);
            color: white;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .lightblue {
            color: var(--secondary);
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 1.5rem;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 500;
        }

        nav ul li a:hover {
            color: var(--secondary);
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--dark);
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .product-image {
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .product-description {
            color: #666;
            margin-bottom: 1rem;
            min-height: 80px;
        }

        .product-price {
            font-size: 1.6rem;
            font-weight: 700;
            color: #27ae60;
            margin-bottom: 1rem;
        }

        .btn-buy {
            display: inline-block;
            width: 100%;
            padding: 12px;
            background-color: var(--secondary);
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-buy:hover {
            background-color: #2980b9;
        }

        footer {
            background-color: var(--dark);
            color: white;
            padding: 3rem 5% 2rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-section h3 {
            margin-bottom: 1.2rem;
            font-size: 1.3rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--secondary);
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.8rem;
        }

        .footer-section ul li a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: var(--secondary);
        }

        .contact-info {
            color: #bbb;
        }

        .contact-info div {
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
        }

        .contact-info i {
            margin-right: 10px;
            color: var(--secondary);
        }

        .legal-info {
            margin-top: 2rem;
            text-align: center;
            color: #777;
            font-size: 0.9rem;
            padding-top: 1.5rem;
            border-top: 1px solid #34495e;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
            }

            nav ul {
                margin-top: 1rem;
                justify-content: center;
            }

            nav ul li {
                margin: 0 0.75rem;
            }
        }
    </style>
    <link rel="shortcut icon" href="../swad/static/img/DF.svg" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<body>
    <header>
        <div class="logo">DUSTORE<span class="lightblue">.FINANCE</span> | <span style="font-size: .9rem;">Текущий оборот средств платформы: <span class="lightblue">0₽</span></span></div>
        <nav>
            <ul>
                <li><a href="/">На главную</a></li>
                <li><a href="mailto:support@dustore.ru">Написать письмо</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1 class="page-title">Что вы можете приобрести:</h1>

        <div class="products">
            <div class="product-card">
                <div class="product-image" style="background: url('d_vault.png'); background-size: cover;"></div>
                <div class="product-info">
                    <h2 class="product-title">Подписка для игроков</h2>
                    <p class="product-description">
                        - Доступ к играм в Подписке,<br>
                        - Бесплатная тех.поддержка,<br>
                        - Участие в ежемесячных мероприятиях Dust Hunt*

                        <br>
                        <br>
                        <i>*Dust Hunt - ежемесячное соревнование в одной из игр, которое устраивает Платформа. Поднимись выше всех по рейтингу и получи приз от Dustore!</i>
                    </p>Вы можете пополненить свой баланс на любую сумму от 50₽
                    <br><u>50% с ваших пополнений идёт в Фонд Платформы. Эти деньги идут на поддержку разработчиков.</u>
                    <div class="product-price">От 50₽</div>
                    <div style="display: flex; align-items: center; gap: 10px; margin: 10px 0;">
                        <input type="number" name="amount" id="amountInput" min="50" step="1" placeholder="Введите сумму" required
                            style="padding: 8px; flex: 1; border: 1px solid #ccc; border-radius: 4px;">
                        <button type="button" class="btn-buy" style="white-space: nowrap;" onclick="generatePayment()"><span>Создать кнопку</span></button>
                    </div>
                    <div id="paymentButtonContainer"></div>

                    <script>
                        function generatePayment() {
                            const amountInput = document.getElementById('amountInput');
                            const amount = parseInt(amountInput.value);

                            if (!amount || amount < 50) {
                                alert('Минимальная сумма - 50₽');
                                amountInput.value = 50;
                                amountInput.focus();
                                return;
                            }

                            // Отправляем запрос на сервер
                            fetch('core/generate-payment.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: 'amount=' + amount
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Ошибка сервера');
                                    }
                                    return response.text();
                                })
                                .then(html => {
                                    document.getElementById('paymentButtonContainer').innerHTML = html;
                                })
                                .catch(error => {
                                    console.error('Ошибка:', error);
                                    alert('Произошла ошибка при создании платежа');
                                });
                        }
                    </script>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image" style="background: url('d_priority.png'); background-size: cover;"></div>
                <div class="product-info">
                    <h2 class="product-title">Подписка для игроков (ПРЕМИУМ 👑)</h2>
                    <p class="product-description">
                        - Эксклюзивный доступ к закрытому игровому контенту,<br>
                        - Дополнительный контент от разработчиков (DLC, OST),<br>
                        - Ежемесячные бонусы в виде внутренней валюты и скидки,<br>
                        - При желании вы можете заказать физическую карту игрока Dustore*<br>
                    </p>
                    *Карта участника оплачивается один раз (входит в подписку).
                    <br>
                    <u>50% с вашей подписки идёт в Фонд Платформы. Эти деньги идут на поддержку разработчиков.</u>
                    <div class="product-price">399 ₽/месяц</div>
                    <?php
                    renderPaymentButton("dustore", "U9D47ayD4y0luzFDgdrf", rand(2 ** 1, 2 * 36), "Подписка для игроков Dust Priority", [["Подписка для игроков Dust Priority с преимуществами на 1 месяц", 399]], "", 0.00, 1, "My_param=julia", "Купить подписку");
                    ?>
                </div>
            </div>

            <!-- Товар 2: Консоль разработчика -->
            <div class="product-card">
                <div class="product-image" style="background: url('d_pass.png'); background-size: cover;"></div>
                <div class="product-info">
                    <h2 class="product-title">Консоль разработчика</h2>
                    <p class="product-description">
                        - Полный доступ к инструментам разработки,<br>
                        - API для разработчиков,<br>
                        - Документация,<br>
                        - Система управления студией и персоналом,<br>
                        - Безлимитное файловое хранилище для ваших проектов,<br>
                        - Персональный бот-менеджер.
                        <br>
                    </p><u>50% с вашей подписки идёт в Фонд Платформы. Фонд устраивает розыгрыши, спонсирует лучшие проекты, развивает Платформу, а также занимается рекламой ваших проектов.</u>
                    <div class="product-price">600 ₽/месяц</div>
                    <?php
                    renderPaymentButton("dustore", "U9D47ayD4y0luzFDgdrf", rand(2 ** 1, 2 * 36), "Подписка для разработчиков Dust Pass", [["Подписка для разработчиков Dust Pass на 1 месяц", 600]], "", 0.00, 1, "My_param=julia", "Приобрести");
                    ?>
                </div>
            </div>
        </div>

        <h2>Помощь и возврат денежных средств</h2>
        <p>
            Если у вас возникли проблемы, свяжитесь с нами <a href="mailto:support@dustore.ru">по почте</a>, и мы ответим вам в течение одного дня.
            <br>
            ❗ На данный момент заявки на возврат средств от игроков не принимаются (По вопросам возврата средств за игру связывайтесь с разработчиком игры). <br>
            ❗ Заявки на возврат средст от разработчиков рассматриваются только если разработчик передумал регистрировать студию <u>на этапе модерации</u>.
        </p>

        <h2>Порядок предоставления услуг</h2>
        <p>Доступ к консоли разработчика предоставляется только после оплаты и может быть заблокирован по решению Администрации.</p>

        <h2>Отказ от услуги и возврат денежных средств</h2>
        <p>Доступ к консоли разработчика выдаётся только после подтверждения аккаунта разработчика модераторами платформы. Если разработчик после оплаты изменил своё решение, то он может написать соответсвующее письмо в техническую поддержку платформы.
            В этом случае Платформа возвращает денежную сумму (из неё вычитается комиссия) и аккаунт раазработчика больше не будет рассматриваться модератором (аккаунт удаляется). В иных случаях возврат средств не рассматривается.
        </p>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Контакты</h3>
                <div class="contact-info">
                    <div>
                        ✉️ support@dustore.ru
                    </div>
                    <div>
                        📱 Telegram: @dustore_official
                    </div>
                    <div>
                        🕒 Техподдержка: <br>
                        Пн-Пт: 10:00 - 22:00 <br>
                        Сб-Вс: 12:00 - 20:00
                    </div>
                </div>
            </div>

            <div class="footer-section">
                <h3>Информация</h3>
                <ul>
                    <!-- <li><a href="#">Доставка и возврат</a></li> -->
                    <li><a href="/oferta.txt">Публичная оферта</a></li>
                    <li><a href="/privacy">Обработка персональных данных</a></li>
                    <li><a href="/agreement">Пользовательское соглашение</a></li>
                    <!-- <li><a href="#">Юридическая информация</a></li> -->
                </ul>
            </div>

            <div class="footer-section">
                <h3>Юридическая информация</h3>
                <div class="contact-info">
                    <div>ИП Ливанов Александр Алексеевич</div>
                    <div>ИНН: 771392840109</div>
                    <div>ОГРН/ОГРНИП: 325774600520418</div>
                    <div>г. Москва</div>
                </div>
            </div>
        </div>

        <div class="legal-info">
            <img src="logo3h.png" alt="" style="scale: .8;">
            <br>
            &copy; 2025 Dust Studio. Все права защищены. <br>
            Dustore.Finance является частью экосистемы Dustore
        </div>
    </footer>
</body>

</html>