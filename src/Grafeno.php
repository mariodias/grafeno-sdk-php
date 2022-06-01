<?php

namespace Grafeno;

use GuzzleHttp\Client;
use Grafeno\Contracts\GrafenoClient;
use Grafeno\Helpers\Filters;
use Grafeno\Resources\BankAccounts;
use Grafeno\Resources\Beneficiaries;
use Grafeno\Resources\CCB;
use Grafeno\Resources\Charges;
use Grafeno\Resources\Transfers;

/**
 * Class Grafeno.
 */
class Grafeno implements GrafenoClient
{
    /**
     * Http Client Instance.
     *
     * @param stdClass
		 * @var GuzzleHttp\Client
		 */
    protected $client;

    /**
     * Grafeno API authentication token.
     *
     * @var string
     */
    protected $token;

    /**
     * Grafeno API environment.
     *
     * @var stdClass
     */
    protected $environment = GrafenoClient::STAGING;

    /**
     * Client request options.
     *
     * @var array
     */
    protected $requestOptions = [];

    /**
     * Grafeno class new instance.
     *
     * @param string $token
     * @param string $environment
     * @param string $accountNumber
     */
    public function __construct($token, $accountNumber, $environment = GrafenoClient::PRODUCTION)
    {
        $this->setCredential($token);
        $this->setAccountNumber($accountNumber);
        $this->setEnvironment($environment);

        $this->environment = $environment;

        $this->createSession();
    }

		/**
		 * Set the GuzzleHttp Client Session.
		 * 
		 */
    public function createSession() 
    {
        $this->client = new Client(['base_uri' => $this->environment, 'verify' => false, 'http_errors' => false]);

        $this->requestOptions = [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => "{$this->token}",
                'Account-Number' => "{$this->accountNumber}",
                'User-Agent' => "Grafeno SDK PHP - V1.0.0 +https://github.com/grafeno-sa/grafeno-sdk-php",
            ],
        ];
    }

		/**
		 * Get the GuzzleHttp Client Session.
		 * 
		 */
    public function getClient() 
    {
        return $this->client;
    }

	  /**
     * Set the Grafeno API token.
     *
     * @param string $token
     *
     * @return $this
     */
    public function setCredential($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set the Grafeno environment.
     *
     * @param stdClass $environment
     *
     * @return $this
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * Set the Grafeno account number.
     *
     * @param stdClass $accountNumber
     *
     * @return $this
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

		/**
		 * Get the Grafeno API environment.
		 * 
		 * @return $this
		 */
    public function getEnvironment()
    {
        return $this->environment;
    }

		/**
		 * Get the Grafeno API token.
		 * 
		 * @return $this
		 */
		public function getToken()
		{
				return $this->token;
		}
		
		/**
		 * Get the Grafeno account number.
		 * 
		 * @return $this
		 */ 
		public function getAccountNumber()
		{
				return $this->accountNumber;
		}

		/**
     * Create a new Bank Accounts instance.
     *
     * @return \Grafeno\Resources\BankAccounts
     */
    public function bankAccounts()
    {
        return new BankAccounts($this);
    }

		/**
     * Create a new Beneficiaries instance.
     *
     * @return \Grafeno\Resources\Beneficiaries
     */
    public function beneficiaries()
    {
        return new Beneficiaries($this);
    }

		/**
     * Create a new CCB instance.
     *
     * @return \Grafeno\Resources\CCB
     */
    public function ccb()
    {
        return new CCB($this);
    }

    /**
     * Create a new Charges instance.
     *
     * @return \Grafeno\Resources\Charges
     */
    public function charges()
    {
        return new Charges($this);
    }

		/**
     * Create a new Transfers instance.
     *
     * @return \Grafeno\Resources\Transfers
     */
    public function transfers()
    {
        return new Transfers($this);
    }

    /**
     * Executes a GET request.
     *
     * @param null  $url
     * @param array $options
     *
     * @return string
     */
    public function get($url = null, $options = [])
    {
        $response = $this->client->get($url, $this->getOptions($options));

        if($response->getStatusCode() == 200) {

            return $response->getBody()->getContents();

        } else if($response->getStatusCode() == 201) {

            return $response->getBody()->getContents();
        }
        else {
            $status = $response->getStatusCode();
            $reason = $response->getReasonPhrase();
            $message = $response->getBody()->getContents();

            $template = "[$status] The following errors ocurred:\n%s";
            $error_message .= "$status: $reason: $message\n";

            return sprintf($template, $error_message);
        }  
    }   
    
    /**
     * Executes a POST request.
     *
     * @param null  $url
     * @param array $options
     *
     * @return string
     */
    public function post($url = null, $options = [])
    {
			$response = $this->client->post($url, $this->getOptions($options));

			if($response->getStatusCode() == 200) {

					return $response->getBody()->getContents();

			} else if($response->getStatusCode() == 201) {

          return $response->getBody()->getContents();

      } else if($response->getStatusCode() == 204) {

          return '{"success": true, "message": "OK"}';

      } else {
        
          $status = $response->getStatusCode();
          $reason = $response->getReasonPhrase();
          $message = $response->getBody()->getContents();

          $template = "[$status] The following errors ocurred:\n%s";
          $error_message .= "$status: $reason: $message\n";

          return sprintf($template, $error_message);
      }

    }

    /**
     * Executes a PUT request.
     *
     * @param null  $url
     * @param array $options
     *
     * @return string
     */
    public function put($url = null, $options = [])
    {
			$response = $this->client->put($url, $this->getOptions($options));

			if($response->getStatusCode() == 200) {
					return $response->getBody()->getContents();

			} else {
					$status = $response->getStatusCode();
					$reason = $response->getReasonPhrase();
					$message = $response->getBody()->getContents();

					$template = "[$status] The following errors ocurred:\n%s";
					$error_message .= "$status: $reason: $message\n";

					return sprintf($template, $error_message);
			}  
    }

    /**
     * Executes a DELETE request.
     *
     * @param null  $url
     * @param array $options
     *
     * @return string
     */
    public function delete($url = null, $options = [])
    {
			$response = $this->client->delete($url, $this->getOptions($options));

			if($response->getStatusCode() == 200) {
					return $response->getBody()->getContents();

			} else {
					$status = $response->getStatusCode();
					$reason = $response->getReasonPhrase();
					$message = $response->getBody()->getContents();

					$template = "[$status] The following errors ocurred:\n%s";
					$error_message .= "$status: $reason: $message\n";

					return sprintf($template, $error_message);
			}  
    }

    /**
     * Executes a PATCH request.
     *
     * @param null  $url
     * @param array $options
     *
     * @return string
     */
    public function patch($url = null, $options = [])
    {
      $response = $this->client->patch($url, $this->getOptions($options));

        if($response->getStatusCode() == 200) {
            return $response->getBody()->getContents();

        } else {
            $status = $response->getStatusCode();
            $reason = $response->getReasonPhrase();
            $message = $response->getBody()->getContents();

            $template = "[$status] The following errors ocurred:\n%s";
            $error_message .= "$status: $reason: $message\n";

            return sprintf($template, $error_message);
        }  
    }

    /**
     * Get the request options.
     *
     * @param array $options
     *
     * @return array
     */
    public function getOptions($options = [])
    {
        return array_merge($this->requestOptions, $options);
    }
}
