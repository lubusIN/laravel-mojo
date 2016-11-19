<?php

namespace Lubus\Mojo\Models;

use Illuminate\Database\Eloquent\Model;

class MojoTransactionDetails extends Model
{
    protected $table = 'mojo_transaction_details';

    protected $fillable = ['user_id','buyer_email','buyer_name','buyer_phone','currency','amount','fees','longurl','payment_id',
    					   'payment_request_id','purpose','shorturl','request_status','payment_status',];
}

?>