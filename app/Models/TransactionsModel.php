<?php
namespace App\Models;

use Crocodic\LaravelModel\Core\Model;

class TransactionsModel extends Model
{
    
	public $id;
	public $date;
	public $company_id;
	public $total;
	public $description;
	public $active;
	public $created_by;
	public $updated_by;
	public $created_at;
	public $updated_at;

	public function company() {
        return $this->belongsTo("App\Models\CompaniesModel", 'id','company_id');
    }
}