<?php
$memcached = new Memcached();
$memcached->addServer('jm-memcached1', 11211);
$memcached->addServer('jm-memcached2', 11211);
$memcached->addServer('jm-memcached3', 11211);

$num = $_GET['num'];
$user = 'user';

session_start();

if (!isset($_SESSION['user_' . $user])) {
    $_SESSION['user_' . $user] = $user;
}

function fib($a)
{
    if ($a === 0) {
        return 0;
    }
    if ($a === 1) {
        return 1;
    }
    return fib($a - 1) + fib($a - 2);
}

// Задача 1
//server/index.php?num=40 - выведет на экран страницу с 40м числом фибонначи
//Рассчитанное число должно кешироваться в мэмкеш на 5 минут и не считаться повторно при запросе той же страницы 5 минут, после должно пересчитаться снова

if ($memcached->get('fibKey')) {
    echo $memcached->get('fibKey');
} else {
    $memcached->add('fibKey', fib($num), 300);
    echo $memcached->get('fibKey');
}

// Задача 2
//Предыдущий скрипт должен кешировать число фибонначи по пользователям.
// Пользователь 1 запрашивает страницу server/index.php?num=50,
// число рассчитывается и кешируются, Пользователь 1 при следующих запросах получает быстрый ответ.
// При этом Пользователь 2 рассчитает число фибоначи для себя снова несмотря на остальных.

if ($memcached->get($_SESSION['user_' . $user])) {
    echo $memcached->get($_SESSION['user_' . $user]);
} else {
    $memcached->add($_SESSION['user_' . $user], fib($num), 300);
    echo $memcached->get($_SESSION['user_' . $user]);
}
