<?php

namespace App\Repositories\Product;

use App\Models\Product\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
    public function getTableViewData(bool $trashed = false): array
    {
        return [
            'headers' => config('CustomeFields.form_fields.products'),
            'routeBase' => 'products',
            'isTrash' => $trashed,
        ];
    }

    public function getDataTable(Request $request, bool $isTrashed = false)
    {
        $query = $isTrashed
            ? Product::onlyTrashed()->select('products.*')
            : Product::select('products.*');

        return DataTables::of($query)->make(true);
    }
}