<?php

namespace modeles;

/**
 * Class UserFactory
 * @package modeles
 */
class UserFactory
{
    /**
     * Creates the User with the result of the query from UserModel
     * @param array $result
     * @param string $type
     * @return User
     */
    public static function createUser(array $result, string $type): User
    {
        if ($type == 'mysql') {
            if (isset($result) && isset($result[0]) && !empty($result[0]) && isset($result[0]['id']) && isset($result[0]['pseudo']) && isset($result[0]['password']) && isset($result[0]['isAdmin'])) {
                return new User($result[0]['id'], $result[0]['pseudo'], $result[0]['password'], $result[0]['isAdmin']);
            } else {
                return null;
            }
        } else
            return null;
    }
}