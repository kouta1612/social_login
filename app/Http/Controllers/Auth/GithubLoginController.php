<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class GithubLoginController extends Controller
{
    /**
     * GitHubの認証ページヘユーザーをリダイレクト
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * GitHubからユーザー情報を取得
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = $this->findOrCreateGithubUser(
            Socialite::driver('github')->user()
        );

        Auth::login($user);

        return redirect('/');
    }

    protected function findOrCreateGithubUser($githubUser)
    {
        $user = User::firstOrNew(['provider_id' => $githubUser->id]);
        if ($user->exists()) return $user;
        $user->fill([
            'name' => $githubUser->nickname,
            'email' => $githubUser->email,
            'avatar' => $githubUser->avatar
        ])->save();

        return $user;
    }
}
