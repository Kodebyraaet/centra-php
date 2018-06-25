<?php
/**
 * Created by PhpStorm.
 * User: anthoni
 * Date: 25/06/2018
 * Time: 13:31
 */

namespace Centra\Tests;

use Kodebyraaet\Centra\Centra;

class CentraTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Tests that categories returns
     */
    public function testCategories()
    {
        $centra = new Centra("http://endpoint");

        $result = $centra->categories();

        $this->assertInstanceOf(Centra::class, $result);
    }
}
