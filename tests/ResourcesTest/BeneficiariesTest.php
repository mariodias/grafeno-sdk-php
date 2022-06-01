<?php

use Grafeno\Grafeno;
use Grafeno\Resources\Beneficiaries;

it('Should not create a beneficiary with an invalid document number', function () 
{
  $new_beneficiary = $this->grafeno->beneficiaries()->createBeneficiary([
     "beneficiary" => [
       "name" => "Michael Scott Paper Company, Inc.",
       "document_number" => "00.000.000/0000-00",
       "agency" => "0196",
       "account" => "87766-5",
       "bank_code" => "341"
     ]
]);

    $response = $new_beneficiary;
    $this->assertStringContainsString('CPF/CNPJ não é válido', $response);
});

it('Should list all the beneficiaries', function () 
{
    $beneficiaries = $this->grafeno->beneficiaries()->listBeneficiaries();

    expect($beneficiaries)
      ->json()
      ->toHaveKeys(['data'])
      ->pagination->total_pages->toBeInt();
});

it('Should return a instance of beneficiaries class', function () 
{
    $beneficiaries_class = $this->grafeno->beneficiaries();
    
    expect($beneficiaries_class)
      ->toBeInstanceOf(Beneficiaries::class);
});


