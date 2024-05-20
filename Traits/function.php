<?php

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
