<?php

namespace Api\V1\Transformers;

use Api\V1\Models\AuthUser;
use Api\V1\Models\NotificationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthUserTransformer extends \LaraAreaApi\Transformers\AuthTransformer
{
    /**
     * @param AuthUser $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        $allNotificationSettings = Cache::remember('notification_settings', 24 * 60 * 60, function () {
            return \Api\V1\Models\NotificationSetting::whereNull('parent_id')
                ->where('is_active', \ConstYesNo::YES)
                ->with('translations')
                ->get();
        });
        list($notificationSettings, $emailSettings) = $allNotificationSettings->partition(function ($item) {
            return $item->is_notification_setting == 1;
        });

        $notificationConfig = config('api_config.notifications');
        $emailsConfig = config('api_config.emails');
        $userNotificationSettings = $model->notification_settings;
        $userEmailSettings = $model->email_settings;

        $notificationData = [];
        unset($notificationConfig['ios_one_token']);
        unset($notificationConfig['android_one_token']);
        foreach ($notificationConfig as $key => $value) {
            $notificationData[$value] = (bool) $userNotificationSettings->{$key};
        }

        $emailData = [];
        foreach ($emailsConfig as $key => $value) {
            $emailData[$value] = (bool) $userEmailSettings->{$key};
        }
        $response =  [
            'id' => (integer) $model->id,
            'country_id' => (integer) $model->country_id,
            'name' => (string) $model->name,
            'email' => (string) $model->email,
            'odds_type' => (string) $model->odds_type,
            'timezone' => (string) $model->timezone,
            'profile_url' => $model->profile_url,
            'profit' => number_format($userStatistic->profit ?? 0),
            'percent' => round($userStatistic->win_percent ?? 0),
            'bio' => (string) $model->bio,
            'followers_count' => (int) $model->followers_count,
            'following_count' => (int) $model->followings_count,
            'is_active' => (bool) $model->is_active,
            'is_flag' => (bool) $model->is_flag,
            'is_subscriber' => (bool) $model->is_subscriber,
            'phone' => (string) $model->phone,
            'newsletter' => (string) $model->Newsletter,
            'promotions' => (string) $model->Promotions,
            'one_token' => (string) $userNotificationSettings->ios_one_token,
            'ios_one_token' => (string) $userNotificationSettings->ios_one_token,
            'android_one_token' => (string) $userNotificationSettings->android_one_token,
            'lang' => (string) $model->lang,
            'country' => (string) $model->country,
            'birthday' => (string) $model->birthday,
            'role' => (int) $model->role,
            'notification_settings' => $notificationData,
            'notification_settings_extended' => $this->groupNotifications($notificationSettings, $userNotificationSettings, $model->lang),
            'email_settings' => $emailData,
            'email_settings_extended' => $this->groupNotifications($emailSettings, $userEmailSettings, $model->lang),
            'balance' => (int) $model->balance,
            'tip_amount' => number_format($model->tip_amount),
            'tip_profit' => number_format($model->tip_profit),
            'tip_count' => (int) $model->tip_count,
            'tip_win_count' => (int) $model->tip_win_count,
            'tip_lost_count' => (int) $model->tip_lost_count,
            'tip_cash_back_count' => (int) $model->tip_cash_back_count,
            'tip_win_percent' => round($model->tip_win_percent),
            'feedback_rating' => (float) $model->feedback_rating,
        ];

        if ($model->hasAttribute('access_tokens')) {
            $response['access_tokens'] = $model->access_tokens;
        }

        return $response;
    }

    protected function groupNotifications($notifications, $settings, $language)
    {
        $response = [];

        $notifications->translate($language);
        foreach ($notifications->sortBy('position')->groupBy('group_translated') as $group => $items) {
            $groupData = [];
            $subGroupItems = $items->groupBy('sub_group_translated');
            $keys = $subGroupItems->keys()->all();
            if (count($keys) == 1 && empty(head($keys))) {

                foreach ($items as $item) {
                    /* @var $item NotificationSetting*/
                    $groupData[] = [
                        'id' => $item->id,
                        'value' => (bool) $settings->{$item->column},
                        'label' => $item->label_translated,
                        'description' => $item->description_translated,
                        'icon_url' => $item->icon_url,
                    ];
                }

                $response[] = [
                    'has_sub_group' => false,
                    'group' => $group,
                    'data' => $groupData
                ];
                continue;
            }

            foreach ($items->groupBy('sub_group_translated') as $subGroup => $subItems) {
                $subGroupData = [];
                foreach ($subItems as $item) {
                    /* @var $item NotificationSetting*/
                    $subGroupData[] = [
                        'id' => $item->id,
                        'value' => (bool) $settings->{$item->column},
                        'label' => $item->label_translated,
                        'description' => $item->description_translated,
                        'icon_url' => $item->icon_url,
                    ];
                }
                $groupData[] = [
                    'sub_group' => $subGroup,
                    'data' => $subGroupData
                ];
            }
            $response[] = [
                'has_sub_group' => true,
                'group' => $group,
                'data' => $groupData
            ];
        }

        return $response;
    }
}
