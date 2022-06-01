<?php

namespace Grafeno\Resources;

use Grafeno\Contracts\GrafenoClient;
use Grafeno\Helpers\Utils;

/**
 * Class Beneficiaries.
 */
class Beneficiaries
{
    /*
     * Standardizes the return format.
     */
   use Utils;

    /**
     * Base Path API.
     *
     * @const string
     */
    const BASE_PATH = '{resource}';

    /**
     * Resource beneficiaries.
     *
     * @const string
     */
    const RESOURCE_BENEFICIARIES = 'v1/beneficiaries';

        /**
     * Resource beneficiaries.
     *
     * @const string
     */

    /**
     * http client instance.
     *
     * @param stdClass GrafenoClient $client
     */
    protected $client;

    /**
     * Initialize a new http client instance.
     *
     * @param stdClass GrafenoClient $client
     */
    public function __construct(GrafenoClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new Beneficiary.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function createBeneficiary(array $data)
    {
        $url = $this->interpolate(self::BASE_PATH, [
            'resource' => self::RESOURCE_BENEFICIARIES,
        ]);

        $options = array_merge(['body' => json_encode($data)]);
        
            return $this->client->post($url, $options);
    }

    /**
     * Get a beneficiaries list.
     *
     * @return mixed
     */
    public function listBeneficiaries($page = 1, $per_page = 50)
    {
	    $url = $this->interpolate(self::BASE_PATH, [
	   'resource' => self::RESOURCE_BENEFICIARIES.'?page='.$page.'&per_page='.$per_page,
	    ]);

        return $this->client->get($url);
    }

    /**
     * Approve or reject a Beneficiary.
     *
     * @param string $Beneficiary_uuid
     * @param array  $data
     *
     * @return mixed
     */
}