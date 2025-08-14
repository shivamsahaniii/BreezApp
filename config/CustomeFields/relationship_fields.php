<?php

use App\Models\Account\Account;
use App\Models\Contact\Contact;
use App\Models\Lead\Lead;
use App\Models\Product\Product;
use App\Models\User;

return [

    'accounts' => [
        'users' => [
            'type' => 'belongsToMany',
            'model' => User::class,
            'pivot_table' => 'account_user',
            'foreign_key' => 'account_id',
            'related_key' => 'user_id',
        ],
        'contacts' => [
            'type' => 'belongsToMany',
            'model' => Contact::class,
            'pivot_table' => 'account_contact',
            'foreign_key' => 'account_id',
            'related_key' => 'contact_id',
        ],
    ],

    'contacts' => [
        'accounts' => [
            'type' => 'belongsToMany',
            'model' => Account::class,
            'pivot_table' => 'account_contact',
            'foreign_key' => 'contact_id',
            'related_key' => 'account_id',
        ],
        'users' => [
            'type' => 'belongsToMany',
            'model' => User::class,
            'pivot_table' => 'contact_user',
            'foreign_key' => 'contact_id',
            'related_key' => 'user_id',
        ],
    ],

    'leads' => [
        'users' => [
            'type' => 'belongsToMany',
            'model' => User::class,
            'pivot_table' => 'lead_user',
            'foreign_key' => 'lead_id',
            'related_key' => 'user_id',
        ],
        'products' => [
            'type' => 'belongsToMany',
            'model' => Product::class,
            'pivot_table' => 'lead_product',
            'foreign_key' => 'lead_id',
            'related_key' => 'product_id',
        ],
    ],

    'products' => [
        'users' => [
            'type' => 'belongsToMany',
            'model' => User::class,
            'pivot_table' => 'product_user',
            'foreign_key' => 'product_id',
            'related_key' => 'user_id',
        ],
        'leads' => [
            'type' => 'belongsToMany',
            'model' => Lead::class,
            'pivot_table' => 'lead_product',
            'foreign_key' => 'product_id',
            'related_key' => 'lead_id',
        ],
    ],

];
