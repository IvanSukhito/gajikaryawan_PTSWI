<?php

namespace App\Codes\Logic;

use App\Http\Controllers\Controller;

class MonitoringSystemController extends Controller
{
    /**
     * @param $data
     * @param int $parentId
     * @return array
     */
    public function getCategoryTree($data, $parentId = 0)
    {
        $result = [];
        foreach ($data as $listData) {
            $result[$listData['parent_id']][] = $listData;
        }

        $result = $this->getCategoryTreeChild($result);

        return $result;
    }

    protected function getCategoryTreeChild($data, $parentId = 0) {
        $result = [];

        if (isset($data[$parentId])) {
            foreach ($data[$parentId] as $list) {

                $getTemp = $this->getCategoryTreeChild($data, $list['id']);
                if (count($getTemp) > 0) {
                    $temp = [
                        'text' => $list['name'],
                        'nodes' => $getTemp
                    ];
                }
                else {
                    $additional = ' <a onclick="return clickHere(this);" href="'.route('admin.category-setting.edit', $list['id']).'" class="btn btn-info pull-right">Setup</a>';
                    $temp = [
                        'text' => $list['name'] . $additional,
                        'href' => route('admin.category-setting.edit', $list['id']),
                        'selectable' => false,
                        'state' => [
                            'selected' => false
                        ],
                    ];
                }

                $result[] = $temp;

            }
        }

        return $result;

    }

}
