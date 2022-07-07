<?php

namespace App\Helpers;

use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Helper
{
    /**
     * Function create randomletter
     *
     * @param integer $lengt
     * @return void
     */
    public static function randomLetters(int $lengt = 8): string
    {
        # code...
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $lengt; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string        
    }
    /**
     * Create a product manually, factory no work with sqlite
     *
     * @return void
     */
    public static function create_a_product_manually(): void
    {
        DB::table('products')->insert([
            'name' => 'Producto ' . rand(0, 100),
            'price' => rand(0, 100),
            'created_at' => date('Ymd'),
            'updated_at' => date('Ymd')
        ]);
    }
    /**
     * Creating user anonymous
     *
     * @return void
     */
    public static function create_user_anonymous(): void
    {
        User::create([
            'name' => 'anonymous',
            'surname' => 'surname',
            'email' => 'anonymous@storeevertec.com',
            'password' => bcrypt('anonymous'),
            'mobile' => '9612568479'
        ]);
        User::where('id', '=', '1')->update([
            'id' => 0
        ]);        
    }
    /**
     * Create a package
     *
     * @return void
     */
    public static function create_a_package_manually(): void
    {
        Package::create([
            'name'=>'Estafeta',
            'country_scope'=>'America'
        ]);
    }
    public static function logWrite(string $data)
    {
        $file=__DIR__;
        $file=str_replace("app\Helpers","",$file);
        $file=$file."log.txt";
        $fh = fopen($file, 'a');
        fwrite($fh, $data . PHP_EOL);
        fclose($fh);
    }
}
