<?php

use Grafeno\Grafeno;
use Grafeno\Resources\Transfers;

beforeEach(function () 
{
  $this->token = "YOUR-GRAFENO-TOKEN";
  $this->account_number = "YOUR-GRAFENO-ACCOUNT-NUMBER";
  $this->grafeno = new Grafeno($this->token, $this->accountNumber, Grafeno::DEV); 
});

it('Should create a transfer', function () 
{
    $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));

    $new_transfer = $this->grafeno->transfers()->createTransfer([
      'transfer_request' => [
        'value' => rand(10,100),
        'api_partner_transaction_uuid' => $uuid,
        'callback_url' => 'http://www.example.com/callback'
      ], 
      'beneficiary' => [
        'name' => 'Grafeno',
        'document_number' => '21.100.213/0001-65',
        'account' => '08124695-1',
        'agency' => '0001',
        'bank_code' => '274',
    ]
]);
  
    expect($new_transfer)
      ->json()
      ->toHaveKeys(['success', 'message'])
      ->success->toBeTrue()
      ->message->toBe('OK');
});

it('Should approve a transfer', function () 
{
    $transfers = $this->grafeno->transfers()->listTransfers();

    $transfer = json_decode($transfers);
    $transfer_uuid = $transfer->data[0]->api_partner_transaction_uuid;

    $transfer_to_approve = $this->grafeno->transfers()->updateTransfer($transfer_uuid, "approve", "Aprovada");

      expect($transfer_to_approve)
        ->json()
        ->toHaveKeys(['success', 'message'])
        ->success->toBeTrue()
        ->message->toBe("OK");
});

it('Should not approve or reject a transfer if the api_partner_transaction_uuid is not found', function () 
{
    $transfer_uuid = "12334456677889999009";

    $transfer_to_approve = $this->grafeno->transfers()->updateTransfer($transfer_uuid, "reject", "Rejeitada");
  
    $this->assertStringContainsString('Record Not Found', $transfer_to_approve);
});

it('Should list the transfers if has pending transfers', function () 
{
    $transfers = $this->grafeno->transfers()->listTransfers();
  
      expect($transfers)
        ->json()
        ->toHaveKeys(['data', 'pagination'])
        ->data->toBeArray()
        ->pagination->total_count->toBeGreaterThanOrEqual(0);
});

it('Should returns a instance of transfers class', function () 
{
    $transfers_class = $this->grafeno->transfers();
  
    expect($transfers_class)->toBeInstanceOf(Transfers::class);
});
