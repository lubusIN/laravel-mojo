<?php

namespace Lubus\Mojo;

use Lubus\Mojo\Models\MojoPaymentDetails;
use Lubus\Mojo\Models\MojoRefundDetails;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use DB;

class Mojo
{
	public static function go($user,$amount,$purpose)
	{
		DB::beginTransaction();

		try
		{
			$sub = config('laravelmojo.subdomain_for_endpoints');
			$ch = static::setupCURL("https://$sub.instamojo.com/api/1.1/payment-requests/",config('laravelmojo.key'),config('laravelmojo.token'));

			$details = ['purpose' => $purpose,
					    'amount' => $amount,
					    'phone' => $user->phone,
					    'buyer_name' => $user->name,
					    'redirect_url' => config('laravelmojo.redirect_url_after_payment'),
					    'send_email' => false,
					    'webhook' => '',
					    'send_sms' => false,
					    'email' => $user->email,
					    'allow_repeated_payments' => false ];

			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($details));
			$response = curl_exec($ch);
			curl_close($ch); 

			$finalResponse = json_decode($response);

			DB::commit();
			return $finalResponse->payment_request->longurl;
		}

		catch(Exception $e)
		{
			DB::rollback();
			return false;
		}
		
	}

	public static function done()
	{
		DB::beginTransaction();

		try
		{
			$payment_id = $_GET['payment_id'];
			$payment_request_id = $_GET['payment_request_id'];
			$sub = config('laravelmojo.subdomain_for_endpoints');
			$ch = static::setupCURL("https://$sub.instamojo.com/api/1.1/payment-requests/$payment_request_id/$payment_id/",config('laravelmojo.key'),config('laravelmojo.token'));

			$response = curl_exec($ch);
			curl_close($ch); 

			$decoded_response = json_decode($response);
			$details = $decoded_response->payment_request;

			static::updateDB($details);

			DB::commit();
			return $details;
		}

		catch(Exception $e)
		{
			DB::rollback();
			return false;
		}
		
	}

	public static function updateDB($details)
	{
		DB::beginTransaction();

		try
		{
			$user = User::where('email',$details->email)->first();
			$user_id = $user->id;

	    	MojoPaymentDetails::create(['user_id' => $user_id,
									   'buyer_email' => $details->email,
									   'buyer_name' => $details->buyer_name,
									   'buyer_phone' => $details->phone,
									   'currency' => $details->payment->currency,
									   'amount' => $details->amount,
									   'fees' => $details->payment->fees,
									   'longurl' => $details->longurl,
									   'payment_id' => $details->payment->payment_id,
									   'payment_request_id' => $details->id,
									   'purpose' => $details->purpose,
									   'shorturl' => $details->shorturl,
									   'request_status' => $details->status,
									   'payment_status' => $details->payment->status,
									 ]);
	    	DB::commit();
	    	return true;
		}

		catch(Exception $e)
		{
			DB::rollback();
			return false;
		}
	}

	public static function setupCURL($endPoint,$key,$token)
	{
			if (extension_loaded("curl")) 
			{
			  	$c_init = curl_init();

				curl_setopt($c_init, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($c_init, CURLOPT_URL, $endPoint);
				curl_setopt($c_init, CURLOPT_HEADER, FALSE);
				curl_setopt($c_init, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($c_init, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($c_init, CURLOPT_HTTPHEADER,[
				                   "X-Api-Key: $key",
				                   "X-Auth-Token: $token"]
				            );

				return $c_init;
			} 
			else 
			{
			  	dd("Curl is not loaded");
			}			
	}

	public static function allPayments()
	{
		 return $allPaymentDetails = MojoPaymentDetails::all();
	}

	public static function allPaymentsFor(User $user)
	{
		return $userSpecificDetails = MojoPaymentDetails::where('user_id',$user->id)->get();
	}

	public static function failedPayments()
	{
		return $failedPayments = MojoPaymentDetails::where('payment_status','!=','credit')->get();
	}

	public static function successfulPayments()
	{
		return $successfulPayments = MojoPaymentDetails::where('payment_status','credit')->get();
	}

	public static function myAndMojosIncome()
	{
		return $totalIncome = MojoPaymentDetails::sum('amount');
	}

	public static function myIncome()
	{
		$a = MojoPaymentDetails::sum('amount');
		$f = MojoPaymentDetails::sum('fees');
		return $earnings = $a - $f;
	}

	public static function mojosIncome()
	{
		return $mojoShare = MojoPaymentDetails::sum('fees');
	}

	public static function refund($payment_id,$type,$reason)
	{
		DB::beginTransaction();

		try
		{
			$sub = config('laravelmojo.subdomain_for_endpoints');
			$ch = static::setupCURL("https://$sub.instamojo.com/api/1.1/refunds/",config('laravelmojo.key'),config('laravelmojo.token'));

			$details = ['payment_id' => $payment_id,
					    'type' => $type,
					    'body' => $reason ];

			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($details));
			$response = curl_exec($ch);
			curl_close($ch); 

			$finalResponse = json_decode($response);
			$refund = $finalResponse->refund;

			$inst = MojoPaymentDetails::where('payment_id',$payment_id)->first();
			$user_id = $inst->user_id;

	    	$refund_record = MojoRefundDetails::create(['user_id' => $user_id,
													   'refund_id' => $refund->refund_id,
													   'payment_id' => $payment_id,
													   'status' => $refund->status,
													   'type' => $refund->type,
													   'body' => $refund->body,
													   'refund_amount' => $refund->refund_amount,
													   'total_amount' => $refund->total_amount,
													 ]);

			DB::commit();
			return $refund_record;
		}

		catch(Exception $e)
		{
			DB::rollback();
			return false;
		}
	}

	public static function allRefunds()
	{
		 return $allRefundDetails = MojoRefundDetails::all();
	}

	public static function allRefundsFor(User $user)
	{
		return $userSpecificDetails = MojoRefundDetails::where('user_id',$user->id)->get();
	}

}

?>