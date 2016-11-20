<?php

namespace Lubus\Mojo\Models;

use Illuminate\Database\Eloquent\Model;

class MojoRefundDetails extends Model
{
    protected $table = 'mojo_refund_details';

    protected $fillable = ['user_id','refund_id','payment_id','status','type','body','refund_amount','total_amount',];
}

?>