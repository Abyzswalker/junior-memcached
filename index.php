<?php
$memcached = new Memcached();
$memcached->addServer('jm-memcached1', 11211);
$memcached->addServer('jm-memcached2', 11211);
$memcached->addServer('jm-memcached3', 11211);
$memcached->set('testKey', 'testValue');
print_r($memcached->getResultMessage());
print_r('<hr />');
