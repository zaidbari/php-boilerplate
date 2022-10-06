<?php

namespace App\Models;
use App\Core\Model;

class User extends Model
{
    public static function all() : array
    {
        try {
            return self::db()->table('users')->select()->get();
        } catch (\Exception $e) {
            self::log('error', $e->getMessage());
            return [];
        }
    }

    public static function create( $data ) : int
    {
        try {
            return self::db()->table('users')->insert($data)->execute();
        } catch (\Exception $e) {
            self::log('error', $e->getMessage(), $data);
            return 0;
        }
    }

    public static function find( $value, $field = 'id' )
    {
        try {
            $user = self::db()->table('users')->select()->where($field, $value)->get();
            return $user ? $user[0] : null;
        } catch (\Exception $e) {
            self::log('error', $e->getMessage());
            return null;
        }
    }
    
}
