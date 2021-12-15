<?php

return [

    /*
     *  Default template
     *  sleek , adminlte
     */

    'template' => env('ADMIN_TEMPLATE', 'sleek'),

    /*
     * Layout
     */

    'layout' => 'admin.templates.'.env('ADMIN_TEMPLATE', 'sleek').'.app',

    /*
     * Layout view path
     */

    'view_path' => 'admin.templates.'.env('ADMIN_TEMPLATE', 'sleek'),

    /*
     * Template dir
     * ltr, rtl
     */

    'template_dir' => env('ADMIN_TEMPLATE_DIR', 'ltr'),
];
