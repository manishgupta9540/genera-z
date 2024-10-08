<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CommonController extends Controller
{
    public function addComponent(Request $request)
    {
        // dd($request->all());
        $pid = $request->get('pid');
        $page = Helper::getAddPageById($pid);
        $encodedData = json_decode($request['data']);
        /* data MEAN json encoded data,
        pid mean page id
        len mean page length */
        $len = $request->get('len');
        // dd($page['limit']);
        if ($len > $page['limit']) {
            $return['status'] = false;
            $return['msg'] = 'You have exceeded the page limit';
            return $return;
        }
        if ($page != "") {
            if ($pid == config('addPages.route.id')) {
                // $data = json_decode($request['data'], true);
                $data['id'] = hrtime(true);
                $data['routes'] = Helper::getRouteNames();
            }
            elseif ($pid == config('addPages.option.id')) {
                if (!isset($encodedData->question_id)) {
                    $return['status'] = false;
                    $return['msg'] = 'Please try again';
                    return $return;
                }
                $data['id'] = hrtime(true);
                $data['question_id'] = $encodedData->question_id;
            }
            else {
                $data['id'] = hrtime(true);
            }
            $data['new'] = true;
            $return['view'] = view($page['name'], $data)->render();
            $return['success'] = true;
            $return['msg'] = 'Component added Successfully';
            return $return;
        }
    }
}
