<?php

require_once('MyArray.php');

$list = new MyArray('task1.csv');
print_r($list->sortByPrice()->getLimit());