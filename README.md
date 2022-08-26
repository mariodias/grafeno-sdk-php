## Index

 > Statistics

  [![Total Downloads](https://poser.pugx.org//mariosergiodias/grafeno-sdk-php-2022/downloads)](https://packagist.org/packages//mariosergiodias/grafeno-sdk-php-2022)
  [![Monthly Downloads](https://poser.pugx.org/mariosergiodias/grafeno-sdk-php-2022/d/monthly)](https://packagist.org/packages/mariosergiodias/grafeno-sdk-php-2022)

  > Versions

  [![Latest Stable Version](https://poser.pugx.org/mariosergiodias/grafeno-sdk-php-2022/v/stable)](https://packagist.org/packages/mariosergiodias/grafeno-sdk-php-2022)
  [![Latest Unstable Version](https://poser.pugx.org//mariosergiodias/grafeno-sdk-php-2022/v/unstable)](https://packagist.org/packages/mariosergiodias/grafeno-sdk-php-2022)

  ---
</p>


- [Instalação](#instalação)
- [Autenticação e definição do ambiente](#autenticação-e-definição-do-ambiente)
- [Contas](#contas)
  - [Listar contas bancárias](#listar-contas-bancárias)
  - [Listar movimentações da conta](#listar-movimentações-da-conta)
- [Cobranças](#cobranças)
  - [Criar uma cobrança](#criar-uma-cobrança)
  - [Consultar uma cobrança](#consultar-uma-cobrança)
  - [Listar todas as cobranças](#listar-todas-as-cobranças)
  - [Atualizar uma cobrança](#atualizar-uma-cobrança)
  - [Dar baixa em uma cobrança](#dar-baixa-em-uma-cobrança)
  - [Cancelar cobrança](#cancelar-cobrança)
  - [Protestar cobrança](#protestar-cobrança)
  - [Cancelar protesto](#cancelar-protesto)
  - [Listar CNAB](#listar-cnab)
- [Beneficiários](#beneficiários)
  - [Adicionar beneficiário](#adicionar-beneficiário)
  - [Listar beneficiários](#listar-beneficiários)
- [Transferências](#transferências)
  - [Criar transferência](#criar-transferência)
  - [Listar transferências pendentes](#listar-transferências-pendentes)
  - [Aprovar ou Rejeitar transferências](#aprovar-ou-rejeitar-transferências)
- [CCB](#CCB)
  - [Listar credores](#listar-credores)
  - [Simular CCB](#simular-ccb)
  - [Criar CCB](#criar-ccb)
  - [Visualizar CCB](#visualizar-ccb)
  - [Listar CCBs](#listar-ccbs)
  - [Atualizar CCB](#atualizar-ccb)
  - [Criar ou atualizar o devedor da CCB](#criar-ou-atualizar-o-devedor-da-ccb)
  - [Criar ou atualizar o avalista da CCB](#criar-ou-atualizar-o-avalista-da-ccb)
  - [Enviar arquivos do devedor da CCB](#enviar-arquivos-do-devedor-da-ccb)
  - [Enviar arquivos do avalista da CCB](#enviar-arquivos-do-avalista-da-ccb)
  - [Enviar CCB para análise](#enviar-ccb-para-análise)
  - [Cancelar CCB](#cancelar-ccb)
- [Filtros](#filtros)
  - [Filtros disponíveis](#filtros-disponíveis)
  - [Aplicando filtros](#aplicando-filtros)
- [Suporte](#suporte)
- [Contribua](#contribua)
- [Licença](#Licença)
- [Changelog](#changelog)

## Instalação
Execute o comando abaixo para instalar via [Composer](https://getcomposer.org/):

```SHELL
> composer require mariodias/grafeno-sdk-php
```

## Autenticação e definição do ambiente

A autenticação na API Grafeno é feita através do seu Token de acesso e do número de sua conta, [clique aqui](https://docs.grafeno.digital/reference/autentica%C3%A7%C3%A3o) para obter informações sobre a sua autenticação.

```PHP
require 'vendor/autoload.php';
use Grafeno\Grafeno;

$token = "11111111-2222-3333-4444-555555555555.9aaBBB_CCCCC12345678";
$account_number = "08888888-1";

$grafeno = new Grafeno($token, $account_number, Grafeno::STAGING);
```

## Contas

O recurso contas permite a listagem de todas as contas vinculadas à sua conta Grafeno além de permitir a consulta de todas as movimentações destas contas, tornando a sua conciliação mais simples e dinâmica.

Para obter mais informações sobre este recurso, visite nossa documentação: [Contas](https://docs.grafeno.digital/reference/1-contas)

#### Listar contas bancárias
```PHP
$bank_accounts = $grafeno->bankAccounts()->listBankAccounts();

print_r($bank_accounts);
```

#### Listar movimentações da conta
```PHP
$bank_accounts_transactions = $grafeno->bankAccounts()->listBankAccountTransactions();

print_r($bank_accounts_transactions);
```

## Cobranças

Com a API de cobranças Grafeno, é possível emitir cobranças com as formas de pagamento Boleto Bancário e TED, além de ser possível editar as cobranças criadas e enviar para protesto as cobranças que não foram pagas.

Para obter mais informações sobre este recurso, visite nossa documentação: [Cobranças](https://docs.grafeno.digital/reference/2-cobran%C3%A7as)

#### Criar uma cobrança
```PHP
$new_charge = $grafeno->charges()->createCharge(
                [
                    'boleto'=> [
                      'yourNumber'=> '000001',
                      'registrationMethod'=> 'online'
                    ],
                    'paymentMethod'=> 'boleto',
                    'value'=> '251.11',
                    'payer'=> [
                      'name'=> 'Dwight Schrute',
                      'address'=> [
                        'number'=> '1355',
                        'zipCode'=> '01452011',
                        'city'=> 'São Paulo',
                        'street'=> 'Av Brigadeiro Faria Lima',
                        'neighborhood'=> 'Jardim Paulistano',
                        'state'=> 'SP',
                        'complement'=> 'Schrute Farms'
                      ],
                      'documentNumber'=> '12345679891',
                      'email'=> 'dwight@dundermifflin.com'
                    ],
                    'dueDate'=> '2022-10-12'
                ]);

print_r($new_charge);
```

#### Consultar uma cobrança
```PHP
$charge = $grafeno->charges()->getCharge("3806513a-ab67-4314-ad4f-45d293d6851b");

print_r($charge);
```

#### Listar todas as cobranças
```PHP
$page = 1;
$per_page = 50;

$charges = $grafeno->charges()->listCharges($page, $per_page);

print_r($charges);
```

#### Atualizar uma cobrança
```PHP
$charge = $grafeno->charges()->updateCharge("3806513a-ab67-4314-ad4f-45d293d6851b",
                   [
                    'dueDate'=> '2023-12-31',                    ]
                   ]);

print_r($charge);
```

#### Dar baixa em uma cobrança
```PHP
$charge_paid = $grafeno->charges()->writeOffCharge("3806513a-ab67-4314-ad4f-45d293d6851b");

print_r($charge_paid);
```

#### Cancelar cobrança
```PHP
$charge_cancelled = $grafeno->charges()->deleteCharge("3806513a-ab67-4314-ad4f-45d293d6851b");

print_r($charge_cancelled);
```

#### Protestar cobrança
```PHP
$charge_protest = $grafeno->charges()->protestCharge("3806513a-ab67-4314-ad4f-45d293d6851b");

print_r($charge_protest);
```

#### Cancelar protesto
```PHP
$charge_protest = $grafeno->charges()->cancelProtestCharge("3806513a-ab67-4314-ad4f-45d293d6851b");

print_r($charge_protest);
```

#### Listar CNAB
```PHP
$cnab = $grafeno->charges()->listCNAB("2022-04-12");

print_r($cnab);
```

## Beneficiários

O recurso beneficiários possibilita o cadastro e visualização de contas bancárias beneficiárias em sua conta Grafeno.

Para obter mais informações sobre este recurso, visite nossa documentação: [Beneficiários](https://docs.grafeno.digital/reference/3-benefici%C3%A1rios)

#### Adicionar beneficiário
```PHP
$beneficiario = $grafeno->beneficiaries()->createBeneficiary(
[
   "beneficiary" => [
      "uuid" => "d81e6f9e-eb26-4b1d-a898-c8f4b3568f9d",
      "name" => "Teste",
      "document_number" => "12345679891",
      "agency" => "1234",
      "account" => "1234-5",
      "bank_code" => "341"
    ]
]);

print_r($beneficiario);
```

#### Listar beneficiários
```PHP
$page = 1;
$per_page = 50;

$beneficiarios = $grafeno->beneficiaries()->listBeneficiaries($page, $per_page);

print_r($beneficiarios);
```

## Transferências

A API de transferências possibilita a criação, listagem e aprovação ou rejeição de transferências.

Para obter mais informações sobre este recurso, visite nossa documentação: [Transferências](https://docs.grafeno.digital/reference/4-transfer%C3%AAncias)

#### Criar transferência
```PHP
$nova_transferência = $grafeno->transfers()->createTransfer(
[
   "transfer_request" => [
      "value" => "300.00",
      "api_partner_transaction_uuid" => "f3ec33ab-0d82-4e1a-a7e8-e759d6ae98df",
      "callback_url" => "http://www.my-url-to-callback.com/callback"
     ],
   "beneficiary"=> [
      "uuid" => "dad91a7a-6bc7-4be1-92c5-d7caf96453e0",
      "name"=> "Jim Halpert",
      "document_number" => "123.456.798-91",
      "bank_code" => "341",
      "agency" => "0199",
      "account" => "888888"
    ]
]);

print_r($nova_transferência);
```

#### Listar transferências pendentes
```PHP
$page = 1;
$per_page = 50;

$transferências = $grafeno->transfers()->listTransfers($page, $per_page);

print_r($transferências);
```

#### Aprovar ou Rejeitar transferências
```PHP
$transfer_uuid = "50d39ac7-bf44-408e-9358-19c2e9ea08f4";
$state = "approve";
$reject_reason = null;

$transfer_to_approve = $grafeno->transfers()->updateTransfer($transfer_uuid, $state, $reject_reason);

print_r($transfer_to_approve);
```

## CCB

Uma CCB é um ativo financeiro que representa uma dívida que só pode ser emitida por uma instituição financeira, ou seja, que é autorizada pelo Banco Central (BCB) a expedir este tipo de documento.

Através da API Grafeno é possível criar um CCB facilmente, além de ter um total controle sobre os pagamentos efetuados e as cédulas obtidas.

Para obter mais informações sobre este recurso, visite nossa documentação: [CCB]9https://docs.grafeno.digital/reference/5-ccb)

#### Listar credores
```PHP
$creditors = $grafeno->ccb()->listCCBCreditors();

print_r($creditors);
```

#### Simular CCB
```PHP
$net_value = "200000";
$monthly_interest = "5";
$installments = 36;
$first_due_date = "2022-12-05";

$simulate_ccb_values = $grafeno->ccb()->simulateCCB($net_value, $monthly_interest, $installments, $first_due_date);

print_r($simulate_ccb_values);
```

#### Criar CCB
```PHP
$ccb = $grafeno->ccb()->createCCB(
[
    "credorId" => "2fdc0f06-b424-4c79-91b4-965aadb11313",
    "valorLiquido" => "200000",
    "jurosMensal" => "5",
    "parcelas" => 36,
    "primeiraParcela" => "2022-12-05",
    "garantiaRecebiveis" => true
]);

print_r($ccb);
```

#### Visualizar CCB
```PHP
$ccb = $grafeno->ccb()->getCCB("ab2de14f-d372-4988-b73f-0ee483dcd096");

print_r($ccb);
```

#### Listar CCBs
```PHP
$ccbs = $grafeno->ccb()->listCCB();

print_r($ccbs);
```

#### Atualizar CCB
```PHP
$ccb_update = $grafeno->ccb()->updateCCB("ab2de14f-d372-4988-b73f-0ee483dcd096", 
          [
          "parcelas" => 24
           ]
         );

print_r($ccb_update);
```

#### Criar ou atualizar o devedor da CCB
```PHP
$debtor = $grafeno->ccb()->createOrUpdateCCBDebtor("ab2de14f-d372-4988-b73f-0ee483dcd096", 
  [
    "name" => "Andy Bernard",
    "documentNumber" => "55.054.861/0001-44",
    "phone" => "11999999999",
    "email" => "the-nard-dog@dcornell.edu",
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
    ]
);

print_r($debtor);
```

#### Criar ou atualizar o avalista da CCB
```PHP
$guarantor = $grafeno->ccb()->createOrUpdateCCBGuarantor("ab2de14f-d372-4988-b73f-0ee483dcd096", 
   [
    "name" => "Dwight Schrute",
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

print_r($guarantor);
```

#### Enviar arquivos do devedor da CCB
```PHP
$debtor_file = $grafeno->ccb()->uploadDebtorFiles("ab2de14f-d372-4988-b73f-0ee483dcd096", 
    [
      "type" => "social_contract_file",
      "fileName" => "social_contract_file.pdf",
      "file" => "JVBERi0xLjMKJcTl8uXrp/Og0MTGCjMgMCBvYmoKPDwgL0ZpbHRlciAvRmxhdGVEZWNvZGUgL0xlbmd0aCAxNzQgPj4Kc3RyZWFtCngBjZA7D8IwDI
      T3/IrjUSkZSBsnKekKYmGr5A0xVWJA6lDl/0ukL6AsVBkcW9Z95+tQo0N+jgZNRDG82KRRocmNff8xAT5YXRGaFieGHzdTIfLwpgK3ImcmGPADcqP
      AT1x4UF8t5SptS0+9nuAWH70b5FYlSw5yp3AotIHcz5NM4Q6+/qGJX+PWlfpIYXa/pL3FF7gJI/rI1h7l0lHelmYK6QsjMyXmkOoXXsBPNgplbm
      RzdHJlYW0KZW5kb2JqCjEgMCBvYmoKPDwgL1R5cGUgL1BhZ2UgL1BhcmVudCAyIDAgUiAvUmVzb3VyY2VzIDQgMCBSIC9Db250ZW50cyAzIDAgUiAvTWVka
      WFCb3ggWzAgMCA2MTIgNzky=="
     ]);

print_r($debtor_file);
```

#### Enviar arquivos do avalista da CCB
```PHP
$guarantor_file = $grafeno->ccb()->uploadGuarantorFiles("ab2de14f-d372-4988-b73f-0ee483dcd096", 
    [
      "guarantorId" => "71d2a275-9ac7-43c0-b35a-73722d05f38f",
      "type" => "identification_document_file",
      "fileName" => "identification_document_file.pdf",
      "file" => "JVBERi0xLjMKJcTl8uXrp/Og0MTGCjMgMCBvYmoKPDwgL0ZpbHRlciAvRmxhdGVEZWNvZGUgL0xlbmd0aCAxNzQgPj4Kc3RyZWFtCngBjZA7D8IwDI
      T3/IrjUSkZSBsnKekKYmGr5A0xVWJA6lDl/0ukL6AsVBkcW9Z95+tQo0N+jgZNRDG82KRRocmNff8xAT5YXRGaFieGHzdTIfLwpgK3ImcmGPADcqP
      AT1x4UF8t5SptS0+9nuAWH70b5FYlSw5yp3AotIHcz5NM4Q6+/qGJX+PWlfpIYXa/pL3FF7gJI/rI1h7l0lHelmYK6QsjMyXmkOoXXsBPNgplbm
      RzdHJlYW0KZW5kb2JqCjEgMCBvYmoKPDwgL1R5cGUgL1BhZ2UgL1BhcmVudCAyIDAgUiAvUmVzb3VyY2VzIDQgMCBSIC9Db250ZW50cyAzIDAgUiAvTWVka
      WFCb3ggWzAgMCA2MTIgNzky=="
     ]);

print_r($guarantor_file);
```

#### Enviar CCB para análise
```PHP
$ccb = $grafeno->ccb()->sendCCBToAnalysis("ab2de14f-d372-4988-b73f-0ee483dcd096");

print_r($ccb);
```

#### Cancelar CCB
```PHP
$ccb = $grafeno->ccb()->deleteCCB("ab2de14f-d372-4988-b73f-0ee483dcd096");

print_r($ccb);
```

## Filtros

A API Grafeno possui diversos filtros para determinar quais tipos de dados devem ser retornados nas consultas além de facilitar na filtragem de informações.

#### Filtros disponíveis

| Filtro | Descrição | Tipo | Formato | Recurso |
| --- | ----------- | ----------- | ----------- | ----------- |
| CREATED_AT_EQ | Created At or Equal | Data | YYYY-MM-DD | Cobranças |
| CREATED_AT_GT_EQ | Created At, Greater than or Equal | Data | YYYY-MM-DD | Cobranças |
| CREATED_AT_LT_EQ | Created At, Less than or Equal | Data | YYYY-MM-DD | Cobranças |
| PAID_AT_EQ | Paid At or Equal | Data | YYYY-MM-DD | Cobranças |
| PAID_AT_GT_EQ | Paid At, Greater than or Equal | Data | YYYY-MM-DD | Cobranças |
| PAID_AT_LT_EQ | Paid At, Less than or Equal | Data | YYYY-MM-DD | Cobranças |
| STATE_EQ | Status Equal | String | pending | Cobranças |
| PAYMENT_METHOD_EQ | Payment Method Equal | String | boleto | Cobranças |
| DUE_DATE_EQ | Due Date Equal | Data | YYYY-MM-DD | Cobranças |
| DUE_DATE_GT_EQ | Due Date Greater than or Equal | Data | YYYY-MM-DD | Cobranças |
| DUE_DATE_LT_EQ | Due Date Less than or Equal | Data | YYYY-MM-DD | Cobranças |
| YOUR_NUMBER_EQ | Your Number Equal | String | 12345-abcde | Cobranças |
| RECEIVE_AT_EQ | Receive At or Equal | Data | YYYY-MM-DD | Cobranças |
| RECEIVE_AT_GT_EQ | Receive At, Greater than or Equal | Data | YYYY-MM-DD | Cobranças |
| RECEIVE_AT_LT_EQ | Receive At, Less than or Equal | Data | YYYY-MM-DD | Cobranças |
| ENTRY_AT_GT_EQ | Entry At, Greater than or Equal | Data | YYYY-MM-DD | Contas |

#### Aplicando filtros
```PHP
use Grafeno\Helpers\Filters;

$filters = new Filters();

$filter = $filters->applyFilter(Filters::CREATED_AT_GT_EQ, '2022-05-17');

$charges = $grafeno->charges()->listCharges(null, null, $filter);

print_r($charges);
```


## Suporte

Aqui na Grafeno, queremos proporcionar uma experiência incrível para todos os perfis de clientes e parceiros que se relacionam conosco. Sabendo da necessidade de um atendimento mais técnico para resolver questões de integrações, oferecemos suporte através do nosso time de Developer Experience (DevX) através do email [integracao@grafeno.digital](mailto:integracao@grafeno.digital) e lá você poderá sanar eventuais dúvidas que surjam relacionadas as nossas APIs.

## Contribua

Este projeto existe graças a todas as pessoas que contribuem. :rocket: :rocket: :rocket: :rocket: :rocket: :rocket: <br> [[Clique aqui](CONTRIBUTING.md)] para acessar nossas diretrizes de contribuição.


## Licença

[The MIT License](https://github.com/mariodias/)

## Changelog

[SDK changelog](https://github.com/mariodias/)
