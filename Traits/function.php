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
