<?php
namespace App\Repositories;

use App\Models\TransactionDetailsModel;
use Illuminate\Support\Facades\DB;

class TransactionDetails extends TransactionDetailsModel
{
    // TODO : Make your own query methods
    public static function findAllByParentIdAndPaginate($parentId)
    {
        return DB::table('transaction_details')
            ->join('goods', 'goods.id', '=', 'transaction_details.good_id')
            ->select('transaction_details.*', 'goods.name as goods_name', 'goods.price as goods_price')
            ->where('transaction_id', $parentId)
            ->paginate(10);
    }

    public static function findAllProductByParentId($parentId)
    {
        return DB::table('transaction_details')
            ->join('goods', 'goods.id', '=', 'transaction_details.good_id')
            ->select('goods.id', 'goods.name')
            ->where('transaction_id', g('parent_id'))
            ->get();
    }
}