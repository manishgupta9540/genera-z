<?php

class PaymentHelper
{
    static function encrypt($plainText, $key)
    {
        $key = self::hextobin(md5($key));
        $iv = openssl_random_pseudo_bytes(16);
        $encryptedText = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $encryptedTextWithIv = $iv . $encryptedText;
        return base64_encode($encryptedTextWithIv);
    }

    static function decrypt($encryptedText, $key)
    {
        $key = self::hextobin(md5($key));
        $encryptedText = base64_decode($encryptedText);
        $iv = substr($encryptedText, 0, 16);
        $encryptedText = substr($encryptedText, 16);
        return openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }

    static function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            $binString .= $packedString;
            $count += 2;
        }
        return $binString;
    }
}
