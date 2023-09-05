<?php
namespace App\Models;

use Crocodic\LaravelModel\Core\Model;

class CompaniesModel extends Model
{
    
	public $id;
	public $code;
	public $name;
	public $description;
	public $active;
	public $created_by;
	public $updated_by;
	public $created_at;
	public $updated_at;

}