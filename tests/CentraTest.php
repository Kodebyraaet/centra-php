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
    private $centra;

    /**
     * CentraTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->centra = new Centra("http://endpoint", "apiKey");
    }


    public function test_that_categories_returns_self()
    {
        $result = $this->centra->categories();
        $this->assertInstanceOf(Centra::class, $result);
    }

    public function test_that_countries_returns_self()
    {
        $result = $this->centra->countries();
        $this->assertInstanceOf(Centra::class, $result);
    }

    public function test_that_languages_returns_self()
    {
        $result = $this->centra->languages();
        $this->assertInstanceOf(Centra::class, $result);
    }

    public function test_that_markets_returns_self()
    {
        $result = $this->centra->markets();
        $this->assertInstanceOf(Centra::class, $result);
    }

    public function test_that_products_returns_self()
    {
        $result = $this->centra->products();
        $this->assertInstanceOf(Centra::class, $result);
    }

    public function test_that_product_returns_self()
    {
        $result = $this->centra->product(1);
        $this->assertInstanceOf(Centra::class, $result);
    }

    public function test_that_price_lists_returns_self()
    {
        $result = $this->centra->priceLists();
        $this->assertInstanceOf(Centra::class, $result);
    }

    public function test_that_search_sets_string_and_returns_self()
    {
        $result = $this->centra->search('string');

        $this->assertArrayHasKey('search', $this->centra->getBody());
        $this->assertInstanceOf(Centra::class, $result);
    }

    public function test_that_options_set_custom_option_and_returns_self()
    {
        $result = $this->centra->options(['custom' => 'option']);

        $this->assertArrayHasKey('custom', $this->centra->getBody());
        $this->assertInstanceOf(Centra::class, $result);
    }

    public function test_that_getBody_returns_array()
    {
        $result = $this->centra->getBody();
        $this->assertInternalType('array', $result);
    }


}
