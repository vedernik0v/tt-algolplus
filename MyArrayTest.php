<?php

use PHPUnit\Framework\TestCase;

require_once('MyArray.php');

final class MyArrayTest extends TestCase
{
    protected $myArray;

    public function __construct()
    {
        $this->myArray = new MyArray('task1.csv');
    }

    // Проверка количества загруженных элементов
    public function testImport()
    {
        $this->assertEquals(
            10,
            count($this->myArray->getAll())
        );
    }

    // Проверка свойств элементов списка
    public function testItemKeys()
    {
        $this->assertEquals(
            ['Id', 'Price', 'Name', 'Tax'],
            $this->myArray->getItemsKeys()
        );
    }

    // Проверка сортировки по цене
    public function testSortByPrice()
    {
        $this->myArray->sortByPrice();
        $this->assertEquals(
            [8, 12, 111, 345, 349, 432, 453, 765, 865, 10234],
            $this->myArray->pluck('Price')
        );
        // print_r($this->myArray->getAll());

        // обратная
        $this->myArray->sortByPrice('desc');
        $this->assertEquals(
            [10234, 865, 765, 453, 432, 349, 345, 111, 12, 8],
            $this->myArray->pluck('Price')
        );
        // print_r($this->myArray->getAll());
    }

    public function testGetLimit()
    {
        $this->myArray->sortByPrice();
        $this->assertEquals(
            5,
            count($this->myArray->getLimit(5))
        );
        // print_r($this->myArray->getLimit());
    }
}