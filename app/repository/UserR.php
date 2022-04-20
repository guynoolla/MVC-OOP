<?php

namespace App\Repository;

use App\Core\Database;
use App\Core\Token;
use App\Models\UserModel;

class UserR implements \App\Contracts\RInterface
{
    private $db;
    private $modelPath;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->modelPath = UserModel::class;
    }

    public function fetch($fields=['*']): array
    {
        $users = $this->db
                ->select($fields)
                ->from('users')
                ->orderBy('username')
                ->execute()
                ->fetch($this->modelPath);

        return (!empty($users) ? $users : []);
    }

    public function find($id, $fields=['*']): UserModel
    {
        $user = $this->db
                ->select($fields)
                ->from('users')
                ->where(['id' => $id])
                ->execute()
                ->fetch($this->modelPath);

        return (!empty($user) ? $user[0] : new UserModel());
    }

    public function findByEmail($email, $fields=['*']): UserModel
    {
        $user = $this->db
                ->select($fields)
                ->from('users')
                ->where(['email' => $email])
                ->execute()
                ->fetch($this->modelPath);

        return (!empty($user) ? $user[0] : new UserModel());
    }

    public function isUnique($field, $value): bool
    {
        $user = $this->db
                ->select([$field])
                ->from('users')
                ->where([$field => $value])
                ->execute()
                ->fetch($this->modelPath);

        return (!empty($user) ? false : true);
    }

    public function getByPasswordResetHash(Token $token, string $resetToken, $attr=['*']): UserModel
    {
        $tokenHash = $token->generate($resetToken)->getHash();

        $user = $this->db
            ->select($attr)
            ->from('users')
            ->where(['passwordResetHash' => $tokenHash])
            ->execute()
            ->fetch($this->modelPath);

        return (!empty($user) ? $user[0] : new UserModel());
    }
}
