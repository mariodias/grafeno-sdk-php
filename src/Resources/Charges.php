<?php

namespace Grafeno\Resources;

use Grafeno\Contracts\GrafenoClient;
use Grafeno\Helpers\Utils;

/**
 * Class Charges.
 */
class Charges
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
     * Resource charges.
     *
     * @const string
     */
    const RESOURCE_CHARGES = 'v1/charges';

    /**
     * Resource CNAB.
     *
     * @const string
     */
    const RESOURCE_CNAB = 'v1/cnab';

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
     * Create a new charge.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function createCharge(array $data, $options = [])
    {
        $url = $this->interpolate(self::BASE_PATH, [
            'resource' => self::RESOURCE_CHARGES,
        ]);

        $options = array_merge($options, ['body' => json_encode($data)]);

         return $this->client->post($url, $options);
    }

    /**
     * Get details about a charge.
     *
     * @param string $charge_uuid
     *
     * @return mixed
     */
    public function getCharge($charge_uuid)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{charge_uuid}', [
            'resource'    => self::RESOURCE_CHARGES,
            'charge_uuid' => $charge_uuid,
        ]);

        return $this->client->get($url);
    }

    /**
     * Get a charges list.
     *
     * @return mixed
     */
    public function listCharges($page = 1, $per_page = 50, $filter = null)
		{
          
				$url = $this->interpolate(self::BASE_PATH, [
						'resource' => self::RESOURCE_CHARGES.'?page='.$page.'&per_page='.$per_page.'&search'.$filter,
				]);

        return $this->client->get($url);
    }

    /**
     * Delete a charge.
     * This method only works to cancel a charge type TED or a not registered bank billet.
     *
     * @param string $charge_uuid
     *
     * @return mixed
     */
    public function deleteCharge($charge_uuid)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{charge_uuid}', [
            'resource'    => self::RESOURCE_CHARGES,
            'charge_uuid' => $charge_uuid,
        ]);

        return $this->client->delete($url);
    }

    /**
     * Update a charge.
     *
     * @param string $charge_uuid
     * @param array  $data
     *
     * @return mixed
     */
    public function updateCharge($charge_uuid, array $data)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{charge_uuid}', [
            'resource'    => self::RESOURCE_CHARGES,
            'charge_uuid' => $charge_uuid,
        ]);

        $options = array_merge(['body' => json_encode($data)]);

        return $this->client->patch($url, $options);
    }

    /**
     * Write off a charge.
     *
     * @param string $charge_uuid
     *
     * @return mixed
     */
    public function writeOffCharge($charge_uuid)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{charge_uuid}/paid_externally', [
            'resource'    => self::RESOURCE_CHARGES,
            'charge_uuid' => $charge_uuid,
        ]);

        return $this->client->patch($url);
    }

    /**
     * Protest a charge.
     *
     * @param string $charge_uuid
     *
     * @return mixed
     */
    public function protestCharge($charge_uuid)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{charge_uuid}/protest', [
            'resource'    => self::RESOURCE_CHARGES,
            'charge_uuid' => $charge_uuid,
        ]);

        return $this->client->post($url);
    }

    /**
     * Cancel protest.
     *
     * @param string $charge_uuid
     *
     * @throws ClientException
     *
     * @return mixed
     */
    public function cancelProtestCharge($charge_uuid)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{charge_uuid}/cancel_protest', [
            'resource'    => self::RESOURCE_CHARGES,
            'charge_uuid' => $charge_uuid,
        ]);

        return $this->client->post($url);
    }

    /**
     * List CNAB.
		 * The $date parameter must be in the format yyyy-mm-dd.
     *
     * @param date $date
     *
     * @return mixed
     */
    public function listCNAB($date)
    {
        $url = $this->interpolate(self::BASE_PATH.'/returns/{date}', [
            'resource' => self::RESOURCE_CNAB,
            'date'     => $date,
        ]);

        return $this->client->get($url);
    }
}
