<?php

return [

    // -------------------- ACCOUNTS --------------------
    'accounts' => [
        [
            'name' => 'profile',
            'type' => 'file',
            'label' => 'Profile Image',
            'required' => false,
        ],
        [
            'name' => 'name',
            'type' => 'text',
            'label' => 'Account Name',
            'required' => true,
            'placeholder' => 'Enter account name',
        ],
        [
            'name' => 'industry',
            'type' => 'text',
            'label' => 'Industry',
            'required' => false,
            'placeholder' => 'Industry type (optional)',
        ],
        [
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email',
            'required' => true,
            'placeholder' => 'Enter email address',
        ],
        [
            'name' => 'phone',
            'type' => 'text',
            'label' => 'Phone Number',
            'required' => true,
            'placeholder' => 'Enter phone number',
        ],
        [
            'name' => 'website',
            'type' => 'text',
            'label' => 'Website',
            'required' => false,
            'placeholder' => 'Website URL (optional)',
        ],
        [
            'name' => 'address',
            'type' => 'textarea',
            'label' => 'Address',
            'required' => false,
            'placeholder' => 'Full address',
        ],
        [
            'name' => 'user_id',
            'type' => 'select',
            'label' => 'Created By',
            'required' => true,
            'options' => [], // Inject in controller
            'readonly' => true, // custom flag to make it readonly/disabled
            'relationship' => 'users'
        ],
        [
            'name' => 'action',
            'label' => 'Action',
        ],
    ],

    // -------------------- CONTACTS --------------------
    'contacts' => [
        [
            'name' => 'profile',
            'type' => 'file',
            'label' => 'Profile Image',
            'required' => false,
        ],
        [
            'name' => 'first_name',
            'type' => 'text',
            'label' => 'First Name',
            'required' => true,
            'placeholder' => 'Enter first name',
        ],
        [
            'name' => 'last_name',
            'type' => 'text',
            'label' => 'Last Name',
            'required' => true,
            'placeholder' => 'Enter last name',
        ],
        [
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email',
            'required' => true,
            'placeholder' => 'Enter email address',
        ],
        [
            'name' => 'phone',
            'type' => 'text',
            'label' => 'Phone',
            'required' => true,
            'placeholder' => 'Enter phone number',
        ],
        [
            'name' => 'position',
            'type' => 'text',
            'label' => 'Position',
            'required' => true,
            'placeholder' => 'Job title or position',
        ],
        [
            'name' => 'notes',
            'type' => 'textarea',
            'label' => 'Notes',
            'required' => false,
            'placeholder' => 'Additional notes about the contact',
        ],
        [
            'name' => 'account_id',
            'type' => 'select',
            'label' => 'Associated Account',
            'required' => true,
            'options' => [], // Inject from controller
            'relationship' => 'accounts',
        ],
        [
            'name' => 'user_id',
            'type' => 'select',
            'label' => 'Created By',
            'required' => true,
            'options' => [], // Inject from controller
            'relationship' => 'users',
        ],
        [
            'name' => 'action',
            'label' => 'Action',
        ],
    ],

    // -------------------- LEADS --------------------
    'leads' => [
        [
            'name' => 'profile',
            'type' => 'file',
            'label' => 'Profile Image',
            'required' => false,
        ],
        [
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
            'required' => true,
            'placeholder' => 'Enter name',
        ],
        [
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email',
            'required' => true,
            'placeholder' => 'Enter email address',
        ],
        [
            'name' => 'phone',
            'type' => 'text',
            'label' => 'Phone',
            'required' => true,
            'placeholder' => 'Enter phone number',
        ],
        [
            'name' => 'source',
            'type' => 'text',
            'label' => 'Source',
            'required' => true,
            'placeholder' => 'Source of the lead (e.g. website, referral)',
        ],
        [
            'name' => 'status',
            'type' => 'select',
            'label' => 'Status',
            'required' => true,
            'options' => [
                'new' => 'New',
                'contacted' => 'Contacted',
                'qualified' => 'Qualified',
                'lost' => 'Lost',
            ],
        ],
        [
            'name' => 'message',
            'type' => 'textarea',
            'label' => 'Message',
            'required' => false,
            'placeholder' => 'Additional notes or message',
        ],
        [
            'name' => 'user_id',
            'type' => 'select',
            'label' => 'Created By',
            'required' => true,
            'options' => [], // Inject in controller
            'relationship' => 'users'
        ],
        [
            'name' => 'product_ids', // Use plural for multi-select
            'type' => 'select-multiple',
            'label' => 'Associated Products',
            'required' => false,
            'options' => [], // Will be injected from controller
            'relationship' => 'products',
        ],
        [
            'name' => 'action',
            'label' => 'Action',
        ],
    ],

    'products' => [
        [
            'name' => 'name',
            'type' => 'text',
            'label' => 'Product Name',
            'required' => true,
            'placeholder' => 'Enter product name',
        ],
        [
            'name' => 'description',
            'type' => 'textarea',
            'label' => 'Description',
            'required' => false,
            'placeholder' => 'Write short description',
        ],
        [
            'name' => 'price',
            'type' => 'text',
            'label' => 'Price',
            'required' => false,
            'placeholder' => 'Enter product price',
        ],
    ],

    'user_profile' => [
        [
            'name' => 'phone',
            'type' => 'text',
            'label' => 'Phone Number',
            'required' => false,
        ],
        [
            'name' => 'profile_image',
            'type' => 'file',
            'label' => 'Profile Image',
            'required' => false,
        ],
        [
            'name' => 'bio',
            'type' => 'textarea',
            'label' => 'Bio',
            'required' => false,
        ],
        [
            'name' => 'address',
            'type' => 'textarea',
            'label' => 'Address',
            'required' => false,
            'placeholder' => 'Enter full address',

        ],
        [
            'name' => 'linkedin_url',
            'type' => 'text',
            'label' => 'LinkedIn URL',
            'required' => false,
        ],
    ]
];
