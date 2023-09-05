<?php
namespace App\Models;

use Crocodic\LaravelModel\Core\Model;

class TransactionDetailsModel extends Model
{
    
	public $id;
	public $transaction_id;
	public $good_id;
	public $qty;
	public $total;
	public $description;
	public $active;
	public $created_by;
	public $updated_by;
	public $created_at;
	public $updated_at;

	public function good() {
        return $this->belongsTo("App\Models\GoodsModel", 'id', 'good_id');
    }

}