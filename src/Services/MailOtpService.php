<?php

namespace Xuanhieu080\MailOtp\Services;

use Illuminate\Support\Facades\Crypt;
use XuanHieu\MailOtp\Jobs\SendMail;
use XuanHieu\MailOtp\Models\MailOtp;
use Illuminate\Support\Carbon;

class MailOtpService
{
    public function generateOtp($email, $length = 6, $dataType = 0, $view = 'MailOtp::emails.otp', $subject = 'Your OTP Code')
    {
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        if ($dataType == 1) {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } elseif ($dataType == 2) {
            $characters = '0123456789';
        }

        $shuffled = str_shuffle($characters);
        $otp = substr($shuffled, 0, $length);
        $expiresAt = Carbon::now()->addMinutes(config('mail-otp.otp_expiry'));

        $hash = $this->encrypt(['email' => $email, 'expires_at' => $expiresAt]);

        return MailOtp::query()
            ->updateOrCreate(
                ['email' => $email],
                ['otp' => $otp, 'expires_at' => $expiresAt, 'hash' => $hash]
            );
    }

    public function validateOtp($email, $otp)
    {
        $record = MailOtp::query()
            ->where('email', $email)
            ->where('otp', $otp)
            ->where('expires_at', '>', now())
            ->first();

        return $record !== null;
    }

    public function sendOtpEmail($email, $data = [], $view = 'MailOtp::emails.otp', $subject = 'Your OTP Code')
    {
        $details['to'] = $email;
        $details['view'] = $view;
        $details['subject'] = $subject;
        $details['data'] = $data;

        dispatch(new SendMail($details));
    }

    public function encrypt($data)
    {
        return Crypt::encrypt($data);
    }

    /**
     * Giải mã dữ liệu
     */
    public function decrypt($encryptedData)
    {
        try {
            return Crypt::decrypt($encryptedData);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return null;
        }
    }
}
