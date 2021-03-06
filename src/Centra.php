<?php

namespace Kodebyraaet\Centra;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
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
    private $client = null;


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


    public $response;

    /**
     * Initialize GuzzleClient for Centra.
     */
    public function initClient()
    {
        $config = [
            'base_uri' => config('centra.endpoint'),
            'timeout' => 10.0,
            'headers' => [
                'API-Authorization' => config('centra.auth_key')
            ]
        ];

        $this->client = new Client($config);
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
     * Returns product ids
     * @return $this
     */
    public function productIds()
    {
        $this->request = new Request('GET', 'product-ids');
        return $this;
    }

    /**
     * Returns the products
     * @param array $ids
     * @return Centra
     */
    public function products($ids = [])
    {
        if (empty($ids)) {
            $this->request = new Request('GET', 'products');
        } else {
            $this->request = new Request('POST', 'products/filter');
            $this->body['products'] = $ids;
        }
        return $this;
    }

    /**
     * Starts a newletter subscription for an e-mail address
     * @param $email
     * @param array $fields product|country
     * @return $this
     */
    public function newsletterSubscription($email, $fields = [])
    {
        $this->request = new Request('POST', 'customers/' . $email . '/newsletter-subscription');

        if (array_key_exists('product', $fields)) $this->body['product'] = (string) $fields['product'];
        if (array_key_exists('country', $fields)) $this->body['country'] = $fields['country'];

        return $this;
    }


    /**
     * Returns a single product
     * @param string $productId ID
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
     * Returns the request body
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }


    /**
     * @return mixed
     * @throws Exception
     */
    public function get()
    {
        if($this->client === null) $this->initClient();

        try {
            $this->response = $this->client->send($this->request, ['body' => json_encode($this->getBody())]);

            // clean up body
            $this->body = [];

            return json_decode($this->response->getBody()->getContents());
        } catch (ServerException $e) {
            return response()->json($e->getMessage());
        } catch (GuzzleException $e) {
            return response()->json(
                json_decode($e->getResponse()->getBody()->getContents()),
                $e->getResponse()->getStatusCode()
            );
        }
    }
}
