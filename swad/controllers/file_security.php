<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
/*************************************************
 * CONFIG
 *************************************************/
define('VT_API_KEY', '1fb8a5bdc1938aaad1c56b216722e2b9b915bb6f62494fbcf538071dbaaf2ad4');
define('UPLOAD_DIR', __DIR__ . '/../../uploads/');
define('HASH_DB', UPLOAD_DIR . 'hashes.json');

/* ================= UPLOAD ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    try {
        if (!isset($_FILES['archive'])) {
            throw new Exception('Файл не получен');
        }

        if (!is_dir(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0777, true);
        }

        $f = $_FILES['archive'];

        if ($f['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Ошибка загрузки: ' . $f['error']);
        }

        if (strtolower(pathinfo($f['name'], PATHINFO_EXTENSION)) !== 'zip') {
            throw new Exception('Разрешены только ZIP архивы');
        }

        $tmpPath = UPLOAD_DIR . uniqid('tmp_', true) . '.zip';

        if (!move_uploaded_file($f['tmp_name'], $tmpPath)) {
            throw new Exception('Не удалось сохранить файл');
        }

        /* ===== SIGNATURE ===== */
        $hash = hash_file('sha256', $tmpPath);
        $db = file_exists(HASH_DB)
            ? json_decode(file_get_contents(HASH_DB), true)
            : [];

        if (isset($db[$hash])) {
            unlink($tmpPath);
            throw new Exception('Этот архив уже был загружен ранее');
        }

        $finalName = $hash . '.zip';
        rename($tmpPath, UPLOAD_DIR . $finalName);

        $db[$hash] = [
            'file' => $finalName,
            'time' => time()
        ];
        file_put_contents(HASH_DB, json_encode($db, JSON_PRETTY_PRINT));

        /* ===== VT (опционально, можно отключить) ===== */
        // $stats = virusTotalScan(UPLOAD_DIR . $finalName);

        echo json_encode([
            'status' => 'ok',
            'hash'   => $hash,
            // 'stats'  => $stats
        ]);
        exit;
    } catch (Throwable $e) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
        exit;
    }
}
?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>Upload</title>

    <style>
        body {
            background: #0e1116;
            color: #e6e6e6;
            font-family: Inter, system-ui, sans-serif;
        }

        .widget {
            width: 460px;
            background: #151a21;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .4);
        }

        .title {
            font-size: 18px;
            margin-bottom: 14px;
        }

        input[type=file] {
            width: 100%;
            padding: 10px;
            background: #0e1116;
            color: #aaa;
            border: 1px dashed #2a2f3a;
            border-radius: 10px;
        }

        button {
            width: 100%;
            margin-top: 12px;
            padding: 12px;
            background: #2563eb;
            border: none;
            border-radius: 10px;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .progress-wrap {
            margin-top: 16px;
            display: none;
        }

        .progress-bar {
            height: 8px;
            background: #0e1116;
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #2563eb, #60a5fa);
            transition: width .15s linear;
        }

        .stats {
            font-size: 13px;
            margin-top: 10px;
            line-height: 1.6;
            color: #cbd5f5;
        }

        .error {
            color: #f87171
        }

        .success {
            color: #4ade80
        }
    </style>
</head>

<body>

    <div class="widget">
        <div class="title">Загрузка ZIP архива</div>

        <form id="form">
            <input type="file" name="archive" accept=".zip" required>
            <button>Загрузить</button>
        </form>

        <div class="progress-wrap">
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
            <div class="stats"></div>
        </div>
    </div>

    <script>
        const form = document.getElementById('form');
        const wrap = document.querySelector('.progress-wrap');
        const fill = document.querySelector('.progress-fill');
        const stats = document.querySelector('.stats');

        let startTime = 0;

        const bytes = b => {
            const u = ['B', 'KB', 'MB', 'GB'];
            let i = 0;
            while (b >= 1024 && i < u.length - 1) {
                b /= 1024;
                i++;
            }
            return b.toFixed(2) + ' ' + u[i];
        };

        const time = s => {
            if (!isFinite(s)) return '—';
            const m = Math.floor(s / 60);
            const r = Math.floor(s % 60);
            return m ? `${m}м ${r}с` : `${r}с`;
        };

        form.onsubmit = e => {
            e.preventDefault();

            const xhr = new XMLHttpRequest();
            const data = new FormData(form);

            wrap.style.display = 'block';
            fill.style.width = '0%';
            stats.textContent = '';
            startTime = Date.now();

            xhr.upload.onprogress = e => {
                if (!e.lengthComputable) return;

                const percent = e.loaded / e.total * 100;
                const elapsed = (Date.now() - startTime) / 1000;
                const speed = e.loaded / elapsed;
                const eta = (e.total - e.loaded) / speed;

                fill.style.width = percent + '%';

                stats.innerHTML = `
            ${percent.toFixed(1)}%<br>
            ${bytes(e.loaded)} из ${bytes(e.total)}<br>
            ${bytes(speed)}/с<br>
            осталось ~ ${time(eta)}
        `;
            };

            xhr.onload = () => {
                try {
                    const res = JSON.parse(xhr.responseText);
                    if (res.status === 'ok') {
                        stats.innerHTML += `<br><span class="success">✔ Загружено</span><br>SHA-256: ${res.hash}`;
                    } else {
                        stats.innerHTML = `<span class="error">${res.message}</span>`;
                    }
                } catch {
                    stats.innerHTML = `<span class="error">Ошибка ответа сервера</span>`;
                }
            };

            xhr.onerror = () => {
                stats.innerHTML = `<span class="error">Ошибка сети</span>`;
            };

            xhr.open('POST', location.href);
            xhr.send(data);
        };
    </script>

</body>

</html>