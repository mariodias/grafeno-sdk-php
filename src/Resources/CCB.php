<?php

namespace Grafeno\Resources;

use Grafeno\Contracts\GrafenoClient;
use Grafeno\Helpers\Utils;

/**
 * Class CCB.
 */
class CCB
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
     * Resource CCB.
     *
     * @const string
     */
    const RESOURCE_CCB = 'v2/ccb_requests';

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
     * Create a new CCB.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function createCCB(array $data, $options = [])
    {
        $url = $this->interpolate(self::BASE_PATH, [
            'resource' => self::RESOURCE_CCB,
        ]);

        $options = array_merge($options, ['body' => json_encode($data)]);

        return $this->client->post($url, $options);
    }

    /**
     * Get details about a CCB.
     *
     * @param string $ccb_id
     *
     * @return mixed
     */
    public function getCCB($ccb_id)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{ccb_id}', [
            'resource' => self::RESOURCE_CCB,
            'ccb_id' => $ccb_id,
        ]);

        return $this->client->get($url);
    }

		/**
     * Get a CCB list.
     *
     * @param string $ccb_id
     *
     * @return mixed
     */
    public function listCCB($page = 1, $per_page = 50)
    {
        $url = $this->interpolate(self::BASE_PATH, [
            'resource' => self::RESOURCE_CCB.'?page='.$page.'&per_page='.$per_page,
            'ccb_id' => $ccb_id,
        ]);

        return $this->client->get($url);
    }

    /**
     * Get a CCB creditors list.
     *
     * @return mixed
     */
    public function listCCBCreditors()
		{
          
				$url = $this->interpolate(self::BASE_PATH, [
						'resource' => self::RESOURCE_CCB.'/creditors',
				]);

        return $this->client->get($url);
    }

    /**
     * Delete a CCB.
     *
     * @param string $ccb_id
     *
     * @return mixed
     */
    public function deleteCCB($ccb_id)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{ccb_id}/cancel', [
            'resource'    => self::RESOURCE_CCB,
            'ccb_id' => $ccb_id,
        ]);

        return $this->client->post($url);
    }

    /**
     * Simulate a CCB.
		 * 
		 * The parameter $first_due_date must be passed in yyyy-mm-dd format.
		 * 
     * @param string $net_value
		 * @param string $monthly_interest
		 * @param int    $installments
		 * @param date   $first_due_date
     *
     * @return mixed
     */
    public function simulateCCB($net_value, $monthly_interest, $installments, $first_due_date)
    {
        $url = $this->interpolate(self::BASE_PATH.'/simulate', [
            'resource' => self::RESOURCE_CCB
        ]);

				$data = [
						'valorLiquido' => $net_value,
						'jurosMensal' => $monthly_interest,
						'parcelas' => $installments,
						'primeiraParcela' => $first_due_date,
				];

        $options = array_merge(['body' => json_encode($data)]);

        return $this->client->post($url, $options);
    }

    /**
     * Update a CCB.
     *
     * @param string $ccb_id
		 * @param array  $data
     *
     * @return mixed
     */
    public function updateCCB($ccb_id, array $data)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{ccb_id}', [
            'resource'    => self::RESOURCE_CCB,
            'ccb_id' => $ccb_id,
        ]);

				$options = array_merge(['body' => json_encode($data)]);

        return $this->client->patch($url, $options);
    }

    /**
     * Create or update the CCB debtor.
     *
     * @param string $ccb_id
		 * @param array  $data
     *
     * @return mixed
     */
    public function createOrUpdateCCBDebtor($ccb_id, array $data)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{ccb_id}/update_borrower', [
            'resource'    => self::RESOURCE_CCB,
            'ccb_id' => $ccb_id,
        ]);

				$options = array_merge(['body' => json_encode($data)]);

        return $this->client->patch($url, $options);
    }

    /**
     * Create or update the CCB guarantor.
     *
     * @param string $ccb_id
		 * @param array  $data
     *
     * @return mixed
     */
    public function createOrUpdateCCBGuarantor($ccb_id, array $data)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{ccb_id}/update_guarantor', [
            'resource'    => self::RESOURCE_CCB,
            'ccb_id' => $ccb_id,
        ]);

				$options = array_merge(['body' => json_encode($data)]);

        return $this->client->patch($url, $options);
    }

    /**
     * Upload CCB debtor files.
     *
     * @param string $ccb_id
		 * @param array  $data
     *
     * @return mixed
     */
    public function uploadDebtorFiles($ccb_id, array $data)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{ccb_id}/upload_borrower_file', [
            'resource'    => self::RESOURCE_CCB,
            'ccb_id' => $ccb_id,
        ]);
				
				$options = array_merge(['body' => json_encode($data)]);

        return $this->client->post($url, $options);
    }

    /**
     * Upload CCB guarantor files.
     *
     * @param string $ccb_id
		 * @param array  $data
     *
     * @return mixed
     */
    public function uploadGuarantorFiles($ccb_id, array $data)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{ccb_id}/upload_guarantor_file', [
            'resource'    => self::RESOURCE_CCB,
            'ccb_id' => $ccb_id,
        ]);


			 $options = array_merge(['body' => json_encode($data)]);

        return $this->client->post($url, $options);
    }

    /**
     * Send CCB to analysis.
     *
     * @param string $ccb_id
     *
     * @return mixed
     */
    public function sendCCBToAnalysis($ccb_id)
    {
        $url = $this->interpolate(self::BASE_PATH.'/{ccb_id}/submit', [
            'resource'    => self::RESOURCE_CCB,
            'ccb_id' => $ccb_id,
        ]);

        return $this->client->post($url);
    }
}
