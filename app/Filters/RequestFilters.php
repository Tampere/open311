<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class RequestFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['service_code', 'start_date', 'end_date', 'status'];

    /**
     * Filter the query by service_code
     *
     * @param  string $service_code
     * @return Builder
     */
    protected function service_code($service_code)
    {
        return $this->builder->where('service_code', $service_code);
    }

    /**
     * Filter the query by start_date
     *
     * @param  string $start_date
     * @return Builder
     */
    protected function start_date($start_date)
    {
        return $this->builder->where('created_at', '>=', $start_date);
    }

    /**
     * Filter the query by end_date
     *
     * @param  string $end_date
     * @return Builder
     */
    protected function end_date($end_date)
    {
        return $this->builder->where('created_at', '<=', $end_date);
    }

    /**
     * Filter the query by status
     *
     * @param  string $status
     * @return Builder
     */
    protected function status($status)
    {
        return $this->builder->where('status', $status);
    }
}