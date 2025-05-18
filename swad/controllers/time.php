
<?php

date_default_timezone_set('Europe/Moscow');

class Time
{
    public function getServerTime()
    {
        return date('d.m.Y H:i', time());
    }
}

function time_ago($datetime)
{
    $now = new DateTime();
    $now->setTimezone(new DateTimeZone('Europe/Moscow'));
    $now->format('Y-m-d H:i:s');
    try {
        $ago = new DateTime($datetime);
    } catch (Exception $e) {
        return 'неверная дата';
    }

    if ($ago > $now) {
        return 'в будущем';
    }

    $diff = $now->diff($ago);
    $intervalInSeconds = $now->getTimestamp() - $ago->getTimestamp();

    if ($intervalInSeconds < 5) {
        return 'только что';
    } elseif ($intervalInSeconds < 60) {
        return plural_form($intervalInSeconds, ['секунда', 'секунды', 'секунд']) . ' назад';
        // TODO: пофиксить не отображаются секунды
    }

    $weeks = floor($diff->d / 7);
    $remainingDays = $diff->d % 7;

    $units = [
        'y' => ['год', 'года', 'лет'],
        'm' => ['месяц', 'месяца', 'месяцев'],
        'd' => ['день', 'дня', 'дней'],
        'h' => ['час', 'часа', 'часов'],
        'i' => ['минута', 'минуты', 'минут']
    ];

    if ($weeks > 0) {
        $units = ['w' => ['неделю', 'недели', 'недель']] + $units;
        $diff->w = $weeks;
        $diff->d = $remainingDays;
    }

    foreach ($units as $unit => $titles) {
        if (isset($diff->$unit) && $diff->$unit > 0) {
            $value = $diff->$unit;

            // Специальные случаи
            if ($unit === 'd' && $value === 1) return 'вчера';
            if ($unit === 'd' && $value === 2) return 'позавчера';

            return $value . ' ' . plural_form($value, $titles) . ' назад';
        }
    }

    return 'только что';
}

function plural_form($number, $titles)
{
    $cases = [2, 0, 1, 1, 1, 2];
    $index = ($number % 100 > 4 && $number % 100 < 20)
        ? 2
        : $cases[min($number % 10, 5)];

    return $titles[$index];
}