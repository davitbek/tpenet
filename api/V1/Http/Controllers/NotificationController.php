<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authNotifications(Request $request)
    {
        $notificationSettings = $this->getAuth()->notification_settings;
        $notificationConfig = collect(config('app_settings'));
        $notiTypes = collect();
        $configCols = [
            'system',
            'follow',
            'following_add_tips',
            'tip_ended',
        ];
        foreach ($configCols as $col) {
            if ($notificationSettings->{$col}) {
                $notiTypes = $notiTypes->merge($notificationConfig->where('notification_column', $col));
            }
        }

        $options = [
            'where_in' => [
                'notifiable_id' => [$this->getAuthId()],
                'type' => $notiTypes->keys()->all()
            ],
            'order_by_raw' => [
                'IF (read_at IS NULL, 0, 1)'
            ],
            'order_by' => [
                'created_at' => 'desc',
            ]
        ];
        $request->merge($options);
        return $this->index($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUnreadNotificationsCount(Request $request)
    {
        $options = [
            'where_in' => [
                'notifiable_id' => [0, $this->getAuthId()],
            ],
            'where' => [
                'read_at' => null
            ],
            'order_by' => [
                'created_at' => 'desc'
            ],
            'count' => true
        ];
        $result = $this->service->index($options);
        return $this->response->success(['count' => $result]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeAllAsRead(Request $request)
    {
        Notification::whereIn('notifiable_id', [0, $this->getAuthId()])->whereNull('read_at')->update([
            'read_at' => now()
        ]);
        return $this->response->success(['is_updated' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeRead($id, Request $request)
    {
        /**
         * @var $notification Notification
         */
        $notification  = $this->getAuth()->notifications()->find($id);
        if (empty($notification)) {
            return $this->response->notFoundItem($request, \ConstErrorCodes::NOTIFICATION_NOT_FOUND, 'Notification not found');
        }

        if ($notification->read()) {
            $notification->markAsUnread();
        } else {
            $notification->markAsRead();
        }

        return $this->response->success(['is_updated' => true, 'read_at' => $notification->read_at, 'id' => $notification->id]);
    }
}
