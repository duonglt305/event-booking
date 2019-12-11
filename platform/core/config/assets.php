<?php

return [
    'offline' => env('ASSETS_OFFLINE', true),
    'enable_version' => env('ASSETS_ENABLE_VERSION', false),
    'version' => env('ASSETS_VERSION', time()),
    'scripts' => [
        'block-UI-js'
    ],
    'styles' => [
    ],
    'resources' => [
        'scripts' => [
            'vendor-bundle-base-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/js/vendor.bundle.base.js',
                ],
            ],
            'vendor-bundle-addons-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/js/vendor.bundle.addons.js',
                ],
            ],
            'off-canvas-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/js/off-canvas.js',
                ],
            ],
            'hoverable-collapse-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/js/hoverable-collapse.js',
                ],
            ],
            'misc-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/js/misc.js',
                ],
            ],
            //datatable
            'datatables-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/datatables/datatables.js',
                    'cnd' => '//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js',
                ],
            ],
            'dataTables-buttons-js' => [
                'use_cnd' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/datatables/extensions/buttons/js/dataTables.buttons.js'
                ]
            ],
            'buttons-bootstrap4-js' => [
                'use_cnd' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/datatables/extensions/buttons/js/buttons.bootstrap4.js'
                ]
            ],
            'buttons-flash-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/datatables/extensions/buttons/js/buttons.flash.js'
                ]
            ],
            'buttons-print-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/datatables/extensions/buttons/js/buttons.print.js'
                ]
            ],
            'buttons-html5-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/datatables/extensions/buttons/js/buttons.html5.js'
                ]
            ],
            'buttons-colVis-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/datatables/extensions/buttons/js/buttons.colVis.js'
                ]
            ],
            'jszip-min-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/datatables/extensions/buttons/js/jszip.min.js'
                ]
            ],
            'pdfmake-min-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/datatables/extensions/buttons/js/pdfmake.min.js'
                ]
            ],
            'vfs_fonts-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/datatables/extensions/buttons/js/vfs_fonts.js'
                ]
            ],
            //datatable
            'block-UI-js' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/admin/vendors/blockUI/jquery.blockUI.js'
                ]
            ],
        ],
        'styles' => [
            'materialdesignicons-min-css' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/admin/vendors/iconfonts/mdi/css/materialdesignicons.min.css'
                ],
            ],
            'feather-css' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/admin/vendors/iconfonts/puse-icons-feather/feather.css'
                ],
            ],
            'vendor-bundle-base-css' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/admin/vendors/css/vendor.bundle.base.css'
                ],
            ],
            'vendor-bundle-addons-css' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/admin/vendors/css/vendor.bundle.addons.css'
                ],
            ],
            'style-css' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/admin/css/style.css'
                ],
            ],
            'layouts-css' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/admin/css/layouts.css'
                ],
            ],
            'datatables-css' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/admin/vendors/datatables/datatables.css',
                    'cnd' => 'http://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css'
                ],
            ],
            'tables-css' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/css/table.css',
                ],
            ],
            'buttons-bootstrap4-css' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/admin/vendors/datatables/extensions/buttons/css/buttons.bootstrap4.css'
                ]
            ],
            'buttons-dataTables-css' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/admin/vendors/datatables/extensions/buttons/css/buttons.dataTables.css'
                ]
            ],
        ],
    ],
];
