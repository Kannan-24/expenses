<?php

namespace App\Services;

class TotpService
{
    // Generate a base32 secret
    public static function generateSecret(int $length = 32): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i=0;$i<$length;$i++) { $secret .= $alphabet[random_int(0, strlen($alphabet)-1)]; }
        return $secret;
    }

    // Decode base32
    protected static function base32Decode(string $b32): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $b32 = strtoupper($b32);
        $buffer = 0; $bitsLeft = 0; $result = '';
        for ($i=0;$i<strlen($b32);$i++) {
            $val = strpos($alphabet, $b32[$i]);
            if ($val === false) continue; // ignore padding
            $buffer = ($buffer << 5) | $val;
            $bitsLeft += 5;
            if ($bitsLeft >= 8) {
                $bitsLeft -= 8;
                $result .= chr(($buffer & (0xFF << $bitsLeft)) >> $bitsLeft);
            }
        }
        return $result;
    }

    public static function getCode(string $secret, int $period = 30, int $digits = 6, string $algo = 'sha1'): string
    {
        $counter = floor(time() / $period);
        $key = self::base32Decode($secret);
        $binCounter = pack('N*', 0) . pack('N*', $counter); // 64-bit
        $hash = hash_hmac($algo, $binCounter, $key, true);
        $offset = ord(substr($hash, -1)) & 0x0F;
        $truncated = unpack('N', substr($hash, $offset, 4))[1] & 0x7FFFFFFF;
        $code = $truncated % (10 ** $digits);
        return str_pad((string)$code, $digits, '0', STR_PAD_LEFT);
    }

    public static function verify(string $secret, string $code, int $window = 1): bool
    {
        $code = preg_replace('/\D/','',$code);
        for ($i=-$window; $i <= $window; $i++) {
            $calc = self::getCodeForCounter($secret, floor(time()/30)+$i);
            if (hash_equals($calc, $code)) return true;
        }
        return false;
    }

    protected static function getCodeForCounter(string $secret, int $counter, int $digits = 6, string $algo='sha1'): string
    {
        $key = self::base32Decode($secret);
        $binCounter = pack('N*', 0) . pack('N*', $counter);
        $hash = hash_hmac($algo, $binCounter, $key, true);
        $offset = ord(substr($hash, -1)) & 0x0F;
        $truncated = unpack('N', substr($hash, $offset, 4))[1] & 0x7FFFFFFF;
        $code = $truncated % (10 ** $digits);
        return str_pad((string)$code, $digits, '0', STR_PAD_LEFT);
    }

    public static function getOtpAuthUrl(string $secret, string $email, string $issuer): string
    {
        $label = rawurlencode($issuer . ':' . $email);
        $issuerEnc = rawurlencode($issuer);
        return "otpauth://totp/{$label}?secret={$secret}&issuer={$issuerEnc}&algorithm=SHA1&digits=6&period=30";
    }
}
