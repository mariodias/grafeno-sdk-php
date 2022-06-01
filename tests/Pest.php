<?php

use Grafeno\Grafeno;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/
uses()
    ->beforeEach(function () 
  {
    $this->token = "21b14dc2-6e3e-42ad-9a11-6f1510710150.9skWV1_1HqljdnW2Y5ABzE3FIck";
    $this->account_number = "08124695-1";
    $this->grafeno = new Grafeno($this->token, $this->account_number, Grafeno::STAGING); 
})
    ->in('ResourcesTest/BankAccountsTest.php', 
         'ResourcesTest/BeneficiariesTest.php',
         'ResourcesTest/CCBTest.php',
         'ResourcesTest/ChargesTest.php',
         'ResourcesTest/FiltersTest.php',
         'GrafenoTest.php');
