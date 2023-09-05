<?php
namespace App\Models;

use Crocodic\LaravelModel\Core\Model;

class GoodsModel extends Model
{
    
	public $id;
	public $code;
	public $name;
	public $price;
	public $stock;
	public $description;
	public $active;
	public $created_by;
	public $updated_by;
	public $created_at;
	public $updated_at;

}