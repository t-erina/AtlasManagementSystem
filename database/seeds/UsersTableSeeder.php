<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factoryで10人の仮ユーザーを自動作成する
        // $users = factory(App\User::class, 10)->create();

        User::insert([
                ['over_name' => ' 猿飛',
                'under_name' => '佐助',
                'over_name_kana' => 'サルトビ',
                'under_name_kana' => 'サスケ',
                'mail_address' => 'sarutobi@example.com',
                'sex' => '1',
                'birth_day' => '2000-01-01',
                'role' => '1',
                'password' => Hash::make('testtest'),
            ],
            [
                'over_name' => '加藤',
                'under_name' => '段蔵',
                'over_name_kana' => 'カトウ',
                'under_name_kana' => 'ダンゾウ',
                'mail_address' => 'katou@example.com',
                'sex' => '1',
                'birth_day' => '2000-01-01',
                'role' => '2',
                'password' => Hash::make('testtest'),
            ],
            [
                'over_name' => '望月',
                'under_name' => '千代女',
                'over_name_kana' => 'モチヅキ',
                'under_name_kana' => 'チヨメ',
                'mail_address' => 'motizuki@example.com',
                'sex' => '2',
                'birth_day' => '2002-02-02',
                'role' => '3',
                'password' => Hash::make('testtest'),
            ],
            [
                'over_name' => '服部',
                'under_name' => '半蔵',
                'over_name_kana' => 'ハットリ',
                'under_name_kana' => 'ハンゾウ',
                'mail_address' => 'hattori@example.com',
                'sex' => '1',
                'birth_day' => '2002-02-02',
                'role' => '4',
                'password' => Hash::make('testtest'),
            ],
            [
                'over_name' => '霧隠',
                'under_name' => '才蔵',
                'over_name_kana' => 'キリガクレ',
                'under_name_kana' => 'サイゾウ',
                'mail_address' => 'kirigakure@example.com',
                'sex' => '1',
                'birth_day' => '2010-06-06',
                'role' => '4',
                'password' => Hash::make('testtest'),
            ],
            [
                'over_name' => '風魔',
                'under_name' => '小太郎',
                'over_name_kana' => 'フウマ',
                'under_name_kana' => 'コタロウ',
                'mail_address' => 'huuma@example.com',
                'sex' => '3',
                'birth_day' => '2010-07-07',
                'role' => '4',
                'password' => Hash::make('testtest'),
            ],
            [
                'over_name' => '猪名寺',
                'under_name' => '乱太郎',
                'over_name_kana' => 'イナデラ',
                'under_name_kana' => 'ランタロウ',
                'mail_address' => 'inadera@example.com',
                'sex' => '1',
                'birth_day' => '2013-11-23',
                'role' => '4',
                'password' => Hash::make('testtest'),
            ]
            ]);
        }
}
