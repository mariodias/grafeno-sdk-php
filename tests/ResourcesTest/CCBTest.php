<?php

use Grafeno\Grafeno;
use Grafeno\Resources\CCB;

it('Should simulate the CCB values', function () 
{
    $net_value = '200000.0';
    $monthly_interest = '5';
    $installments = 36;
    $first_due_date = '2022-07-01';

    $ccb = $this->grafeno->ccb()->simulateCCB($net_value, $monthly_interest, $installments, $first_due_date);

    expect($ccb)
      ->json()
      ->data->attributes->valorLiquido->toBeString()
      ->data->attributes->valorLiquido->toBe($net_value)
      ->data->type->toBe('ccbSimulation')
      ->data->attributes->parcelas->toBeInt()
      ->data->attributes->parcelas->toBe($installments);
});

it('Should list the CCB creditors', function () 
{
    $creditors = $this->grafeno->ccb()->listCCBCreditors();

    expect($creditors)
      ->json()
      ->data->toBeArray()
      ->meta->pagination->totalCount->toBeGreaterThanOrEqual(0);
});

it('Should create a CCB', function () 
{
    $creditors = $this->grafeno->ccb()->listCCBCreditors();
    $response = json_decode($creditors);

    $creditor_uuid = $response->data[0]->id;

    $new_ccb = $this->grafeno->ccb()->createCCB([
      "credorId" => $creditor_uuid,
      "valorLiquido" => "300000.00",
      "jurosMensal" => "10",
      "parcelas" => 12,
      "primeiraParcela" => "2022-07-09",
      "garantiaRecebiveis" => true
  ]);

    expect($new_ccb)
      ->json()
      ->data->id->toBeString()
      ->data->attributes->status->toBe("Em construção");
});

it('Should get a CCB', function () 
{
    $ccbs = $this->grafeno->ccb()->listCCB();
    $ccb_data = json_decode($ccbs);
    $uuid = $ccb_data->data[0]->id;

    $ccb = $this->grafeno->ccb()->getCCB($uuid);
    $ccb_data = json_decode($ccb);
    $returned_uuid = $ccb_data->data->id;

    expect($uuid)->toBe($returned_uuid);
});

it('Should list the CCBs', function () 
{
    $ccb = $this->grafeno->ccb()->listCCB();

    expect($ccb)
      ->json()
      ->meta->pagination->totalCount->toBeGreaterThanOrEqual(0);
});

it('Should update or create the CCB guarantor', function () 
{
    $ccb_list = $this->grafeno->ccb()->listCCB();
    $ccb_data = json_decode($ccb_list);
    $uuid = $ccb_data->data[0]->id;

    $guarantor_name = "Dwight Schrute";

    $ccb = $this->grafeno->ccb()->createOrUpdateCCBGuarantor($uuid,[
      "name" => $guarantor_name,
      "documentNumber" => "12345679891",
      "phone" => "11999999999",
      "email" => "dwight@dundermifflin.com",
      "maritalStatus" => "single",
      "address" => [
        "street" => "Rua",
        "number" => "42",
        "state" => "SP",
        "city" => "São Paulo",
        "zipCode" => "57035-556"
      ]
  ]);

    $response = json_decode($ccb);

    expect($guarantor_name)->toBe($response->data->attributes->avalistas->data[0]->attributes->name);
});

it('Should update or create the debtor of CCB', function () 
{
    $ccb_list = $this->grafeno->ccb()->listCCB();
    $ccb_data = json_decode($ccb_list);
    $uuid = $ccb_data->data[0]->id;
    $debtor_name = "Andy Bernard";
    $debtor_email = "the-nard-dog@dcornell.edu";

    $ccb = $this->grafeno->ccb()->createOrUpdateCCBDebtor($uuid, [
          "name" => $debtor_name,
          "documentNumber" => "55.054.861/0001-44",
          "phone" => "11999999999",
          "email" => $debtor_email,
          "address" => [
              "street" => "Rua",
              "number" => "42",
              "state" => "SP",
              "city" => "São Paulo",
              "zipCode" => "57035-556"
            ],
          "bankAccount" => [
              "bankCode" => "341",
              "agency" => "0196",
              "account" => "87766-5",
              "name" => "Andy Bernard",
              "documentNumber" => "55.054.861/0001-44"
            ],
          "signer" => [
              "name" => "Andy Bernard",
              "documentNumber" => "884.850.443-47",
              "phone" => "11999999999",
              "email" => "the-nard-dog@dcornell.edu"
            ]
        ]);

    expect($ccb)
      ->json()
      ->data->id->toBeString()
      ->data->attributes->name->toBe($debtor_name)
      ->data->attributes->email->toBe($debtor_email);
});

it('Should upload the guarantor file', function () 
{
    $ccb_list = $this->grafeno->ccb()->listCCB();
    $ccb_data = json_decode($ccb_list);
    $uuid = $ccb_data->data[0]->id;
    $guarantor_id = $ccb_data->data[0]->attributes->avalistas->data[0]->id;

    $ccb = $this->grafeno->ccb()->uploadGuarantorFiles($uuid, [
      "guarantorId" => $guarantor_id,
      "type" => "identification_document_file",
      "fileName" => "identification_document_file.pdf",
      "file" => "JVBERi0xLjUKJb/3ov4KMiAwIG9iago8PCAvTGluZW
      L08gNiAvRSA4NTcwIC9OIDEgL1QgODU2OSA+PgplbmRvYmoKICAgI+Pgp
      zdHJlYW0KeJxjYgACJkbFKgYAAYMAoQplbmRzdHJlYW0KZW5k
      ICAgICAgICAgICAgIApzdGFydHhyZWYKMjE2CiUlRU9GCg=="
    ]); 
  
    expect($ccb)
      ->json()
      ->toHaveKeys(['success', 'message'])
      ->success->toBeTrue()
      ->message->toBe('OK');
});

it('Should upload the debtor file', function () 
{
    $ccb_list = $this->grafeno->ccb()->listCCB();
    $ccb_data = json_decode($ccb_list);
    $uuid = $ccb_data->data[0]->id;

    $ccb = $this->grafeno->ccb()->uploadDebtorFiles($uuid, [
       "type" => "social_contract_file",
       "fileName" => "social_contract_file.pdf",
       "file" => "JVBERi0xLjUKJb/3ov4KMiAwIG9iago8PCAvTGluZW
       L08gNiAvRSA4NTcwIC9OIDEgL1QgODU2OSA+PgplbmRvYmoKICAgI+
       PgpzdHJlYW0KeJxjYgACJkbFKgYAAYMAoQplbmRzdHJlYW0KZW5k
       ICAgICAgICAgICAgIApzdGFydHhyZWYKMjE2CiUlRU9GCg=="
    ]);
    
    expect($ccb)
      ->json()
      ->toHaveKeys(['success', 'message'])
      ->success->toBeTrue()
      ->message->toBe('OK');
});

it('Should not upload the debtor file if the file type is incorrect', function () 
{
    $ccb_list = $this->grafeno->ccb()->listCCB();
    $ccb_data = json_decode($ccb_list);
    $uuid = $ccb_data->data[0]->id;

    $ccb = $this->grafeno->ccb()->uploadDebtorFiles($uuid, [
      "type" => "incorrect_file_type",
      "fileName" => "social_contract_file.pdf",
      "file" => "JVBERi0xLjUKJb/3ov4KMiAwIG9iago8PCAvTGluZW
      L08gNiAvRSA4NTcwIC9OIDEgL1QgODU2OSA+PgplbmRvYmoKICAgI+Pgpzd
      HJlYW0KeJxjYgACJkbFKgYAAYMAoQplbmRzdHJlYW0KZW5k
      ICAgICAgICAgICAgIApzdGFydHhyZWYKMjE2CiUlRU9GCg=="
    ]);
              
    $this->assertStringContainsString("não está incluído na lista", $ccb);
});

it('Should send the CCB to analysis', function () 
{
    $ccb_list = $this->grafeno->ccb()->listCCB();
    $ccb_data = json_decode($ccb_list);
    $uuid = $ccb_data->data[0]->id;

    $ccb = $this->grafeno->ccb()->sendCCBToAnalysis($uuid);

    expect($ccb)
      ->json()
      ->data->id->toBe($uuid)
      ->data->attributes->status->toBe("Enviado para análise");
});

it('Should cancel the CCB', function () 
{ 
    $ccb_list = $this->grafeno->ccb()->listCCB();
    $ccb_data = json_decode($ccb_list);
    $uuid = $ccb_data->data[0]->id;

    $ccb = $this->grafeno->ccb()->deleteCCB($uuid);

    expect($ccb)
      ->json()
      ->data->id->toBe($uuid)
      ->data->attributes->status->toBe("Cancelado");
});

it('Should return a instance of CCB class', function () 
{
    $ccb_class = $this->grafeno->ccb();
      
    expect($ccb_class)->toBeInstanceOf(CCB::class);
});
