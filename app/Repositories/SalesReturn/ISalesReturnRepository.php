<?php

namespace App\Repositories\SalesReturn;

interface ISalesReturnRepository {
    public function getSalesReturn($where);
    public function get_salesreturn_items($sales_return_id );
}