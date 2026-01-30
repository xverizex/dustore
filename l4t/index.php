<?php
session_start();

// bid structure:
// id, title, author_id, path_to_cover, person_seek, needed_exp, salary_condition

$bids_array = [
    [1, "Howl-Growl", 1, "/path_to_cover", "CGI художник", 1, "non-free"],
    [2, "Pigeon of Sorrow", 2, "/path_to_cover", "Unity программист", 1, "non-free"],
    [3, "Solder Simulator", 3, "/path_to_cover", "Физик-ядерщик", 1, "non-free"],
    [4, "Dustore", 4, "/path_to_cover", "Деньги", 1, "non-free"]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dustore L4T</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <div class="main-container">
        <div class="header-container">
            <img class="logo" src="/swad/static/img/logo_new.png" alt="">
        </div>
        <div class="view-container">
            <div class="left-side-menu">
                <div class="avatar-canvas" id="btn-profile">
                    <div class="profile-image-container"
                        style="width: 100%;
                        height: 400px;
                        border-radius: 10px;
                        /* border: 1px solid red; */

                        background-image: url('<?= $_SESSION['USERDATA']['profile_picture'] ?>');
                        background-size: cover;
                        background-position: center;

                        -webkit-mask-image: linear-gradient(
                            to bottom,
                            rgba(0,0,0,0) 0%,
                            rgba(0,0,0,1) 40%
                        );
                        mask-image: linear-gradient(
                        to bottom,
                        rgba(0,0,0,1) 0%,
                        rgba(0,0,0,0) 80%
                    );">
                    </div>
                    <div class="image-subtitle">
                        Профиль L4T
                    </div>
                </div>
                <div class="buttons-container">
                    <div class="left-side-button active">
                        Биржа
                    </div>
                    <hr style="width: 50%; margin-right: 25px; margin-left: 25%; opacity: 20%">
                    <div class="left-side-button1">
                        Создать заявку
                    </div>
                </div>
            </div>
            <div class="right-content-view">
                <div class="content-background">

                    <!-- ПРОФИЛЬ -->

                    <div id="view-profile" class="content-view">

                        <div style="color:white; padding:30px;">
                            <h2>Профиль</h2>
                            <p>Ник: <?= $_SESSION['USERDATA']['username'] ?? 'L4T' ?></p>
                            <p>Email: <?= $_SESSION['USERDATA']['email'] ?? '-' ?></p>
                        </div>

                    </div>

                    <!-- БИРЖА -->
                    <div id="view-market" class="content-view active">

                        <div class="content-filter">
                            <div class="filter-item active" data-filter="projects">Проекты</div>
                            <div class="filter-item" data-filter="people">Люди</div>
                        </div>

                        <!-- проекты -->
                        <div id="market-projects" class="market-view active">
                            <?php foreach ($bids_array as $bid): ?>
                                <div class="bid-container"></div>
                            <?php endforeach; ?>
                        </div>

                        <!-- люди -->
                        <div id="market-people" class="market-view">
                            <div class="bid-container"></div>
                            <div class="bid-container"></div>
                        </div>

                    </div>

                    <!-- СОЗДАТЬ ЗАЯВКУ -->
                    <div id="view-create" class="content-view">
                        <form class="create-form">
                            <div class="form-group">
                                <label>Название</label>
                                <input placeholder="Dustore">
                            </div>

                            <div class="form-group">
                                <label>Кого ищем</label>
                                <input placeholder="Unity программист">
                            </div>

                            <button class="submit-btn">Создать</button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script>
        const views = {
            market: document.getElementById("view-market"),
            create: document.getElementById("view-create"),
            profile: document.getElementById("view-profile"),
        };

        const buttons = {
            market: document.querySelector(".left-side-button"),
            create: document.querySelector(".left-side-button1"),
        };

        function showView(name) {
            Object.values(views).forEach(v => v.classList.remove("active"));
            Object.values(buttons).forEach(b => b && b.classList.remove("active"));

            views[name].classList.add("active");
            if (buttons[name]) buttons[name].classList.add("active");
        }

        /* левая панель */
        buttons.market.onclick = () => showView("market");
        buttons.create.onclick = () => showView("create");

        /* профиль */
        document.getElementById("btn-profile").onclick = () => showView("profile");

        /* фильтр биржи */
        const filterItems = document.querySelectorAll(".filter-item");
        const projects = document.getElementById("market-projects");
        const people = document.getElementById("market-people");

        filterItems.forEach(item => {
            item.onclick = () => {
                filterItems.forEach(i => i.classList.remove("active"));
                item.classList.add("active");

                projects.classList.toggle("active", item.dataset.filter === "projects");
                people.classList.toggle("active", item.dataset.filter === "people");
            };
        });
    </script>


</body>

</html>