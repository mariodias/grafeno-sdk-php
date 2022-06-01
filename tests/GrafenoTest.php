<?php

use Grafeno\Grafeno;

it('Should return the API environment', function () 
{
    $environment = $this->grafeno->getEnvironment();
  
    expect($environment)
      ->toBe('https://pagamentos.grafeno.be/api/');
});

it('Should return the API token', function () 
{
    $token = $this->grafeno->getToken();
  
    expect($token)
      ->toBe($this->token);
});

it('Should return the Account Number', function () 
{
    $account_number = $this->grafeno->getAccountNumber();
  
    expect($account_number)
      ->toBe($this->account_number);
});

