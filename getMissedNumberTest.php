<?php

use PHPUnit\Framework\TestCase;

require('getMissedNumber.php');

class GetMissedNumberTest extends TestCase
{
     /**
     * @dataProvider additionProvider
     */
    public function testGetMissedNumber($a, $expected)
    {
        $this->assertEquals($expected, get_missed_number($a));
    }

    public function additionProvider()
    {
        return [
            [[], false],
            [[12], false],
            [[1, 11], 6],
            [[1, 11, 31], 21],
            [[1,21,31,41], 11]
        ];
    }
}
