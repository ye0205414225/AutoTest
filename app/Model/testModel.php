<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class testModel extends DB
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
    protected static $tableName = 'test';

    public static function listData($data = NULL)
    {

        $query = DB::connection(self::$dbHost)->table(self::$tableName);
        if (isset($data['select']) && $data['select']) {
            $query->select($query->raw($data['select']));
        }
        if (isset($data['test_id']) && is_array($data['test_id'])) {
            $query->whereIn('test_id', $data['test_id']);
        } elseif (isset($data['test_id']) && $data['test_id'] != '') {
            $query->where('test_id', '=', $data['test_id']);
        }
        if (isset($data['test_name']) && is_array($data['test_name'])) {
            $query->whereIn('test_name', $data['test_name']);
        } elseif (isset($data['test_name']) && $data['test_name'] != '') {
            $query->where('test_name', '=', $data['test_name']);
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
        if ((isset($data['test_id']) && $data['test_id']) || (isset($data['test_id']) && $data['test_id'] !== '')) {
            $query = DB::connection(self::$dbHost)->table(self::$tableName);
            if (isset($data['test_id']) && $data['test_id'])
                $query->where('test_id', '=', $data['test_id']);
            if (isset($data['key']) && $data['key'] !== '') {
                $query->where('test_id', '=', 0);
                $query->where('test_id', '=', $data['key']);
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
        if (isset($data['test_id'])) {
            $query = DB::connection(self::$dbHost)->table(self::$tableName);
            if (isset($data['test_id']) && $data['test_id'] !== '') $setData['test_id'] = $data['test_id'];
            if (isset($data['test_name']) && $data['test_name'] !== '') $setData['test_name'] = $data['test_name'];
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
        if (isset($data['test_id']) && $data['test_id']) {
            $query = DB::connection(self::$dbHost)->table(self::$tableName);
            if (isset($data['test_id']) && $data['test_id'] !== '') $setData['test_id'] = $data['test_id'];
            if (isset($data['test_name']) && $data['test_name'] !== '') $setData['test_name'] = $data['test_name'];
            $setData['updated_at'] = $query->raw('NOW()');
            $query->where('test_id', '=', $data['test_id']);
            $query->update($setData);
            DB::disconnect(self::$dbHost);
            return true;
        } else {
            return false;
        }
    }
    public static function del($data = NULL)
    {
        if(isset($data['test_id']) && $data['test_id']){
            $query = DB::connection(self::$dbHost)->table(self::$tableName);
            if (isset($data['test_id']) && is_array($data['test_id'])) {
                $query->whereIn('test_id', $data['test_id']);
            } elseif (isset($data['test_id']) && $data['test_id'] != '') {
                $query->where('test_id', '=', $data['test_id']);
            }
            $query->delete();
            DB::disconnect(self::$dbHost);
            return true;
        }else{
            return false;
        }
    }
}
