<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     *  rules()の前に実行される
     *       $this->merge(['key' => $value])を実行すると、
     *       フォームで送信された(key, value)の他に任意の(key, value)の組み合わせをrules()に渡せる
     */
    public function getValidatorInstance()
    {
        // 日付を作成
        $old_year = $this->input('old_year');
        $old_month = $this->input('old_month');
        $old_day = $this->input('old_day');
        $data = $old_year . '-' . $old_month . '-' . $old_day;
        $birth_day = date('Y-m-d', strtotime($data));

        // rules()に渡す値を追加でセット
        $this->merge([
            'birth_day' => $birth_day,
        ]);

        return parent::getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    //バリデーションルール
    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u',
            'under_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u',
            'mail_address' => 'required|email|unique:users|max:100',
            'sex' => 'required|in:1,2,3',
            'birth_day' => 'required|after_or_equal:2000/01/01|before_or_equal:today|date',
            'role' => 'required|in:1,2,3,4',
            'password' => 'required|between:8,30|confirmed'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    //エラーメッセージ
    public function messages()
    {
        return [
            'over_name.max' => '10文字以内で入力してください',
            'under_name.max' => '10文字以内で入力してください',
            'over_name_kana.max' => '30文字以内で入力してください',
            'over_name_kana.regex' => '全角カタカナで入力してください',
            'under_name_kana.max' => '30文字以内で入力してください',
            'under_name_kana.regex' => '全角カタカナで入力してください',
            'mail_address.unique' => 'この:attributeは既に登録されています',
            'mail_address.max' => '100文字以内で入力してください',
            'mail_address.email' => ':attributeの形式で入力してください',
            'sex.in:1,2,3' => '選択項目から指定してください',
            'birth_day.after_or_equal' => '2000年1月1日～今日までの範囲で指定してください',
            'birth_day.before_or_equal' => '2000年1月1日～今日までの範囲で指定してください',
            'birth_day.date' => '正しい日付が選択されていません',
            'role.in:1,2,3,4' => '選択項目から指定してください',
            'password.between' => '8文字以上30文字以内で入力してください',
            'password.confirmed' => ':attributeが一致しません'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    //項目名
    public function attributes()
    {
        return [
            'over_name' => '姓',
            'under_name' => '名',
            'over_name_kana' => 'セイ',
            'under_name_kana' => 'メイ',
            'mail_address' => 'メールアドレス',
            'sex' => '性別',
            'old_year' => '生年月日（年）',
            'old_month' => '生年月日（月）',
            'old_day' => '生年月日（日）',
            'birth_day' => '生年月日',
            'role' => '権限',
            'password' => 'パスワード'
        ];
    }
}
