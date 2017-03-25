<?php

namespace Lubusin\Mojo;

use Lubusin\Mojo\Models\MojoPaymentDetails;
use Lubusin\Mojo\Models\MojoRefundDetails;
use Exception;
use App\User;

class Mojo
{
    /*
     * Accepts the order details and creates a
     * payment request at Instamojo's end
     * returning the payment form URL
     */

    public static function giveMeFormUrl(User $user, $amount, $purpose, $phone = null)
    {
        self::checkConfigValues();

        $sub = config('laravelmojo.subdomain_for_endpoints');

        $curl = self::setupCURL("https://{$sub}.instamojo.com/api/1.1/payment-requests/");

        $payload = self::createPaymentPayload($user, $amount, $purpose, $phone);

        $response = self::closeCurl($curl, $payload);

        $finalResponse = json_decode($response);
        
        return $finalResponse->payment_request->longurl;
    }

    /*
     * After the payment via Instamojo, it
     * returns that payment's details
     * after redirection
     */

    public static function giveMePaymentDetails()
    {
        $payment_id = filter_input(INPUT_GET, 'payment_id');
        $payment_request_id = filter_input(INPUT_GET, 'payment_request_id');
        $sub = config('laravelmojo.subdomain_for_endpoints');

        $curl = self::setupCURL("https://{$sub}.instamojo.com/api/1.1/payment-requests/{$payment_request_id}/{$payment_id}/");

        $response = curl_exec($curl);
        curl_close($curl);

        $decoded_response = json_decode($response);
        return $decoded_response->payment_request;
    }

    /*
     * To process the refund's
     */

    public static function refund($payment_id, $type, $reason)
    {
        $sub = config('laravelmojo.subdomain_for_endpoints');

        $curl = static::setupCURL("https://{$sub}.instamojo.com/api/1.1/refunds/");

        $payload = ['payment_id' => $payment_id,
                    'type' => $type,
                    'body' => $reason ];

        $response = self::closeCurl($curl, $payload);
        $afterDecoding = json_decode($response);
        $refund = $afterDecoding->refund;

        $transaction = MojoPaymentDetails::where('payment_id', $payment_id)->first();
        $user_id = $transaction->user_id;

        $refund_record = self::createRefundInDB($user_id, $refund, $payment_id);
            
        return $refund_record;
    }

    private static function checkConfigValues()
    {
        if (!config('laravelmojo.key')) {
            throw new Exception('Please set the Instamojo API key in your env file');
        } elseif (!config('laravelmojo.token')) {
            throw new Exception('Please set the Instamojo token in your env file');
        } elseif (!config('laravelmojo.redirect_url_after_payment')) {
            throw new Exception('Please set the redirect url in your env file');
        } elseif (!config('laravelmojo.subdomain_for_endpoints')) {
            throw new Exception('Please set the subdomain for Instamojo api endpoint in your env file');
        } elseif (!config('laravelmojo.webhook_url')) {
            throw new Exception('Please set the webhook url in your env file');
        } elseif (!config('laravelmojo.salt')) {
            throw new Exception('Please set the instamojo salt in your env file');
        } else {
            return true;
        }
    }

    private static function setupCURL($apiEndpoint)
    {
        if (extension_loaded("curl")) {
            $ch = curl_init();
            $api_key = config('laravelmojo.key');
            $api_token = config('laravelmojo.token');

            curl_setopt($ch, CURLOPT_URL, "$apiEndpoint");
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-Api-Key:{$api_key}",
                                                 "X-Auth-Token:{$api_token}"]);
            return $ch;
        } else {
            throw new Exception('CURL extension is not loaded');
        }
    }

    private static function closeCurl($curl, $payload)
    {
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    private static function createPaymentPayload(User $user, $amount, $purpose, $phone = null)
    {
        if (is_null($phone)) {
            $phone = $user->phone;
        }

        $payload = ['purpose' => $purpose,
                    'amount' => $amount,
                    'phone' => $phone,
                    'buyer_name' => $user->name,
                    'redirect_url' => config('laravelmojo.redirect_url_after_payment'),
                    'send_email' => false,
                    'webhook' => config('laravelmojo.webhook_url'),
                    'send_sms' => false,
                    'email' => $user->email,
                    'allow_repeated_payments' => false ];

        return $payload;
    }

    private static function createRefundInDB($user_id, \stdClass $refund, $payment_id)
    {
        $refund_record = MojoRefundDetails::create(['user_id' => $user_id,
                                                   'refund_id' => $refund->id,
                                                   'payment_id' => $payment_id,
                                                   'status' => $refund->status,
                                                   'type' => $refund->type,
                                                   'body' => $refund->body,
                                                   'refund_amount' => $refund->refund_amount,
                                                   'total_amount' => $refund->total_amount,
                                                 ]);

        return $refund_record;
    }

    public static function allPayments()
    {
        return MojoPaymentDetails::all();
    }
    public static function allPaymentsFor(User $user)
    {
        return MojoPaymentDetails::where('user_id', $user->id)->get();
    }
    public static function failedPayments()
    {
        return MojoPaymentDetails::where('payment_status', '!=', 'credit')->get();
    }
    public static function successfulPayments()
    {
        return MojoPaymentDetails::where('payment_status', 'credit')->get();
    }
    public static function myAndMojosIncome()
    {
        return MojoPaymentDetails::sum('amount');
    }
    public static function myIncome()
    {
        $a = MojoPaymentDetails::sum('amount');
        $f = MojoPaymentDetails::sum('fees');
        return $a - $f;
    }
    public static function mojosIncome()
    {
        return MojoPaymentDetails::sum('fees');
    }

    public static function allRefunds()
    {
        return MojoRefundDetails::all();
    }
    public static function allRefundsFor(User $user)
    {
        return MojoRefundDetails::where('user_id', $user->id)->get();
    }
}
