<?php
session_start();
require_once('../constants.php');
require_once(ROOT_DIR . '/swad/config.php');
require_once(ROOT_DIR . '/swad/controllers/user.php');

$curr_user = new User();
$db = new Database();

if ($curr_user->checkAuth() > 0) {
    echo ("<script>window.location.replace('../login');</script>");
} else {
    $curr_user_data = $_SESSION['USERDATA'];
}

$curr_user_org = $curr_user->getOrgInfo($_SESSION['studio_id']);
// print_r($curr_user_org['status']);
if (empty($_SESSION['studio_id'])) {
    header('Location: select');
    exit();
}

if ($curr_user_org['status'] != 'active') {
    header('Location: select');
    exit();
}
?>

<?php require_once('../swad/controllers/ymcounter.php'); ?>

<head>
    <style>
        :root {
            --primary: #6a11cb;
            --primary-dark: #4a0cb0;
            --secondary: #2575fc;
            --accent: #ff7e5f;
            --light: #f8f9fa;
            --dark: #1a1c23;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --card-bg: #252836;
            --sidebar-bg: #1f1d2b;
            --header-bg: #252836;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
            --header-height: 70px;
            --card-radius: 16px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #1a1c23 0%, #1f1d2b 100%);
            color: var(--light);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Сайдбар - без вертикального скроллбара */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            height: 100vh;
            position: fixed;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 100;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            /* Скрываем вертикальный скроллбар */
            scrollbar-width: none;
            /* Firefox */
        }

        .sidebar::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar.collapsed .nav-title,
        .sidebar.collapsed .nav-link span:not(.material-icons),
        .sidebar.collapsed .studio-name span,
        .sidebar.collapsed .toggle-sidebar span {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 15px 0;
        }

        .sidebar.collapsed .studio-name {
            padding: 20px 0;
            justify-content: center;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .studio-name {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            transition: var(--transition);
        }

        .studio-name .material-icons {
            color: var(--accent);
            font-size: 2rem;
        }

        .toggle-sidebar {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 8px;
            color: white;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .toggle-sidebar:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(180deg);
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 25px;
        }

        .nav-title {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 0 20px 10px;
            color: rgba(255, 255, 255, 0.6);
            transition: var(--transition);
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
            border-left: 3px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-left: 3px solid var(--accent);
        }

        .nav-link .material-icons {
            margin-right: 15px;
            font-size: 1.4rem;
            min-width: 24px;
        }

        /* Основной контент */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 30px;
            transition: var(--transition);
            min-height: 100vh;
        }

        .sidebar.collapsed~.main-content {
            margin-left: var(--sidebar-collapsed);
        }

        /* Хедер */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .welcome {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .welcome-text h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .welcome-text p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .header-actions {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Roboto', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--light);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Статистика */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--card-radius);
            padding: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
            border-color: rgba(106, 17, 203, 0.3);
        }

        .stat-title {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }

        .stat-title .material-icons {
            color: var(--accent);
        }

        .stat-value {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 10px;
            color: white;
        }

        .stat-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .stat-link {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
        }

        .stat-link:hover {
            color: #ff9e8a;
        }

        .stat-link .material-icons {
            font-size: 1.1rem;
        }

        /* Таблица сотрудников */
        .content-section {
            background: var(--card-bg);
            border-radius: var(--card-radius);
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            margin-bottom: 40px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
        }

        .employees-table {
            width: 100%;
            border-collapse: collapse;
        }

        .employees-table th {
            text-align: left;
            padding: 15px 10px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            color: var(--gray);
            font-weight: 500;
        }

        .employees-table td {
            padding: 15px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.9);
        }

        .employees-table tr:last-child td {
            border-bottom: none;
        }

        .employees-table tr:hover td {
            background-color: rgba(106, 17, 203, 0.1);
        }

        .status-icon {
            color: var(--success);
            font-weight: bold;
            font-size: 1.2rem;
        }

        .offline {
            color: var(--danger);
        }

        /* Быстрые ссылки */
        .quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .link-card {
            background: var(--card-bg);
            border-radius: var(--card-radius);
            padding: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .link-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 126, 95, 0.3);
        }

        .link-card h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
            color: white;
        }

        .link-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .link-item:last-child {
            border-bottom: none;
        }

        .link-item .material-icons {
            background: rgba(106, 17, 203, 0.2);
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--accent);
            font-size: 1.4rem;
        }

        .link-text {
            flex: 1;
        }

        .link-text strong {
            display: block;
            margin-bottom: 3px;
            color: white;
        }

        .link-text span {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Футер */
        .footer {
            text-align: center;
            padding: 25px;
            color: var(--gray);
            font-size: 0.9rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            margin-top: 20px;
        }

        /* Адаптивность и кнопка menu-toggle */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            background: var(--primary);
            border: none;
            border-radius: 8px;
            width: 45px;
            height: 45px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
            z-index: 99;
            cursor: pointer;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }

            .sidebar.collapsed.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Переопределение стилей для активного состояния */
            .sidebar.active .studio-name span,
            .sidebar.active .toggle-sidebar span,
            .sidebar.active .nav-title,
            .sidebar.active .nav-link span:not(.material-icons) {
                display: inline-block;
            }

            .sidebar.active .nav-link {
                justify-content: flex-start;
            }

            .sidebar.active .studio-name {
                justify-content: space-between;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .header-actions {
                width: 100%;
                justify-content: space-between;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-links {
                grid-template-columns: 1fr;
            }
        }

        /* Анимации */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card,
        .content-section,
        .link-card {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .stat-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .content-section {
            animation-delay: 0.6s;
        }

        .link-card:nth-child(1) {
            animation-delay: 0.7s;
        }

        .link-card:nth-child(2) {
            animation-delay: 0.8s;
        }

        /* Кнопка скрытия/показа */
        .collapse-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            z-index: 101;
            transition: var(--transition);
        }

        .collapse-btn:hover {
            transform: scale(1.1);
            background: #ff9e8a;
        }

        .sidebar.collapsed~.collapse-btn {
            left: 25px;
        }
    </style>
</head>
<button class="collapse-btn" id="collapseBtn">
    <span class="material-icons" id="collapseIcon">menu</span>
</button>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="studio-name">
            <span class="material-icons">developer_mode</span>
            <span><?= $curr_user_org['name'] . '12' ?></span>
        </div>
        <button class="toggle-sidebar" id="toggleSidebar">
            <span class="material-icons">chevron_left</span>
        </button>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-title">Панель управления</div>
            <a href="#" class="nav-link active">
                <span class="material-icons">dashboard</span>
                Панель управления
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">groups</span>
                Сотрудники
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">work</span>
                Проекты
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">note_add</span>
                Отзывы
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-title">Проекты</div>
            <a href="#" class="nav-link">
                <span class="material-icons">add</span>
                Создать новый
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">group</span>
                Исполнители
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">list_alt</span>
                Задачи
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">reviews</span>
                Отзывы
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">stars</span>
                Рейтинг игры
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">currency_ruble</span>
                Монетизация
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-title">Для администраторов</div>
            <a href="#" class="nav-link">
                <span class="material-icons">shield</span>
                Администрирование
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">person_search</span>
                Поиск пользователя
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">how_to_reg</span>
                Новые пользователи
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">domain_add</span>
                Новые организации
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">report</span>
                Репорты
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-title">Объявления</div>
            <a href="#" class="nav-link">
                <span class="material-icons">add_alert</span>
                Создать новое
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">notifications</span>
                Все
            </a>
        </div>
    </nav>
</aside>
<script>
    // Управление боковой панелью
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const collapseBtn = document.getElementById('collapseBtn');
    const collapseIcon = document.getElementById('collapseIcon');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');

    // Переключение состояния сайдбара
    function toggleSidebar() {
        sidebar.classList.toggle('collapsed');

        // Обновление иконок
        const isCollapsed = sidebar.classList.contains('collapsed');
        toggleBtn.querySelector('.material-icons').textContent = isCollapsed ? 'chevron_right' : 'chevron_left';
        collapseIcon.textContent = isCollapsed ? 'menu_open' : 'menu';

        // Сохранение состояния
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    }

    // Обработчики событий для кнопок
    toggleBtn.addEventListener('click', toggleSidebar);
    collapseBtn.addEventListener('click', toggleSidebar);
    mobileMenuToggle.addEventListener('click', function() {
        sidebar.classList.toggle('active');
    });

    // Восстановление состояния при загрузке
    document.addEventListener('DOMContentLoaded', function() {
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            toggleBtn.querySelector('.material-icons').textContent = 'chevron_right';
            collapseIcon.textContent = 'menu_open';
        }
    });

    // Закрытие сайдбара при клике вне его на мобильных
    document.addEventListener('click', function(event) {
        const isMobile = window.innerWidth <= 992;
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnMobileToggle = event.target === mobileMenuToggle || mobileMenuToggle.contains(event.target);
        const isClickOnCollapseBtn = event.target === collapseBtn || collapseBtn.contains(event.target);

        if (isMobile &&
            !isClickInsideSidebar &&
            !isClickOnMobileToggle &&
            !isClickOnCollapseBtn &&
            sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });
</script>