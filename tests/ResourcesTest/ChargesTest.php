<?php

use Grafeno\Grafeno;
use Grafeno\Helpers\Filters;
use Grafeno\Resources\Charges;

it('Should create a charge', function () 
{
    $new_charge = $this->grafeno->charges()->createCharge([
        'boleto'=> [
          'yourNumber'=> '000001',
          'registrationMethod'=> 'online'
        ],
        'paymentMethod'=> 'boleto',
        'value'=> '251.11',
        'payer'=> [
          'name'=> 'Teste Cob LTDA ',
          'address'=> [
            'number'=> '1355',
            'zipCode'=> '01452011',
            'city'=> 'SÃO PAULO',
            'street'=> 'Av Brigadeiro Faria Lima',
            'neighborhood'=> 'Jardim Paulistano',
            'state'=> 'SP',
            'complement'=> ''
          ],
          'documentNumber'=> '12345679891',
          'email'=> '00001@grafeno-test.digital'
        ],
        'dueDate'=> '2022-12-31',
        'charge'=> [
          'value'=> '251.11'
        ]
    ]);

    expect($new_charge)
      ->json()
      ->data->uuid->toBeString()
      ->message->toBe('OK');
});

it('Should not create a charge without due date', function () 
{
    $new_charge = $this->grafeno->charges()->createCharge([
        'boleto'=> [
          'yourNumber'=> '000001',
          'registrationMethod'=> 'online'
        ],
          'paymentMethod'=> 'boleto',
          'value'=> '251.11',
          'payer'=> [
            'name'=> 'Teste Cob LTDA ',
            'address'=> [
              'number'=> '1355',
              'zipCode'=> '01452011',
              'city'=> 'SÃO PAULO',
              'street'=> 'Av Brigadeiro Faria Lima',
              'neighborhood'=> 'Jardim Paulistano',
              'state'=> 'SP',
              'complement'=> ''
            ],
            'documentNumber'=> '12345679891',
            'email'=> '00001@grafeno-test.digital'
          ],
          'charge'=> [
            'value'=> '251.11'
          ]
      ]);

  $response = $new_charge;
  $this->assertStringContainsString('Data de Vencimento não pode ficar em branco, Data de Vencimento não é uma data válida', $response);
});

it('Should get a charge', function () 
{
    $charges = $this->grafeno->charges()->listCharges();
    $response = json_decode($charges);
    $charge_uuid = $response->data[0]->uuid;

    $charge = $this->grafeno->charges()->getCharge($charge_uuid);

    $charge_data = json_decode($charge);
    $uuid = $charge_data->data->uuid;

    expect($uuid)
      ->toBe($charge_uuid);
});

it('Should list charges', function () 
{
    $charges = $this->grafeno->charges()->listCharges();

    expect($charges)
      ->json()
      ->toHaveKeys(['data', 'pagination'])
      ->data->toBeArray()
      ->pagination->total_count->toBeGreaterThanOrEqual(0);
});

it('Should update a charge', function () 
{   
    $today = date('Y-m-d');
    $filters = new Filters();
    $filter = $filters->applyFilter(Filters::CREATED_AT_EQ, $today);

    $new_date = strtotime("3 weeks");
    $new_date = date('Y-m-d', $new_date);

    $charges = $this->grafeno->charges()->listCharges(null, null, $filter);
    $response = json_decode($charges);
    $charge_uuid = $response->data[0]->uuid;

    $new_charge = $this->grafeno->charges()->updateCharge($charge_uuid,
    [
      'dueDate'=> $new_date,
    ]);
    
    expect($new_charge)
      ->json()
      ->data->uuid->toBe($charge_uuid)
      ->success->toBeTrue()
      ->message->toBe('OK');
});

it('Should not protest a charge that has not expired yet', function () 
{ 
    $today = date('Y-m-d');
    $filters = new Filters();
    $filter = $filters->applyFilter(Filters::CREATED_AT_EQ, $today);

    $charges = $this->grafeno->charges()->listCharges(null, null, $filter);
    $response = json_decode($charges);
    $charge_uuid = $response->data[0]->uuid;

    $charge = $this->grafeno->charges()->protestCharge($charge_uuid);
    $response = $charge;

    $this->assertStringContainsString('Não foi possível criar o protesto: Cobrança não está vencida', $response);
});

it('Should not cancel a protest that not exists', function () 
{
    $today = date('Y-m-d');
    $filters = new Filters();
    $filter = $filters->applyFilter(Filters::CREATED_AT_EQ, $today);

    $charges = $this->grafeno->charges()->listCharges(null, null, $filter);
    $response = json_decode($charges);
    $charge_uuid = $response->data[0]->uuid;

    $charge = $this->grafeno->charges()->cancelProtestCharge($charge_uuid);
    $response = $charge;

    $this->assertStringContainsString('Protesto não encontrado', $response);
});

it('Should not delete a charge created in bank slip method', function () 
{
    $charges = $this->grafeno->charges()->listCharges();
    $response = json_decode($charges);
    $charge_uuid = $response->data[0]->uuid;

    $charge = $this->grafeno->charges()->deleteCharge($charge_uuid);
    $response = $charge;

    expect($charge)
      ->json()
      ->success->toBeFalse()
      ->message->toBe('Não é possível excluir cobranças com boletos.');
});

it('Should write off a charge', function () 
{
    $today = date('Y-m-d');
    $filters = new Filters();
    $filter = $filters->applyFilter(Filters::CREATED_AT_EQ, $today);

    $charges = $this->grafeno->charges()->listCharges(null, null, $filter);
    $response = json_decode($charges);
    $pointer = $response->data;
    $pointer_n = count($pointer) - 1;
    $charge_uuid = $response->data[$pointer_n]->uuid;

    $charge = $this->grafeno->charges()->writeOffCharge($charge_uuid);
  
    expect($charge)
      ->json()
      ->toHaveKeys(['data', 'message'])
      ->data->uuid->toBe($charge_uuid)
      ->message->toBe('OK');
});

it('Should list the CNAB files', function () 
{
    $cnab = $this->grafeno->charges()->listCNAB('2022-05-17');
    $response = json_decode($cnab);

    expect($response->data[0])
      ->toHaveKeys(['fileId', 'file', 'date', 'accountNumber', 'documentNumber', 'accountName', 'accountType'])
      ->fileId->toBeInt()
      ->file->toBeString();
});

it('Should return a instance of charges class', function () 
{
    $charges_class = $this->grafeno->charges();
      
    expect($charges_class)->toBeInstanceOf(Charges::class);
});
