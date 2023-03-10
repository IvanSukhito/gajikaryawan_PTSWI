<?php
if ( ! function_exists('generateMenu')) {
    function generateMenu() {
        $html = '';
        $adminRole = session()->get('admin_role');
        if ($adminRole) {
            $role = \Illuminate\Support\Facades\Cache::remember('role'.$adminRole, env('SESSION_LIFETIME'), function () use ($adminRole) {
                return \App\Codes\Models\Role::where('id', '=', $adminRole)->first();
            });
            if ($role) {
                $permissionRoute = json_decode($role->permission_route, TRUE);
                $getRoute = \Illuminate\Support\Facades\Route::current()->action['as'];
                foreach (listGetPermission(listAllMenu(), $permissionRoute) as $key => $value) {
                    $active = '';
                    $class = '';
                    foreach ($value['active'] as $getActive) {
                        if (strpos($getRoute, $getActive) === 0) {
                            $active = ' active';
                        }
                    }
                    if (isset($value['inactive'])) {
                        foreach ($value['inactive'] as $getInActive) {
                            if (strpos($getRoute, $getInActive) === 0) {
                                $active = '';
                            }
                        }
                    }

                    if (in_array($value['type'], [2]) && strlen($active) > 0) {
                        $class .= ' nav-item has-treeview menu-open';
                        $extraLi = '<i class="right fa fa-angle-left"></i>';
                    }
                    else if (in_array($value['type'], [2])) {
                        $class .= ' nav-item has-treeview';
                        $extraLi = '<i class="right fa fa-angle-left"></i>';
                    }
                    else {
                        $class .= 'nav-item';
                        $extraLi = '';
                    }

                    if(isset($value['route'])) {
                        $route = route($value['route']);
                    }
                    else {
                        $route = '#';
                    }

                    $getIcon = isset($value['icon']) ? $value['icon'] : '';
                    $getAdditional = isset($value['additional']) ? $value['additional'] : '';
                    $html .= '<li class="'.$class.'">
                    <a href="'.$route.'" title="'.$value['name'].'" class="nav-link'.$active.'">
                    '.$getIcon.'
                    <p>'.
                        $value['title'].$extraLi.$getAdditional.'</p></a>';

                    if (in_array($value['type'], [2])) {
                        $html .= '<ul class="nav nav-treeview">';
                        $html .= getMenuChild($value['data'], $getRoute);
                        $html .= '</ul>';
                    }

                    $html .= '</a></li>';
                }
            }
        }
        return $html;
    }
}

if ( ! function_exists('getMenuChild')) {
    function getMenuChild($data, $getRoute) {
        $html = '';

        foreach ($data as $value) {
            $active = '';
            foreach ($value['active'] as $getActive) {
                if (strpos($getRoute, $getActive) === 0) {
                    $active = 'active';
                }
            }
            if (isset($value['inactive'])) {
                foreach ($value['inactive'] as $getInActive) {
                    if (strpos($getRoute, $getInActive) === 0) {
                        $active = '';
                    }
                }
            }

            if(isset($value['route'])) {
                $route = route($value['route']);
            }
            else {
                $route = '#';
            }

            $html .= '<li class="nav-item">
                    <a href="'.$route.'" class=" nav-link '.$active.'" title="'.$value['name'].'">
                    <i class="fa fa-circle-o nav-icon"></i><p>'.
                    $value['title'];
            $html .= '</p></a></li>';
        }

        return $html;
    }
}

if ( ! function_exists('getDetailPermission')) {
    function getDetailPermission($module, $permission = ['create' => false,'edit' => false,'show' => false,'destroy' => false]) {
        $adminRole = session()->get('admin_role');
        if ($adminRole) {
            $role = \Illuminate\Support\Facades\Cache::remember('role'.$adminRole, env('SESSION_LIFETIME'), function () use ($adminRole) {
                return \App\Codes\Models\Role::where('id', '=', $adminRole)->first();
            });
            if ($role) {
                $permissionData = json_decode($role->permission_data, TRUE);
                if( isset($permissionData[$module])) {
                    foreach ($permissionData[$module] as $key => $value) {
                        $permission[$key] = true;
                    }
                }
            }
        }
        return $permission;
    }
}

if ( ! function_exists('getValidatePermissionMenu')) {
    function getValidatePermissionMenu($permission) {
        $listMenu = [];
        if ($permission) {
            foreach ($permission as $key => $route) {
                if ($key == 'super_admin') {
                    $listMenu['super_admin'] = 1;
                }
                else {
                    if (is_array($route)) {
                        foreach ($route as $key2 => $route2) {
                            $listMenu[$key][$key2] = 1;
                        }
                    }
                }
            }
        }


        return $listMenu;
    }
}

if ( ! function_exists('generateListPermission')) {
    function generateListPermission($data = null) {
        $value = isset($data['super_admin']) ? 'checked' : '';
        $html = '<label for="super_admin">
                    <input '.$value.' style="margin-right: 5px;" type="checkbox" class="checkThis super_admin"
                    data-name="super_admin" name="permission[super_admin]" value="1" id="super_admin"/>
                    Super Admin
                </label><br/><br/>';
        $html .= createTreePermission(listAllMenu(), 0, 'checkThis super_admin', $data);
        return $html;
    }
}

if ( ! function_exists('createTreePermission')) {
    function createTreePermission($data, $left = 0, $class = '', $getData) {
        $html = '';
        foreach ($data as $index => $list) {
            if (in_array($list['type'], [2])) {
                $html .= '<label>'.$list['name'].'</label><br/>';
                $html .= createTreePermission($list['data'], $left + 1, $class, $getData);
            }
            else {
                $value = isset($getData[$list['key']]) ? 'checked' : '';
                $html .= '<label for="checkbox-'.$index.'-'.$list['key'].'">
                            <input '.$value.' style="margin-left: '.($left*30).'px; margin-right: 5px;" type="checkbox"
                            class="'.$class.' '.$list['key'].'" data-name="'.$list['key'].'" name="permission['.$list['key'].']"
                            value="1" id="checkbox-'.$index.'-'.$list['key'].'"/>
                            '.$list['name'].
                    '</label><br/>';
                $html .= getAttributePermission($list['key'], $index, $left + 1, $class.' '.$list['key'], $getData);
                $html .= '<br/>';
            }
        }
        return $html;
    }
}

if ( ! function_exists('getAttributePermission')) {
    function getAttributePermission($module, $index, $left, $class = '', $getData) {
        $html = '';
        $list = listAvailablePermission();
        if (isset($list[$module])) {
            foreach ($list[$module] as $key => $value) {
                $value = isset($getData[$module][$key]) ? 'checked' : '';
                $html .= '<label for="checkbox-'.$index.'-'.$module.'-'.$key.'">
                            <input '.$value.' style="margin-left: '.($left*30).'px; margin-right: 5px;" type="checkbox"
                            class="'.$class.'" name="permission['.$module.']['.$key.']" value="1"
                            id="checkbox-'.$index.'-'.$module.'-'.$key.'"/>
                            '.$key.
                        '</label><br/>';
            }
        }
        return $html;
    }
}

if ( ! function_exists('getPermissionRouteList')) {
    function getPermissionRouteList($listMenu) {
        $listAllowed = [];
        $listPermission = listAvailablePermission();
        foreach ($listPermission as $key => $list) {
            if ($key == 'super_admin')
                continue;
            foreach ($list as $key2 => $listRoute) {
                if (isset($listMenu[$key][$key2])) {
                    foreach ($listRoute as $value) {
                        $listAllowed[] = $value;
                    }
                }
            }
        }
        return $listAllowed;
    }
}

if ( ! function_exists('listGetPermission')) {
    function listGetPermission($listMenu, $permissionRoute)
    {
        $result = [];
        if ($permissionRoute) {
            foreach ($listMenu as $list) {
                if ($list['type'] == 1) {
                    if (in_array($list['route'], $permissionRoute)) {
                        $result[] = $list;
                    }
                }
                else {
                    $getResult = listGetPermission($list['data'], $permissionRoute);
                    if (count($getResult) > 0) {
                        $list['data'] = $getResult;
                        $result[] = $list;
                    }
                }
            }
        }

        return $result;
    }
}

if ( ! function_exists('listAllMenu')) {
    function listAllMenu()
    {
        return [

            //position
            // [
            //     'name' => __('general.position'),
            //     'icon' => '<i class="nav-icon fa fa-book"></i>',
            //     'title' => __('general.position'),
            //     'active' => ['admin.position.'],
            //     'route' => 'admin.position.index',
            //     'key' => 'position',
            //     'type' => 1,
            // ],
            [
                'name' => __('general.karyawan'),
                'icon' => '<i class="nav-icon fa fa-id-badge"></i>',
                'title' => __('general.karyawan'),
                'active' => ['admin.karyawan.'],
                'route' => 'admin.karyawan.index',
                'key' => 'karyawan',
                'type' => 1,
            ],
            [
                'name' => __('general.karyawan_karir'),
                'icon' => '<i class="nav-icon fa fa-desktop"></i>',
                'title' => __('general.karyawan_karir'),
                'active' => ['admin.karyawan_karir.'],
                'route' => 'admin.karyawan_karir.index',
                'key' => 'karyawan_karir',
                'type' => 1,
            ],
            [
                'name' => __('general.karyawan_gaji'),
                'icon' => '<i class="nav-icon fa fa-credit-card-alt"></i>',
                'title' => __('general.karyawan_gaji'),
                'active' => ['admin.karyawan_gaji.'],
                'route' => 'admin.karyawan_gaji.index',
                'key' => 'karyawan_gaji',
                'type' => 1,
            ],
       
        
            //masterdata
            [
                'name' => __('general.master-data'),
                'icon' => '<i class="nav-icon fa fa-bars"></i>',
                'title' => __('general.master-data'),
                'active' => [
                    'admin.salary.',
                    'admin.ptkp.',
                    'admin.tunj-berkala.'
                ],
                'type' => 2,
                'data' => [
                    [
                        'name' => __('general.salary'),
                        'title' => __('general.salary'),
                        'active' => ['admin.salary.'],
                        'route' => 'admin.salary.index',
                        'key' => 'salary',
                        'type' => 1
                    ],
                    [
                        'name' => __('general.ptkp'),
                        'title' => __('general.ptkp'),
                        'active' => ['admin.ptkp.'],
                        'route' => 'admin.ptkp.index',
                        'key' => 'ptkp',
                        'type' => 1
                    ],
                    [
                        'name' => __('general.bpjs'),
                        'title' => __('general.bpjs'),
                        'active' => ['admin.bpjs.'],
                        'route' => 'admin.bpjs.index',
                        'key' => 'bpjs',
                        'type' => 1
                    ],
                    [
                        'name' => __('general.tunj-berkala'),
                        'title' => __('general.tunj-berkala'),
                        'active' => ['admin.tunj-berkala.'],
                        'route' => 'admin.tunj-berkala.index',
                        'key' => 'tunj-berkala',
                        'type' => 1
                    ]
                ]
            ],
            [
                'name' => __('general.upload-file'),
                'icon' => '<i class="nav-icon fa fa-external-link-square"></i>',
                'title' => __('general.upload-file'),
                'active' => [
                    'admin.upload-absensi.',
                    'admin.upload-lembur.'
                ],
                'type' => 2,
                'data' => [
               
                    [
                        'name' => __('general.upload-absensi'),
                        'title' => __('general.upload-absensi'),
                        'active' => ['admin.upload-absensi.'],
                        'route' => 'admin.upload-absensi.create',
                        'key' => 'upload-absensi',
                        'type' => 1
                    ],
                    [
                        'name' => __('general.upload-lembur'),
                        'title' => __('general.upload-lembur'),
                        'active' => ['admin.upload-lembur.'],
                        'route' => 'admin.upload-lembur.create',
                        'key' => 'upload-lembur',
                        'type' => 1
                    ],
                
                ]
            ],
            //setting
            [
                'name' => __('general.setting'),
                'icon' => '<i class="nav-icon fa fa-gear"></i>',
                'title' => __('general.setting'),
                'active' => [
                    'admin.settings.',
                    'admin.admin.',
                    'admin.role.'
                ],
                'type' => 2,
                'data' => [
                    [
                        'name' => __('general.setting'),
                        'title' => __('general.setting'),
                        'active' => ['admin.settings.'],
                        'route' => 'admin.settings.index',
                        'key' => 'settings',
                        'type' => 1
                    ],
                    [
                        'name' => __('general.admin'),
                        'title' => __('general.admin'),
                        'active' => ['admin.admin.'],
                        'route' => 'admin.admin.index',
                        'key' => 'admin',
                        'type' => 1
                    ],
                    [
                        'name' => __('general.role'),
                        'title' => __('general.role'),
                        'active' => ['admin.role.'],
                        'route' => 'admin.role.index',
                        'key' => 'role',
                        'type' => 1
                    ]
                ]
            ],


        ];
    }
}

if ( ! function_exists('listAvailablePermission'))
{
    function listAvailablePermission() {

        $listPermission = [];

        foreach ([
            'upload-absensi',
            'upload-lembur',
                 ] as $keyPermission) {
            $listPermission[$keyPermission] = [
              
                'create' => [
                    'admin.'.$keyPermission.'.create',
                    'admin.'.$keyPermission.'.store'
                ],

            ];
        }

        foreach ([
            'salary',
       
                 ] as $keyPermission) {
            $listPermission[$keyPermission] = [
                'list' => [
                    'admin.'.$keyPermission.'.index',
                    'admin.'.$keyPermission.'.dataTable'
                ],
                'show' => [
                    'admin.'.$keyPermission.'.show'
                 
                ],
                'create' => [
                    'admin.'.$keyPermission.'.create',
                    'admin.'.$keyPermission.'.store'
                ],

            ];
        }

        foreach ([
            'category-setting'
                 ] as $keyPermission) {
            $listPermission[$keyPermission] = [
                'list' => [
                    'admin.'.$keyPermission.'.index',
                    'admin.'.$keyPermission.'.dataTable'
                ],
                'edit' => [
                    'admin.'.$keyPermission.'.edit',
                    'admin.'.$keyPermission.'.update'
                ],
            ];
        }

        foreach ([
            'settings',
                 ] as $keyPermission) {
            $listPermission[$keyPermission] = [
                'list' => [
                    'admin.'.$keyPermission.'.index',
                    'admin.'.$keyPermission.'.dataTable'
                ],
                'edit' => [
                    'admin.'.$keyPermission.'.edit',
                    'admin.'.$keyPermission.'.update'
                ],
                'show' => [
                    'admin.'.$keyPermission.'.show'
                ]
            ];
        }

        foreach ([
                     'admin',
                     'role',
                     'karyawan',
                     'ptkp',
                     'bpjs',
                     'tunj-berkala',
                     'karyawan_karir',
                     'karyawan_gaji',
                 ] as $keyPermission) {
            $listPermission[$keyPermission] = [
                'list' => [
                    'admin.'.$keyPermission.'.index',
                    'admin.'.$keyPermission.'.dataTable'
                ],
                'create' => [
                    'admin.'.$keyPermission.'.create',
                    'admin.'.$keyPermission.'.store'
                ],
                'edit' => [
                    'admin.'.$keyPermission.'.edit',
                    'admin.'.$keyPermission.'.update'
                ],
                'show' => [
                    'admin.'.$keyPermission.'.show'
                ],
                'destroy' => [
                    'admin.'.$keyPermission.'.destroy'
                ]
            ];
        }

        $listPermission['upload-absensi']['create'][] = 'admin.upload-absensi.create2';
        $listPermission['upload-absensi']['create'][] = 'admin.upload-absensi.store2';
        $listPermission['upload-lembur']['create'][] = 'admin.upload-lembur.store2';
        $listPermission['karyawan']['create'][] = 'admin.karyawan.import';
        $listPermission['karyawan']['create'][] = 'admin.karyawan.storeimport';
        $listPermission['salary']['create'][] = 'admin.salary.import';
        $listPermission['salary']['create'][] = 'admin.salary.storeimport';
        $listPermission['karyawan_gaji']['create'][] = 'admin.karyawan_gaji.storeManual';

        return $listPermission;
    }
}
