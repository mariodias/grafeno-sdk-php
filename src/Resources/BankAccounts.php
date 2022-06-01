<?php

namespace Grafeno\Resources;

use Grafeno\Contracts\GrafenoClient;
use Grafeno\Helpers\Utils;

/**
 * Class BankAccounts.
 */
class BankAccounts
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
     * Resource bank accounts.
     *
     * @const string
     */
    const RESOURCE_BANK_ACCOUNTS = 'ip_bank_accounts';

    /**
     * Resource bank transactions.
     *
     * @const string
     */
    const RESOURCE_BANK_TRANSACTIONS = 'v1/statement_entries';

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
     * Get a bank accounts list.
     *
     * @return mixed
     */
    public function listBankAccounts($page = null)
		{
			  $url = $this->interpolate(self::BASE_PATH, [
						'resource' => self::RESOURCE_BANK_ACCOUNTS,
				]);

				return $this->client->get($url);
		}

    /**
     * List the bank account transactions.
     *
     * @return mixed
     */
    public function listBankAccountTransactions($page = null, $filter = null)
    {
        $url = $this->interpolate(self::BASE_PATH, [
            'resource' => self::RESOURCE_BANK_TRANSACTIONS.'?page='.$page.'&search'.$filter,
            ]);

        return $this->client->get($url);
    }
}
