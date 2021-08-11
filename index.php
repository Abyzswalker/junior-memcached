<?php

$m = new Memcached();
$m->addServer('jm-memcached1', 11211);
$m->set('testKey', 'testValue');
print_r($m->getResultMessage());
print_r('<hr />');
var_dump($m->get('testKey'));
