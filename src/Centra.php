<?php

namespace Kodebyraaet\Centra;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\GuzzleException;


/**
 * This is a package for easier communication with the Centra API.
 * @package Centra
 */
class Centra
{
    /**
     * Guzzle Client
     * @var Client
     */
    private $client;


    /**
     * Guzzle Request
     * @var Request
     */
    private $request;


    /**
     * Request parameters that are sent to the request.
     * @var array
     */
    private $body = [];


    /**
     * @param $endpoint string Centra API endpoint
     */
    public function __construct($endpoint)
    {
        $this->client = new Client([
            'base_uri' => $endpoint,
            'timeout' => 5.0
        ]);
    }

    /**
     * Returns the categories
     * @return Centra
     */
    public function categories()
    {
        $this->request = new Request('GET', 'categories');
        return $this;
    }


    /**
     * Returns the countries
     * @return Centra
     */
    public function countries()
    {
        $this->request = new Request('GET', 'countries');
        return $this;
    }

    /**
     * Returns the languages
     * @return Centra
     */
    public function languages()
    {
        $this->request = new Request('GET', 'languages');
        return $this;
    }


    /**
     * Returns the markets
     * @return Centra
     */
    public function markets()
    {
        $this->request = new Request('GET', 'markets');
        return $this;
    }



    /**
     * Returns the products
     * @return Centra
     */
    public function products()
    {
        $this->request = new Request('POST', 'products');
        return $this;
    }


    /**
     * Returns a single product
     * @param string $productId Product ID
     * @return Centra
     */
    public function product($productId)
    {
        $this->request = new Request('GET', 'products/' . $productId);
        return $this;
    }


    /**
     * Returns the price lists
     * @return Centra
     */
    public function priceLists()
    {
        $this->request = new Request('GET', 'pricelists');
        return $this;
    }


    /**
     * Narrows the results based on the search string
     * @param string $string
     * @return Centra
     */
    public function search($string)
    {
        $this->body['search'] = $string;
        return $this;
    }


    /**
     * Add custom options to the request
     * @param array $options
     * @return Centra
     */
    public function options(array $options)
    {
        $this->body = array_merge($this->body, $options);
        return $this;
    }


    /**
     * Runs the request and handles the response and errors
     * @param int $limit
     * @param int $skip
     * @return mixed
     */
    public function get($limit = 0, $skip = 0)
    {
        $this->body['limit'] = (int) $limit;
        $this->body['skipFirst'] = (int) $skip;

        try {
            $response = $this->client->send($this->request, ['body' => json_encode($this->body)]);

            // clean up body
            $this->body = [];

            return $this->displayResponse($response);
        } catch (ServerException $e) {
            $this->displayErrorMessage(json_decode($e->getResponse()->getBody()->getContents()));
        } catch (GuzzleException $e) {
            $this->displayErrorMessage(json_decode($e->getResponse()->getBody()->getContents()));
        }
    }

    /**
     * Displays the response
     * @param $response ResponseInterface
     * @return mixed
     */
    private function displayResponse($response)
    {
        return json_decode($response->getBody()->getContents());
    }


    /**
     * Displays the error message
     * @param $error \stdClass
     */
    private function displayErrorMessage($error)
    {
        // TODO: Display this better.
        echo '<pre>';
        print_r($error);
        exit();
    }
}
