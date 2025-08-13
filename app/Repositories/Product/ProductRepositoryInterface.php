<?php
namespace App\Repositories\Product;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function getTableViewData(bool $trashed = false): array;

    public function getDataTable(Request $request, bool $isTrashed = false);
}