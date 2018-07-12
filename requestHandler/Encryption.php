<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.02.17
 * Time: 14:22
 */

namespace Handler;
use Exception;


class Encryption {

    public $pubkey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDEflm7i2y0WUiKZj3hDZ1GZmVU
PIWs2EBoNRLn9VmVeH4Z7Ux+jWnyI++cuuDvmJW7jhAS8iZcLTcKPhnQEz/77XVT
XmCK7XFg5fb8GzKlCZRvTNwH2aabYrmC/XvTiGhLgAkloJgs1QimVXJupWRLgCvX
hl/Vze7i+NZVtXIytQIDAQAB
-----END PUBLIC KEY-----';

    public $privkey;

    public function __construct() {
        $this->privkey = openssl_pkey_get_private(file_get_contents('private_key.pem'));
    }

    public function encrypt($data) {
        if (openssl_public_encrypt($data, $encrypted, $this->pubkey))
            $data = base64_encode($encrypted);
        else
            throw new Exception('Unable to encrypt data.');
//        var_dump(openssl_public_encrypt($data, $encrypted, $this->pubkey));
        return $data;
    }

    public function decrypt($data) {
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->privkey))
            $data = $decrypted;
        else
            throw new Exception('Unable to decrypt data.');
        return $data;
    }
}