<?php

use Grafeno\Grafeno;
use Grafeno\Helpers\Filters;

it('Should return a filter', function () 
{
    $filters = new Filters();
    $filter = $filters->applyFilter(Filters::CREATED_AT_EQ, '2019-01-01');

    expect($filter)
      ->toBe('[createdAtEq]=2019-01-01');
});

it('Should return a instance of filters class', function () 
{
    $filters_class = new Filters();

    expect($filters_class)
      ->toBeInstanceOf(Filters::class);
});


