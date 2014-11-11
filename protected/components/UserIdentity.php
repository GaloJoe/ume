<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;
    private $_perfil;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $username = strtolower($this->username);
        $user = Usuario::model()->find('LOWER(email)=?', array($username));

        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($user->ativo == 1) {
            $login = true;
            if ($user->imobiliaria != null) {
                $login = false;
                $imobiliaria = Imobiliaria::model()->findByPk($user->imobiliaria);

                if ($imobiliaria->ativo == 1) {
                    $login = true;
                }
            }

            if ($login) {
                $this->_id = $user->id;
                $this->username = $user->nome;
                $this->errorCode = self::ERROR_NONE;

                $this->_perfil = $user->perfil;
            }
        }

        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId() {
        return $this->_id;
    }

    public function getPerfil() {
        return $this->_perfil;
    }

}
