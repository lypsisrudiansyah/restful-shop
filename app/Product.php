<?php

namespace App;

use App\Category;
use App\Seller;
use App\Transaction;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;
	protected $dates =['deleted_at'];
	protected $hidden = [
        'pivot'
    ];
	
	const AVAILABLE_PRODUCT = 'available';
	const UNAVAILABLE_PRODUCT = 'unavailable';

	public $transformer = ProductTransformer::class;
	protected $table = 'products';

	protected $fillable = [
		'name',
		'description',
		'quantity',
		'status',
		'image',
		'seller_id',
	];

	public function isAvailable()
	{
		return $this->status == Product::AVAILABLE_PRODUCT;
	}

	public function seller()
	{
		return $this->belongsTo(Seller::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class);
	}
}
