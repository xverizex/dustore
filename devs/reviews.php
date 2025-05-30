<div class="ai-review-summary">
    <h3><i class="material-icons">insights</i> Анализ отзывов</h3>

    <div id="ai-summary-loading">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
        <p>Анализируем отзывы игроков...</p>
    </div>

    <div id="ai-summary-results" style="display:none;">
        <div class="sentiment-stats">
            <h4>Общая оценка:</h4>
            <div class="sentiment-bars">
                <div class="sentiment-bar positive">
                    <div class="bar-fill" style="width: 70%">70% положительных</div>
                </div>
                <div class="sentiment-bar neutral">
                    <div class="bar-fill" style="width: 20%">20% нейтральных</div>
                </div>
                <div class="sentiment-bar negative">
                    <div class="bar-fill" style="width: 10%">10% отрицательных</div>
                </div>
            </div>
        </div>

        <div class="improvements">
            <h4>Что нужно улучшить:</h4>
            <ul class="improvement-list">
                <li>Оптимизация производительности</li>
                <li>Баланс сложности</li>
                <li>Управление в игре</li>
            </ul>
        </div>

        <div class="summary">
            <h4>Краткий итог:</h4>
            <p>Игроки высоко оценивают визуальную составляющую и сюжет игры, но отмечают проблемы с оптимизацией на слабых ПК и несбалансированную сложность в середине игры.</p>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const gameId = <?= $game_id ?>;

        // Запрос к API анализа отзывов
        $.getJSON(`/api/analyze_reviews.php?game_id=${gameId}`, function(data) {
            $('#ai-summary-loading').hide();

            if (data.error) {
                $('#ai-summary-results').html(`
                <div class="error">
                    <i class="material-icons">error</i>
                    <p>Ошибка анализа отзывов: ${data.error}</p>
                </div>
            `).show();
                return;
            }

            // Обновление статистики
            $('.sentiment-bar.positive .bar-fill')
                .width(`${data.sentiment_stats.POSITIVE}%`)
                .text(`${data.sentiment_stats.POSITIVE}% положительных`);

            $('.sentiment-bar.neutral .bar-fill')
                .width(`${data.sentiment_stats.NEUTRAL}%`)
                .text(`${data.sentiment_stats.NEUTRAL}% нейтральных`);

            $('.sentiment-bar.negative .bar-fill')
                .width(`${data.sentiment_stats.NEGATIVE}%`)
                .text(`${data.sentiment_stats.NEGATIVE}% отрицательных`);

            // Обновление списка улучшений
            const improvementsList = data.improvements.map(item =>
                `<li>${item.charAt(0).toUpperCase() + item.slice(1)}</li>`
            ).join('');
            $('.improvement-list').html(improvementsList);

            // Обновление итога
            $('.summary p').text(data.summary);

            // Показываем результаты
            $('#ai-summary-results').show();
        });
    });
</script>