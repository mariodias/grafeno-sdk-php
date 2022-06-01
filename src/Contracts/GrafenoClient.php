<?php

namespace Grafeno\Contracts;

use GuzzleHttp\Client;

/**
 * Class GrafenoClient.
 */
interface GrafenoClient
{
    /**
     * Production API environment.
     *
     * @const string
     */
    const PRODUCTION = 'https://pagamentos.grafeno.digital/api/';

    /**
     * Staging API environment.
     *
     * @const string
     */
    const STAGING = 'https://pagamentos.grafeno.be/api/';

    /**
     * Dev API environment.
     *
     * @const string
     */
    const DEV = 'https://dev-pagamentos.grafeno.be/api/';

    /**
     * Return a Http client instance.
     *
     * @return Client
     */
    public function getClient();

    /**
     * Executes a GET request.
     *
     * @param null  $url
     * @param array $options
     *
     * @return string
     */
    public function get($url = null, $options = []);

    /**
     * Executes a POST request.
     *
     * @param null  $url
     * @param array $options
     *
     * @return string
     */
    public function post($url = null, $options = []);

    /**
     * Executes a PUT request.
     *
     * @param null  $url
     * @param array $options
     *
     * @return string
     */
    public function put($url = null, $options = []);

    /**
     * Executes a DELETE request.
     *
     * @param null  $url
     * @param array $options
     *
     * @return string
     */
    public function delete($url = null, $options = []);

    /**
     * Executes a PATCH request.
     * 
     * @param null  $url
     * @param array $options
     * 
     * @return string
     */
    public function patch($url = null, $options = []);
}
