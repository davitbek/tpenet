<?php

namespace Api\V1\Services;

class PurchaseService extends BaseService
{
    public function _create($data)
    {
        $item = parent::_create($data);
        if ($item) {
            $user = $this->getAuth();
            $user->update(['is_subscriber' => 1]);
        }
        return $item;
    }

    public function fixDataForCreate($data)
    {
        $user = $this->getAuth();
        $data['user_id'] = $user->id;
        $data['purchase_date'] = now()->toDateTimeString();
        $data['end_date'] = now()->addMonth($data['type'])->toDateTimeString();
        return $data;
    }

    public function createRules()
    {
        return [
            'type' => 'required|in:1,3', // @TODO use class constant
        ];
    }
}
