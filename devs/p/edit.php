<main class="project-edit">
    <div class="cyber-container">
        <header class="edit-header">
            <h1 class="cyber-title">Контрольный центр проекта <span id="project-id">#001</span></h1>
            <a href="/projects" class="close-btn cyber-button">
                <i class="icon-close"></i>
            </a>
            <style>
                /* Общий киберстиль */
                .cyber-container {
                    max-width: 1200px;
                    margin: 2rem auto;
                    padding: 2rem;
                    background: #0a0a12;
                    border: 2px solid #00f7ff;
                    box-shadow: 0 0 15px rgba(0, 247, 255, 0.3);
                }

                .cyber-title {
                    color: #00f7ff;
                    font-family: 'Courier New', monospace;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                }

                .project-card {
                    background: #1a1a2f;
                    border-radius: 12px;
                    padding: 1.5rem;
                    position: relative;
                    transition: transform 0.3s ease;
                }

                .neon-border {
                    border: 1px solid #4d00ff;
                    box-shadow: 0 0 10px rgba(77, 0, 255, 0.5);
                }

                .hologram-effect {
                    background: linear-gradient(45deg, #00f7ff, #4d00ff);
                    border: none;
                    padding: 12px 24px;
                    color: white;
                    clip-path: polygon(10% 0, 100% 0, 90% 100%, 0 100%);
                    transition: all 0.3s ease;
                }

                .cyber-panels {
                    display: grid;
                    grid-template-columns: 2fr 1fr;
                    gap: 2rem;
                    margin-top: 2rem;
                }

                .cyber-input {
                    background: rgba(255, 255, 255, 0.1);
                    border: 1px solid #00f7ff;
                    color: #00f7ff;
                    padding: 12px;
                    width: 100%;
                }

                .radial-progress {
                    width: 120px;
                    height: 120px;
                    border-radius: 50%;
                    background: conic-gradient(#00f7ff 75%, #1a1a2f 0);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    position: relative;
                }

                @media (max-width: 768px) {
                    .cyber-panels {
                        grid-template-columns: 1fr;
                    }

                    .project-card {
                        margin-bottom: 1.5rem;
                    }

                    .hologram-effect {
                        width: 100%;
                        text-align: center;
                    }
                }
            </style>
        </header>

        <div class="cyber-panels">
            <!-- Левая панель -->
            <div class="panel main-panel">
                <div class="cyber-form">
                    <div class="input-group hologram-bg">
                        <label class="cyber-label">Название проекта</label>
                        <input type="text" class="cyber-input" value="Project Alpha">
                    </div>

                    <div class="input-group hologram-bg">
                        <label class="cyber-label">Описание</label>
                        <textarea class="cyber-textarea">Инновационный проект следующего поколения</textarea>
                    </div>

                    <div class="input-group hologram-bg">
                        <label class="cyber-label">Статус</label>
                        <div class="cyber-radios">
                            <label class="radio-item">
                                <input type="radio" name="status" checked>
                                <span class="radio-custom"></span>
                                Активен
                            </label>
                            <!-- Другие статусы -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Правая панель -->
            <div class="panel side-panel">
                <div class="cyber-widget">
                    <h3 class="widget-title">Действия</h3>
                    <button class="cyber-button save-btn">
                        <i class="icon-save"></i>
                        Сохранить изменения
                    </button>
                    <button class="cyber-button danger">
                        <i class="icon-delete"></i>
                        Удалить проект
                    </button>
                </div>

                <div class="cyber-widget stats">
                    <h3 class="widget-title">Аналитика</h3>
                    <div class="radial-progress" data-progress="75">
                        <div class="progress-circle"></div>
                        <span class="progress-text">75%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>