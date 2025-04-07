<?php
return[
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'dashboard.',
        'title'=>'dashboard',
        'active'=>'dashboard.',
        'ability'=>'dashboard'
    ],
    [
        'icon'=>'nav-icon fas fa-th',
        'route'=>'dashboard.departments.index',
        'title'=>'departments',
        'active'=>'dashboard.departments.*',
        'ability'=>'department.view'

    ],
    [
        'icon'=>'fas fa-shopping-cart',
        'route'=>'dashboard.stores.index',
        'title'=>'stores',
        'active'=>'dashboard.stores.*',
        'ability'=>'store.view'

    ],
    [
        'icon'=>'fas fa-tags nav-icon',
        'route'=>'dashboard.categories.index',
        'title'=>'categories',
        'active'=>'dashboard.categories.*',
        'ability'=>'category.view'

    ],
    [
        'icon'=>'fas fa-box nav-icon',
        'route'=>'dashboard.products.index',
        'title'=>'products',
        'active'=>'dashboard.products.*',
        'ability'=>'product.view'

    ],
    [
        'icon'=>'fas fa-receipt nav-icon',
        'route'=>'dashboard.orders.index',
        'title'=>'orders',
        'active'=>'dashboard.orders.*',
        'ability'=>'order.view'

    ],
    [
        'icon'=>'fas fa-receipt nav-icon',
        'route'=>'dashboard.roles.index',
        'title'=>'roles',
        'active'=>'dashboard.roles.*',
        'ability'=>'role.view'

    ],
    [
        'icon'=>'fas fa-users nav-icon',
        'route'=>'dashboard.admins.index',
        'title'=>'admins',
        'active'=>'dashboard.admins.*',
        'ability'=>'admin.view'

    ],
    [
        'icon'=>'fas fa-users nav-icon',
        'route'=>'dashboard.users.index',
        'title'=>'users',
        'active'=>'dashboard.users.*',
        'ability'=>'user.view'

    ],

];
