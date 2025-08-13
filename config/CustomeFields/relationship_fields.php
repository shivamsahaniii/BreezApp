
<?php

return [

    'accounts' => [
        [
            'field' => 'user_id',
            'relationship' => 'users',
            'type' => 'belongsToMany',
            'pivot' => true,
        ],
    ],

    'contacts' => [
        [
            'field' => 'account_id',
            'relationship' => 'accounts', // plural
            'type' => 'belongsToMany',    // treat as pivot
            'pivot' => true
        ],
        [
            'field' => 'user_id',
            'relationship' => 'users',
            'type' => 'belongsToMany',
            'pivot' => true
        ],
    ],

    'leads' => [
        [
            'field' => 'user_id',
            'relationship' => 'users',
            'type' => 'belongsToMany',
            'pivot' => true,
        ],
        [
            'field' => 'product_ids',
            'relationship' => 'products',
            'type' => 'belongsToMany',
            'pivot' => true,
        ],
    ],

    'products' => [
        [
            'field' => 'user_id',
            'relationship' => 'users',
            'type' => 'belongsToMany',
            'pivot' => true,
        ],
        [
            'field' => 'lead_id',
            'relationship' => 'leads',
            'type' => 'belongsToMany',
            'pivot' => true,
        ],
    ],

];