<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiMessage extends Model
{
    protected $table = 'api_messages';

    protected $fillable =[
        'id',
        'num_media',
        'body',
        'to',
        'from',
        'api_version',
        'num_segments',
        'media_content_type',
        'media_url',
        'message_sid'
    ];
}
