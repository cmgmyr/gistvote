<?php namespace Gistvote\Users;

class UserRepository
{
    /**
     * @param $userData
     * @return static
     */
    public function findByUsernameOrCreate($userData)
    {
        $user = User::firstOrCreate([
            'username' => $userData->nickname
        ]);

        // @todo: I don't think this will work. Let's handle it another way later...
        $email = $userData->email;
        if (!$email) {
            $email = $userData->nickname . '@users.noreply.github.com';
        }

        $user->email = $email;
        $user->name = $userData->name;
        $user->avatar = $userData->avatar;
        $user->token = $userData->token;
        $user->save();

        return $user;
    }
}
