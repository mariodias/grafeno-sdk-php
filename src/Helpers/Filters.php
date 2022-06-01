<?php

namespace Grafeno\Helpers;

/**
 * Class Filters.
 */
class Filters
{
    /**
     * Filter Created At or Equal.
     *
     * @const string
     */
    const CREATED_AT_EQ = 'createdAtEq';

    /**
     * Filter Created At, Greater than or Equal.
     *
     * @const string
     */
    const CREATED_AT_GT_EQ = 'createdAtGtEq';

    /**
     * Filter Created At, Less than or Equal.
     *
     * @const string
     */
    const CREATED_AT_LT_EQ = 'createdAtLtEq';

    /**
     * Filter Paid At or Equal.
     *
     * @const string
     */
    const PAID_AT_EQ = 'paidAtEq';

    /**
     * Filter Paid At, Greater than or Equal.
     *
     * @const string
     */
    const PAID_AT_GT_EQ = 'paidAtGtEq';

    /**
     * Filter Paid At, Less than or Equal.
     *
     * @const string
     */
    const PAID_AT_LT_EQ = 'paidAtLtEq';

    /**
     * Filter Status Equal.
     *
     * @const string
     */
    const STATE_EQ = 'stateEq';

    /**
     * Filter Payment Method Equal.
     *
     * @const string
     */
    const PAYMENT_METHOD_EQ = 'paymentMethodEq';

    /**
     * Filter Due Date Equal.
     *
     * @const string
     */
    const DUE_DATE_EQ = 'dueDateEq';

    /**
     * Filter Due Date Greater than or Equal.
     *
     * @const string
     */
    const DUE_DATE_GT_EQ = 'dueDateGtEq';

    /**
     * Filter Due Date Less than or Equal.
     *
     * @const string
     */
    const DUE_DATE_LT_EQ = 'dueDateLtEq';

    /**
     * Filter Your Number Equal.
     *
     * @const string
     */
    const YOUR_NUMBER_EQ = 'yourNumberEq';

    /**
     * Filter Receive At or Equal.
     *
     * @const string
     */
    const RECEIVE_AT_EQ = 'receivedAtEq';

    /**
     * Filter Receive At, Greater than or Equal.
     *
     * @const string
     */
    const RECEIVE_AT_GT_EQ = 'receivedAtGtEq';

    /**
     * Filter Receive At, Less than or Equal.
     *
     * @const string
     */
    const RECEIVE_AT_LT_EQ = 'receivedAtLtEq';

    /**
     * Filter Entry At, Greater than or Equal.
     *
     * @const string
     */
    const ENTRY_AT_GT_EQ = 'entryAtGtEq';


    /**
     * Set a filter.
     *
     * @param string $filter
     * @param string $value
     *
     * @return $filter
     */
    public function applyFilter($filter, $value)
    {
        return '['.$filter.']='.$value;
    }
}
