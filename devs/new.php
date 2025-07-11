<?php
require_once('../swad/config.php');
require_once('../swad/controllers/user.php');
require_once('../swad/controllers/organization.php');

$db = new Database();
$curr_user = new User();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CrazyProjectsLab - Управление проектами</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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

    /* Сайдбар */
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
      scrollbar-width: none;
    }

    .sidebar::-webkit-scrollbar {
      display: none;
    }

    /* Основной контент */
    .main-content {
      flex: 1;
      margin-left: var(--sidebar-width);
      padding: 30px;
      transition: var(--transition);
      min-height: 100vh;
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

    /* Вкладки */
    .tabs-container {
      background: var(--card-bg);
      border-radius: var(--card-radius);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      margin-bottom: 30px;
      border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .tabs-header {
      display: flex;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .tab-btn {
      padding: 15px 25px;
      background: transparent;
      border: none;
      color: var(--gray);
      font-family: 'Montserrat', sans-serif;
      font-weight: 500;
      font-size: 1.1rem;
      cursor: pointer;
      transition: var(--transition);
      position: relative;
    }

    .tab-btn.active {
      color: white;
    }

    .tab-btn.active::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 3px;
      background: var(--accent);
    }

    .tab-btn:hover:not(.active) {
      background: rgba(255, 255, 255, 0.05);
    }

    .tab-content {
      display: none;
      padding: 25px;
    }

    .tab-content.active {
      display: block;
    }

    /* Формы */
    .form-section {
      margin-bottom: 25px;
    }

    .form-section h3 {
      font-family: 'Montserrat', sans-serif;
      font-weight: 600;
      margin-bottom: 15px;
      color: white;
      font-size: 1.3rem;
    }

    .form-row {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .form-group {
      flex: 1;
    }

    .form-label {
      display: block;
      margin-bottom: 8px;
      color: rgba(255, 255, 255, 0.8);
      font-weight: 500;
    }

    .form-input,
    .form-textarea,
    .form-select {
      width: 100%;
      padding: 12px 15px;
      border-radius: 8px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      background: rgba(0, 0, 0, 0.2);
      color: white;
      font-family: 'Roboto', sans-serif;
      font-size: 1rem;
      transition: var(--transition);
    }

    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
      outline: none;
      border-color: var(--accent);
      box-shadow: 0 0 0 2px rgba(255, 126, 95, 0.3);
    }

    .form-textarea {
      min-height: 120px;
      resize: vertical;
    }

    .hint {
      margin-top: 5px;
      font-size: 0.85rem;
      color: var(--gray);
    }

    .checkbox-group {
      margin-top: 10px;
    }

    .checkbox-item {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .checkbox-item input {
      margin-right: 10px;
    }

    .file-upload {
      position: relative;
      margin-top: 10px;
    }

    .file-btn {
      display: inline-block;
      padding: 10px 15px;
      background: rgba(106, 17, 203, 0.3);
      border-radius: 8px;
      color: white;
      cursor: pointer;
      transition: var(--transition);
    }

    .file-btn:hover {
      background: rgba(106, 17, 203, 0.5);
    }

    .file-input {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
    }

    .preview-container {
      margin-top: 15px;
      max-width: 300px;
      border: 1px dashed rgba(255, 255, 255, 0.1);
      padding: 10px;
      border-radius: 8px;
    }

    .cover-preview {
      max-width: 100%;
      max-height: 200px;
      display: none;
      border-radius: 4px;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Индекс качества */
    .gqi-container {
      background: var(--card-bg);
      border-radius: var(--card-radius);
      padding: 20px;
      margin-top: 30px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .gqi-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    .gqi-title {
      font-family: 'Montserrat', sans-serif;
      font-weight: 600;
      font-size: 1.1rem;
      color: white;
    }

    .gqi-value {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
      font-size: 1.3rem;
      color: var(--accent);
    }

    .progress {
      height: 12px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 6px;
      overflow: hidden;
    }

    .progress-bar {
      height: 100%;
      background: var(--accent);
      border-radius: 6px;
      transition: width 0.5s ease;
    }

    /* Список проектов */
    .projects-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 25px;
      margin-top: 20px;
    }

    .project-card {
      background: var(--card-bg);
      border-radius: var(--card-radius);
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.05);
      transition: var(--transition);
    }

    .project-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
    }

    .project-cover {
      height: 180px;
      background: linear-gradient(45deg, var(--primary), var(--secondary));
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 3rem;
    }

    .project-content {
      padding: 20px;
    }

    .project-title {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
      font-size: 1.3rem;
      margin-bottom: 10px;
      color: white;
    }

    .project-meta {
      display: flex;
      justify-content: space-between;
      color: var(--gray);
      font-size: 0.9rem;
      margin-bottom: 15px;
    }

    .project-status {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
    }

    .status-draft {
      background: rgba(255, 193, 7, 0.2);
      color: #ffc107;
    }

    .status-published {
      background: rgba(40, 167, 69, 0.2);
      color: #28a745;
    }

    .project-actions {
      display: flex;
      gap: 10px;
      margin-top: 15px;
    }

    .btn-sm {
      padding: 8px 15px;
      font-size: 0.9rem;
    }

    /* Адаптивность */
    @media (max-width: 992px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.active {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
        width: 100%;
      }

      .menu-toggle {
        display: block;
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

      .form-row {
        flex-direction: column;
        gap: 15px;
      }

      .projects-grid {
        grid-template-columns: 1fr;
      }
    }

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
      .menu-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
      }
    }
  </style>
</head>

<body>
  <!-- Сайдбар -->
  <?php require_once('../swad/static/elements/aside.php'); ?>

  <!-- Основное содержимое -->
  <main class="main-content">
    <button class="menu-toggle">
      <span class="material-icons">menu</span>
    </button>

    <!-- Хедер -->
    <header class="header">
      <div class="welcome">
        <div class="user-avatar">C</div>
        <div class="welcome-text">
          <h1>Управление проектами</h1>
          <p>Создавайте и редактируйте ваши игровые проекты</p>
        </div>
      </div>

      <div class="header-actions">
        <button class="btn btn-outline">
          <span class="material-icons">notifications</span>
          Уведомления
        </button>
        <button class="btn btn-primary">
          <span class="material-icons">help</span>
          Помощь
        </button>
      </div>
    </header>

    <!-- Вкладки -->
    <div class="tabs-container">
      <div class="tabs-header">
        <button class="tab-btn active" data-tab="create">Создать проект</button>
        <button class="tab-btn" data-tab="edit">Редактировать проект</button>
        <button class="tab-btn" data-tab="all">Все проекты</button>
      </div>

      <!-- Вкладка создания проекта -->
      <div class="tab-content active" id="create-tab">
        <div class="form-section">
          <h3>Общая информация</h3>
          <p>Создайте черновик проекта для вашей новой игры. После создания вы сможете добавлять файлы, настраивать публикацию и управлять проектом.</p>
        </div>

        <form id="game-project" method="POST" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="project-name">Название проекта</label>
              <input type="text" class="form-input" name="project-name" placeholder="Введите название" required maxlength="64" />
              <div class="hint">Максимум 64 символа, только английские и русские буквы и знаки "!", "_", "-"</div>
            </div>

            <div class="form-group">
              <label class="form-label" for="genre">Жанр</label>
              <select class="form-select" name="genre" required>
                <option value="" disabled selected>Выберите жанр</option>
                <option value="action">Экшен</option>
                <option value="rpg">RPG</option>
                <option value="strategy">Стратегия</option>
                <option value="adventure">Приключение</option>
                <option value="simulator">Симулятор</option>
                <option value="visnovel">Визуальная новелла</option>
                <option value="indie">Инди</option>
                <option value="other">Другое</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="description">Описание проекта</label>
            <textarea class="form-textarea" name="description" placeholder="Введите описание (50-2000 символов)" minlength="50" maxlength="2000" required></textarea>
            <div class="hint">Опишите вашу игру: сюжет, геймплей, особенности</div>
          </div>

          <div class="form-group">
            <label class="form-label">Платформы</label>
            <div class="checkbox-group">
              <div class="checkbox-item">
                <input type="checkbox" id="pc_windows" name="platform[]" value="windows" />
                <label for="pc_windows">Windows</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="pc_linux" name="platform[]" value="linux" />
                <label for="pc_linux">Linux</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="pc_macos" name="platform[]" value="macos" />
                <label for="pc_macos">MacOS</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="android" name="platform[]" value="android" />
                <label for="android">Android</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="web" name="platform[]" value="web" />
                <label for="web">Web</label>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="release-date">Дата выхода</label>
              <input type="date" class="form-input" name="release-date" placeholder="Выберите дату выхода игры" required />
            </div>

            <div class="form-group">
              <label class="form-label" for="website">Вебсайт игры</label>
              <input type="url" class="form-input" name="website" placeholder="https://example.com" required />
              <div class="hint">Это может быть страница в ВК, канал в Telegram или официальный сайт</div>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="cover-art">Обложка игры</label>
            <div class="file-upload">
              <div class="file-btn">
                <span class="material-icons">file_upload</span> Выбрать файл
              </div>
              <input type="file" class="file-input" name="cover-art" accept="image/*" id="cover-input" />
            </div>
            <div class="preview-container">
              <img src="" alt="Предпросмотр обложки" class="cover-preview" id="cover-preview">
              <p class="hint">Предпросмотр появится здесь</p>
            </div>
            <div class="hint">Рекомендуемый размер: 1200×630px, формат JPG/PNG</div>
          </div>

          <div class="form-actions">
            <button class="btn btn-outline" type="button">
              <span class="material-icons">cancel</span> Отмена
            </button>
            <button class="btn btn-primary" type="submit">
              <span class="material-icons">create</span> Создать черновик
            </button>
          </div>
        </form>

        <div class="gqi-container">
          <div class="gqi-header">
            <div class="gqi-title">Индекс качества проекта</div>
            <div class="gqi-value" id="gqi-value">0%</div>
          </div>
          <div class="progress">
            <div class="progress-bar" id="gqi-progress" style="width: 0%"></div>
          </div>
        </div>
      </div>

      <!-- Вкладка редактирования проекта -->
      <div class="tab-content" id="edit-tab">
        <div class="form-section">
          <h3>Редактирование проекта</h3>
          <p>Выберите проект для редактирования или внесите изменения в существующие данные.</p>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="select-project">Выберите проект</label>
            <select class="form-select" id="select-project">
              <option value="" disabled selected>Выберите проект для редактирования</option>
              <option value="1">Space Adventure</option>
              <option value="2">Cyberpunk Runner</option>
              <option value="3">Fantasy Kingdom</option>
            </select>
          </div>
        </div>

        <form id="edit-project-form" style="display: none;">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="edit-project-name">Название проекта</label>
              <input type="text" class="form-input" name="edit-project-name" value="Space Adventure" />
            </div>

            <div class="form-group">
              <label class="form-label" for="edit-genre">Жанр</label>
              <select class="form-select" name="edit-genre">
                <option value="action" selected>Экшен</option>
                <option value="rpg">RPG</option>
                <option value="strategy">Стратегия</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="edit-description">Описание проекта</label>
            <textarea class="form-textarea" name="edit-description">Исследуйте галактику в захватывающем космическом приключении. Сражайтесь с инопланетными пиратами, торгуйте на далеких станциях и открывайте новые планеты.</textarea>
          </div>

          <div class="form-group">
            <label class="form-label">Платформы</label>
            <div class="checkbox-group">
              <div class="checkbox-item">
                <input type="checkbox" id="edit-pc_windows" name="edit-platform[]" value="windows" checked />
                <label for="edit-pc_windows">Windows</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="edit-pc_linux" name="edit-platform[]" value="linux" />
                <label for="edit-pc_linux">Linux</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="edit-pc_macos" name="edit-platform[]" value="macos" checked />
                <label for="edit-pc_macos">MacOS</label>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="edit-release-date">Дата выхода</label>
              <input type="date" class="form-input" name="edit-release-date" value="2025-10-15" />
            </div>

            <div class="form-group">
              <label class="form-label" for="edit-website">Вебсайт игры</label>
              <input type="url" class="form-input" name="edit-website" value="https://spaceadventure.example.com" />
            </div>
          </div>

          <div class="form-actions">
            <button class="btn btn-outline" type="button">
              <span class="material-icons">delete</span> Удалить проект
            </button>
            <button class="btn btn-primary" type="submit">
              <span class="material-icons">save</span> Сохранить изменения
            </button>
          </div>
        </form>
      </div>

      <!-- Вкладка всех проектов -->
      <div class="tab-content" id="all-tab">
        <div class="form-section">
          <h3>Все проекты</h3>
          <p>Управляйте всеми проектами вашей студии. Создавайте новые, редактируйте существующие или удаляйте ненужные.</p>
        </div>

        <div class="projects-grid">
          <!-- Проект 1 -->
          <div class="project-card">
            <div class="project-cover">
              <span class="material-icons">rocket_launch</span>
            </div>
            <div class="project-content">
              <div class="project-title">Space Adventure</div>
              <div class="project-meta">
                <div>Экшен</div>
                <div>15.10.2025</div>
              </div>
              <div class="project-status status-published">Опубликован</div>
              <p class="hint">Исследуйте галактику в захватывающем космическом приключении</p>
              <div class="project-actions">
                <button class="btn btn-sm btn-outline">
                  <span class="material-icons">edit</span> Редактировать
                </button>
                <button class="btn btn-sm btn-primary">
                  <span class="material-icons">visibility</span> Просмотр
                </button>
              </div>
            </div>
          </div>

          <!-- Проект 2 -->
          <div class="project-card">
            <div class="project-cover">
              <span class="material-icons">directions_run</span>
            </div>
            <div class="project-content">
              <div class="project-title">Cyberpunk Runner</div>
              <div class="project-meta">
                <div>Экшен</div>
                <div>01.12.2025</div>
              </div>
              <div class="project-status status-draft">Черновик</div>
              <p class="hint">Бегите по неоновым улицам киберпанк-города будущего</p>
              <div class="project-actions">
                <button class="btn btn-sm btn-outline">
                  <span class="material-icons">edit</span> Редактировать
                </button>
                <button class="btn btn-sm btn-primary">
                  <span class="material-icons">visibility</span> Просмотр
                </button>
              </div>
            </div>
          </div>

          <!-- Проект 3 -->
          <div class="project-card">
            <div class="project-cover">
              <span class="material-icons">castle</span>
            </div>
            <div class="project-content">
              <div class="project-title">Fantasy Kingdom</div>
              <div class="project-meta">
                <div>RPG</div>
                <div>20.03.2026</div>
              </div>
              <div class="project-status status-draft">Черновик</div>
              <p class="hint">Стройте королевство, сражайтесь с драконами и управляйте подданными</p>
              <div class="project-actions">
                <button class="btn btn-sm btn-outline">
                  <span class="material-icons">edit</span> Редактировать
                </button>
                <button class="btn btn-sm btn-primary">
                  <span class="material-icons">visibility</span> Просмотр
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    // Переключение вкладок
    document.querySelectorAll('.tab-btn').forEach(button => {
      button.addEventListener('click', () => {
        // Удаляем активный класс со всех кнопок и контента
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        // Добавляем активный класс текущей кнопке
        button.classList.add('active');

        // Показываем соответствующий контент
        const tabId = button.getAttribute('data-tab');
        document.getElementById(`${tabId}-tab`).classList.add('active');
      });
    });

    // Показать форму редактирования при выборе проекта
    document.getElementById('select-project').addEventListener('change', function() {
      if (this.value) {
        document.getElementById('edit-project-form').style.display = 'block';
      } else {
        document.getElementById('edit-project-form').style.display = 'none';
      }
    });

    // Предпросмотр обложки
    document.getElementById('cover-input').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
          const preview = document.getElementById('cover-preview');
          preview.src = event.target.result;
          preview.style.display = 'block';
          preview.nextElementSibling.style.display = 'none';
        };
        reader.readAsDataURL(file);
      }
      updateGQI();
    });

    // Расчет индекса качества
    const fieldWeights = {
      'project-name': 20,
      'genre': 15,
      'description': 10,
      'platform[]': 15,
      'release-date': 10,
      'cover-art': 15,
      'website': 15
    };

    function updateGQI() {
      let newGQI = 0;

      Object.keys(fieldWeights).forEach(fieldId => {
        const field = document.querySelector(`[name="${fieldId}"]`);
        if (!field) return;

        let isFilled = false;

        switch (field.type) {
          case 'checkbox':
            isFilled = document.querySelectorAll(`[name="${fieldId}"]:checked`).length > 0;
            break;
          case 'file':
            isFilled = !!field.files.length;
            break;
          case 'select-one':
            isFilled = field.value !== '';
            break;
          default:
            isFilled = field.value ? field.value.trim() !== '' : false;
        }

        if (isFilled) newGQI += fieldWeights[fieldId];
      });

      // Обновление интерфейса
      const totalGQI = Math.min(newGQI, 100);
      document.getElementById('gqi-value').textContent = `${totalGQI}%`;
      document.getElementById('gqi-progress').style.width = `${totalGQI}%`;

      const progressBar = document.getElementById('gqi-progress');
      progressBar.style.backgroundColor =
        totalGQI >= 80 ? '#4CAF50' :
        totalGQI >= 50 ? '#FFC107' :
        '#F44336';
    }

    // Инициализация слушателей
    document.querySelectorAll('#game-project input, #game-project select, #game-project textarea').forEach(element => {
      if (element) {
        element.addEventListener('input', updateGQI);
        element.addEventListener('change', updateGQI);
      }
    });

    // Запуск расчета при загрузке
    setTimeout(updateGQI, 100);
  </script>
</body>

</html>