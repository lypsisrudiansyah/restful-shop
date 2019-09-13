<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        // whereHas Fungsinya untuk Mengecek apakah tersedia 1 transaksi dari transaki-transaksi dari suatu kategori
        $transactions = $category->products()->whereHas('transactions')->with('transactions')->get()->pluck('transactions')->collapse();

        return $this->showAll($transactions);   
    }

}
