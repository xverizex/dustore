<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Dustore Postbox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Inter, system-ui;
            background: #efe9dc;
            color: #2a2a2a;
        }

        header {
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 32px;
            background: #d8cfbd;
            border-bottom: 2px solid #b8ad99;
            font-weight: 700;
        }

        main {
            display: flex;
            height: calc(100vh - 64px);
        }

        aside {
            width: 240px;
            background: #e2d8c4;
            border-right: 2px solid #b8ad99;
            padding: 20px;
        }

        aside a {
            display: block;
            padding: 12px 16px;
            margin-bottom: 8px;
            border-radius: 8px;
            color: #2a2a2a;
            text-decoration: none;
        }

        aside a.active,
        aside a:hover {
            background: #cbbfa9;
        }

        section {
            flex: 1;
            padding: 32px;
            overflow: auto;
        }

        .card {
            background: #fffaf0;
            border: 1px solid #c8bfae;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 16px;
            transition: transform .2s;
        }

        .letter {
            font-family: "Courier New", monospace;
            background: #fffdf8;
            border: 2px dashed #b8ad99;
            padding: 16px;
            cursor: pointer;
            transition: transform .2s;
        }

        .letter:hover {
            transform: scale(1.03);
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #b8ad99;
            background: #fff;
            margin-bottom: 12px;
        }

        button {
            background: #8b5e3c;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 8px;
        }

        .profile-header {
            display: flex;
            gap: 24px;
            margin-bottom: 16px;
        }

        .avatar {
            width: 96px;
            height: 96px;
            border-radius: 12px;
            background: #ccc;
        }

        .hidden {
            display: none;
        }

        .meta {
            font-size: 13px;
            color: #666;
            margin-top: 4px;
        }

        /* ===== FULLSCREEN MODAL ===== */
        #previewModal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .7);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        #previewModal .modal-card {
            background: #fffaf0;
            border: 2px dashed #b8ad99;
            padding: 32px;
            border-radius: 12px;
            width: 80%;
            max-width: 800px;
            position: relative;
        }

        #previewModal h2 {
            margin-bottom: 12px;
            font-family: "Courier New", monospace;
        }

        #previewModal .meta {
            margin-bottom: 16px;
        }

        #previewModal .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        #previewModal button {
            flex: 1;
        }

        #previewModal .close-btn {
            position: absolute;
            top: 16px;
            right: 16px;
            background: #8b5e3c;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <header>📮 Dustore Postbox</header>

    <main>
        <aside>
            <a href="#" class="active" onclick="show('feed',this)">Лента</a>
            <a href="#" onclick="show('my',this)">Мои заявки</a>
            <a href="#" onclick="show('create',this)">Создать заявку</a>
            <a href="#" onclick="show('fav',this)">Избранное</a>
            <a href="#" onclick="show('profile',this)">Профиль</a>
        </aside>

        <section>
            <!-- FEED -->
            <div id="feed">
                <h2>📬 Лента заявок</h2>
                <div id="feedList"></div>
            </div>

            <!-- MY REQUESTS -->
            <div id="my" class="hidden">
                <h2>📁 Мои заявки</h2>
                <div id="myStats" class="card"></div>
                <div id="myList"></div>
            </div>

            <!-- CREATE -->
            <div id="create" class="hidden">
                <h2>✉️ Новая заявка</h2>
                <input id="newTitle" placeholder="Кого вы ищете">
                <input id="newRole" placeholder="Формат участия">
                <select id="newStage">
                    <option>Стадия проекта</option>
                    <option>Идея</option>
                    <option>Прототип</option>
                    <option>Продакшн</option>
                </select>
                <textarea id="newDesc" placeholder="Описание проекта"></textarea>
                <textarea id="newDone" placeholder="Что уже сделано"></textarea>
                <textarea id="newWhy" placeholder="Зачем вам этот человек"></textarea>
                <button onclick="createRequest()">Опубликовать</button>
            </div>

            <!-- FAVORITES -->
            <div id="fav" class="hidden">
                <h2>⭐ Избранное</h2>
                <div id="favList"></div>
            </div>

            <!-- PROFILE -->
            <div id="profile" class="hidden">
                <h2>👤 Профиль</h2>
                <div class="profile-header">
                    <div class="avatar"></div>
                    <div>
                        <input id="profileNick" placeholder="@nickname">
                        <input id="profileRole" placeholder="Роль">
                        <input id="profileCity" placeholder="Город">
                    </div>
                </div>
                <textarea id="profileBio" placeholder="Био"></textarea>
                <textarea id="profileProjects" placeholder="Проекты"></textarea>
                <textarea id="profileContacts" placeholder="Ссылки / соцсети"></textarea>
                <button onclick="saveProfile()">Сохранить профиль</button>
            </div>
        </section>
    </main>

    <!-- PREVIEW MODAL -->
    <div id="previewModal">
        <div class="modal-card">
            <button class="close-btn" onclick="closePreview()">✖</button>
            <h2 id="modalTitle"></h2>
            <div class="meta" id="modalAuthor"></div>
            <div id="modalDesc" style="margin-top:12px;"></div>
            <div class="modal-actions">
                <button onclick="respondRequest()">Откликнуться</button>
                <button onclick="openPaper(modalCurrentId)">Печатная версия</button>
            </div>
        </div>
    </div>

    <script>
        const views = ['feed', 'my', 'create', 'fav', 'profile'];

        function show(id, el) {
            views.forEach(v => document.getElementById(v).classList.add('hidden'));
            document.getElementById(id).classList.remove('hidden');
            document.querySelectorAll('aside a').forEach(a => a.classList.remove('active'));
            if (el) el.classList.add('active');
        }

        // STUB DATA
        let requests = [{
                id: 1,
                title: "Ищу программиста для метроидвании",
                author: "@alex",
                type: "Идея",
                views: 124,
                comments: 7,
                fav: 3
            },
            {
                id: 2,
                title: "Нужен UI-дизайнер",
                author: "@alex",
                type: "Команда",
                views: 52,
                comments: 3,
                fav: 1
            }
        ];
        let favs = [requests[1]];

        let modalCurrentId = null;

        // RENDER
        function renderFeed() {
            const el = document.getElementById('feedList');
            el.innerHTML = '';
            requests.forEach(r => {
                const div = document.createElement('div');
                div.className = 'card letter';
                div.innerHTML = `<h3>${r.title}</h3><div class="meta">От ${r.author} · ${r.type}</div>`;
                div.onclick = () => openPreview(r.id);
                el.appendChild(div);
            });
        }

        function renderMy() {
            const stats = document.getElementById('myStats');
            stats.innerHTML = `👁️ ${requests.length*50} · 💬 ${requests.length*3} · ⭐ ${requests.length}`;
            const list = document.getElementById('myList');
            list.innerHTML = '';
            requests.forEach(r => {
                const div = document.createElement('div');
                div.className = 'card letter';
                div.innerHTML = `<h3>${r.title}</h3><div class="meta">Статус: активна</div>`;
                div.onclick = () => openPreview(r.id);
                list.appendChild(div);
            });
        }

        function renderFav() {
            const el = document.getElementById('favList');
            el.innerHTML = '';
            favs.forEach(r => {
                const div = document.createElement('div');
                div.className = 'card letter';
                div.innerHTML = `<h3>${r.title}</h3><div class="meta">От ${r.author}</div>`;
                div.onclick = () => openPreview(r.id);
                el.appendChild(div);
            });
        }

        // CREATE
        function createRequest() {
            const newR = {
                id: Date.now(),
                title: document.getElementById('newTitle').value,
                author: '@me',
                type: document.getElementById('newStage').value,
                views: 0,
                comments: 0,
                fav: 0
            };
            requests.push(newR);
            renderFeed();
            renderMy();
            renderFav();
            alert("Заявка создана!");
        }

        // PROFILE
        function saveProfile() {
            alert("Профиль сохранен!");
        }

        // FULLSCREEN PREVIEW
        function openPreview(id) {
            modalCurrentId = id;
            const r = requests.find(x => x.id === id);
            document.getElementById('modalTitle').textContent = r.title;
            document.getElementById('modalAuthor').textContent = `От ${r.author} · ${r.type}`;
            document.getElementById('modalDesc').textContent = "Описание: " + (r.desc || "Нет описания");
            document.getElementById('previewModal').style.display = 'flex';
        }

        function closePreview() {
            document.getElementById('previewModal').style.display = 'none';
        }

        // RESPOND
        function respondRequest() {
            alert("Отклик отправлен на заявку ID " + modalCurrentId);
        }

        // OPEN PAPER
        function openPaper(id) {
            window.open('request-paper.html?id=' + id, '_blank');
        }

        // INIT
        renderFeed();
        renderMy();
        renderFav();
    </script>
</body>

</html>