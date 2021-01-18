<?php

namespace Api\V1\Services;

use Api\V1\Validators\MailValidator;
use App\Mail\SendContact;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class MailService extends BaseService
{
    /**
     * MailService constructor.
     * @param null $model
     * @param null $validator
     */
    public function __construct($model = null, $validator = null)
    {
        $validator = App::make(MailValidator::class);
        parent::__construct($model, $validator);
    }

    /**
     * @param $data
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function sendContactMessage($data)
    {
        $this->validate($data, 'sendContactMessage');
        Mail::to(config('mail.from.address'))->send(new SendContact(collect($data)->only(['email', 'name', 'message'])));
    }

}
