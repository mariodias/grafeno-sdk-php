<?php

namespace Grafeno\Resources;

use Grafeno\Contracts\GrafenoClient;
use Grafeno\Helpers\Utils;

/**
 * Class Transfers.
 */
class Transfers
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
     * Resource transfer_requests.
     *
     * @const string
     */
    const RESOURCE_TRANSFERS = 'v1/transfer_requests';

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
     * Create a new transfer.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function createTransfer(array $data)
    {
        $url = $this->interpolate(self::BASE_PATH, [
            'resource' => self::RESOURCE_TRANSFERS,
        ]);

        $options = array_merge(['body' => json_encode($data)]);
        
          return $this->client->post($url, $options);
    }

    /**
     * Get a transfers list.
     *
     * @return mixed
     */
    public function listTransfers($page = 1, $per_page = 50)
    {
	    $url = $this->interpolate(self::BASE_PATH, [
	    'resource' => self::RESOURCE_TRANSFERS.'/pending?page='.$page.'&per_page='.$per_page,
	    ]);

         return $this->client->get($url);

    }

    /**
     * Approve or reject a transfer.
     *
     * @param string $transfer_uuid
     * @param array  $data
     *
     * @return mixed
     */
    public function updateTransfer($transfer_uuid, $state, $reject_reason=null)
    {
        $url = $this->interpolate(self::BASE_PATH, [
            'resource'    => self::RESOURCE_TRANSFERS.'/{transfer_uuid}/update_state',
            'transfer_uuid' => $transfer_uuid,
        ]);
        
        $data = [
            'state'=>$state,
            'reject_reason'=>$reject_reason
        ];
        $options = array_merge(['body' => json_encode($data)]);

        return $this->client->patch($url, $options);
    }
}