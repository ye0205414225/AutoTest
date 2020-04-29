<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class systemRouteModel extends DB
{
    /*
     * pdo使用方法
     * $dbHost      [連線位置]
     * $tableName   [連線資料表]
     * listData     [列表]
     * detail       [詳細]
     * add          [新增]
     * up           [編輯]
     * del          [刪除]
     */
    protected static $dbHost = 'mysql';
    protected static $tableName = 'system_route';

    public static function listData($data = NULL)
    {

        $query = DB::connection(self::$dbHost)->table(self::$tableName);
        if (isset($data['select']) && $data['select']) {
            $query->select($query->raw($data['select']));
        }
        if (isset($data['system_route_id']) && is_array($data['system_route_id'])) {
            $query->whereIn('system_route_id', $data['system_route_id']);
        } elseif (isset($data['system_route_id']) && $data['system_route_id'] != '') {
            $query->where('system_route_id', '=', $data['system_route_id']);
        }
        if (isset($data['system_route_code']) && is_array($data['system_route_code'])) {
            $query->whereIn('system_route_code', $data['system_route_code']);
        } elseif (isset($data['system_route_code']) && $data['system_route_code'] != '') {
            $query->where('system_route_code', '=', $data['system_route_code']);
        }
        if (isset($data['system_route_name']) && is_array($data['system_route_name'])) {
            $query->whereIn('system_route_name', $data['system_route_name']);
        } elseif (isset($data['system_route_name']) && $data['system_route_name'] != '') {
            $query->where('system_route_name', '=', $data['system_route_name']);
        }
        if (isset($data['system_route_namespace']) && is_array($data['system_route_namespace'])) {
            $query->whereIn('system_route_namespace', $data['system_route_namespace']);
        } elseif (isset($data['system_route_namespace']) && $data['system_route_namespace'] != '') {
            $query->where('system_route_namespace', '=', $data['system_route_namespace']);
        }
        if (isset($data['system_route_controllers']) && is_array($data['system_route_controllers'])) {
            $query->whereIn('system_route_controllers', $data['system_route_controllers']);
        } elseif (isset($data['system_route_controllers']) && $data['system_route_controllers'] != '') {
            $query->where('system_route_controllers', '=', $data['system_route_controllers']);
        }
        if (isset($data['system_route_function']) && is_array($data['system_route_function'])) {
            $query->whereIn('system_route_function', $data['system_route_function']);
        } elseif (isset($data['system_route_function']) && $data['system_route_function'] != '') {
            $query->where('system_route_function', '=', $data['system_route_function']);
        }
        if (isset($data['system_route_order']) && is_array($data['system_route_order'])) {
            $query->whereIn('system_route_order', $data['system_route_order']);
        } elseif (isset($data['system_route_order']) && $data['system_route_order'] != '') {
            $query->where('system_route_order', '=', $data['system_route_order']);
        }

        if (isset($data['pageMode']) && isset($data['listNum'])) {
            switch ($data['pageMode']) {
                case 'original':
                    if (isset($data['limitPage']) && isset($data['listNum']) && $data['limitPage'] !== '' && $data['listNum'] !== '') {
                        $query->skip($data['limitPage'])->take($data['listNum']);
                    }
                    $content = $query->get();
                    break;
                case 'simple':
                    $content = $query->simplePaginate($data['listNum']);
                    break;
                case 'normal':
                default:
                    $content = $query->paginate($data['listNum']);
            }
        } else {
            $content = $query->get();
            DB::disconnect(self::$dbHost);

        }

        return $content;
      }
    public static function detail($data = NULL)
    {
        if ((isset($data['system_route_id']) && $data['system_route_id']) || (isset($data['system_route_id']) && $data['system_route_id'] !== '')) {
            $query = DB::connection(self::$dbHost)->table(self::$tableName);
            if (isset($data['system_route_id']) && $data['system_route_id'])
                $query->where('system_route_id', '=', $data['system_route_id']);
            if (isset($data['key']) && $data['key'] !== '') {
                $query->where('system_route_id', '=', 0);
                $query->where('system_route_id', '=', $data['key']);
            }
            $content = $query->first();
            DB::disconnect(self::$dbHost);
            return $content;
        } else {
            return false;
        }
    }
    public static function add($data = NULL)
    {

        if (isset($data['system_route_id'])) {
            $query = DB::connection(self::$dbHost)->table(self::$tableName);
            if (isset($data['system_route_id']) && $data['system_route_id'] !== '') $setData['system_route_id'] = $data['system_route_id'];
            if (isset($data['system_route_code']) && $data['system_route_code'] !== '') $setData['system_route_code'] = $data['system_route_code'];
            if (isset($data['system_route_name']) && $data['system_route_name'] !== '') $setData['system_route_name'] = $data['system_route_name'];
            if (isset($data['system_route_namespace']) && $data['system_route_namespace'] !== '') $setData['system_route_namespace'] = $data['system_route_namespace'];
            if (isset($data['system_route_controllers']) && $data['system_route_controllers'] !== '') $setData['system_route_controllers'] = $data['system_route_controllers'];
            if (isset($data['system_route_function']) && $data['system_route_function'] !== '') $setData['system_route_function'] = $data['system_route_function'];
            if (isset($data['system_route_order']) && $data['system_route_order'] !== '') $setData['system_route_order'] = $data['system_route_order'];
            $setData['created_at'] = $query->raw('NOW()');
            $tId = $query->insertGetId($setData) ;
            DB::disconnect(self::$dbHost);
            return $tId;
        } else {
            return false;
        }
    }
    public static function up($data = NULL)
    {
        if (isset($data['system_route_id']) && $data['system_route_id']) {
            $query = DB::connection(self::$dbHost)->table(self::$tableName);
            if (isset($data['system_route_id']) && $data['system_route_id'] !== '') $setData['system_route_id'] = $data['system_route_id'];
            if (isset($data['system_route_code']) && $data['system_route_code'] !== '') $setData['system_route_code'] = $data['system_route_code'];
            if (isset($data['system_route_name']) && $data['system_route_name'] !== '') $setData['system_route_name'] = $data['system_route_name'];
            if (isset($data['system_route_namespace']) && $data['system_route_namespace'] !== '') $setData['system_route_namespace'] = $data['system_route_namespace'];
            if (isset($data['system_route_controllers']) && $data['system_route_controllers'] !== '') $setData['system_route_controllers'] = $data['system_route_controllers'];
            if (isset($data['system_route_function']) && $data['system_route_function'] !== '') $setData['system_route_function'] = $data['system_route_function'];
            if (isset($data['system_route_order']) && $data['system_route_order'] !== '') $setData['system_route_order'] = $data['system_route_order'];
            $setData['updated_at'] = $query->raw('NOW()');
            $query->where('system_route_id', '=', $data['system_route_id']);
            $query->update($setData);
            DB::disconnect(self::$dbHost);
            return true;
        } else {
            return false;
        }
    }
    public static function del($data = NULL)
    {
        if(isset($data['system_route_id']) && $data['system_route_id']){
            $query = DB::connection(self::$dbHost)->table(self::$tableName);
            if (isset($data['system_route_id']) && is_array($data['system_route_id'])) {
                $query->whereIn('system_route_id', $data['system_route_id']);
            } elseif (isset($data['system_route_id']) && $data['system_route_id'] != '') {
                $query->where('system_route_id', '=', $data['system_route_id']);
            }
            $query->delete();
            DB::disconnect(self::$dbHost);
            return true;
        }else{
            return false;
        }
    }
}