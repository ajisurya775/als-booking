<?php

if (!function_exists('statusOrder')) {
    function statusOrder($status)
    {
        $class = '';
        if ($status == 'Pending')
            $class = 'badge badge-warning';
        else if ($status == 'Paid')
            $class = 'badge badge-primary';
        else if ($status == 'Finish')
            $class = 'badge badge-success';
        else
            $class = 'badge badge-danger';

        return $class;
    }
}

if (!function_exists('status')) {
    function status($status)
    {
        $class = '';
        if ($status == 1)
            $class = 'badge badge-info';
        else
            $class = 'badge badge-danger';

        return $class;
    }
}

if (!function_exists('statusName')) {
    function statusName($status)
    {
        $statusName = '';
        if ($status == 1)
            $statusName = 'Active';
        else
            $statusName = 'Inactive';

        return $statusName;
    }
}

if (!function_exists('generateStartEndDateTemplateGraph')) {
    function generateStartEndDateTemplateGraph($startDate, $endDate)
    {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $end->modify('+1 day');
        $interval = new DateInterval('P1D');
        $dateRange = new DatePeriod($start, $interval, $end);

        $result = [];
        foreach ($dateRange as $date) {
            $result[$date->format("Y-m-d")] = 0;
        }

        return $result;
    }
}
