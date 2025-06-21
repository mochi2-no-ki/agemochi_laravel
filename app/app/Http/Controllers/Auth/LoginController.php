<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserAccount;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * ログイン処理とトークン発行
     */
    public function login(Request $request)
    {
        // バリデーション
        $credentials = $request->validate([
            'mail' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // UserLogin から認証対象ユーザーを取得
        $userLogin = UserLogin::where('mail', $credentials['mail'])->first();

        if (! $userLogin || ! Hash::check($credentials['password'], $userLogin->password)) {
            throw ValidationException::withMessages([
                'mail' => ['メールアドレスまたはパスワードが正しくありません。'],
            ]);
        }

        // UserAccount を取得（リレーション経由でも可）
        $userAccount = UserAccount::findOrFail($userLogin->user_id);

        // トークン発行（token 名は "login" などでOK）
        $token = $userAccount->createToken('login');

        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }

    /**
     * ログアウト処理（現在のトークンを削除）
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'ログアウトしました。',
        ]);
    }
}
