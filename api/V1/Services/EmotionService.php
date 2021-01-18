<?php

namespace Api\V1\Services;

use Api\V1\Models\Emotion;
use Api\V1\Models\EmotionablePivot;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use LaraAreaApi\Exceptions\ApiException;

class EmotionService extends BaseService
{
    /**
     * EmotionService constructor.
     * @param Emotion|null $model
     * @param null $validator
     */
    public function __construct(Emotion $model = null, $validator = null)
    {
        parent::__construct($model, $validator);
    }

    /**
     * @param $emotionId
     * @param $type
     * @param $relatedId
     * @return mixed
     * @throws ApiException
     */
    public function assignEmotionToItem($relatedId, $type, $emotionId)
    {
        return $this->assignItemToEmotion($emotionId, $type, $relatedId);
    }

    /**
     * @param $emotionId
     * @param $type
     * @param $relatedId
     * @return mixed
     * @throws ApiException
     */
    public function assignItemToEmotion($emotionId, $type, $relatedId)
    {
        $userId = $this->getAuthUserId();
        $emotion = $this->find($emotionId);
        if (empty($emotion)) {
            throw new ApiException(\ConstErrorCodes::NOT_FOUND, __('mobile.emotion.not_found'));
        }

        if (! method_exists($emotion, $type)) {
            throw new ApiException(\ConstErrorCodes::NOT_PERMITTED, __('mobile.emotion.not_permitted_type', ['type' => $type]));
        }

        /**
         * @var $morpho MorphToMany
         */
        $morpho = $emotion->{$type}();
        if (! $morpho->getRelated()->newQuery()->whereKey($relatedId)->exists()) {
            throw new ApiException(\ConstErrorCodes::NOT_FOUND,  __('mobile.emotion.wrong_emotionalble_id', ['type' => $type]));
        }

        $pivote = $morpho->newPivot();
        $oldEmotion = $pivote->where([
                'emotionable_type' =>  $morpho->getMorphClass(),
                'emotionable_id' =>  $relatedId,
                'user_id' =>  $userId,
            ])->first();

        if ($oldEmotion) {
            if ($oldEmotion->emotion_id != $emotionId) {
                $oldEmotion->update(['emotion_id' => $emotionId]);
            }
            return $oldEmotion;
        }

        return $pivote->create([
            'emotionable_type' =>  $morpho->getMorphClass(),
            'emotionable_id' =>  $relatedId,
            'emotion_id' =>  $emotionId,
            'user_id' =>  $userId,
        ]);
    }

    /**
     * @param $emotionId
     * @param $type
     * @param $relatedId
     * @return mixed
     * @throws ApiException
     */
    public function unassignEmotionFromItem($relatedId, $type, $emotionId)
    {
        return $this->unassignItemFromEmotion($emotionId, $type, $relatedId);
    }

    /**
     * @param $emotionId
     * @param $type
     * @param $relatedId
     * @return mixed
     * @throws ApiException
     */
    public function unassignItemFromEmotion($emotionId, $type, $relatedId)
    {
        if (! method_exists($this->model, $type)) {
            throw new ApiException(\ConstErrorCodes::NOT_PERMITTED, __('mobile.emotion.not_permitted_type', ['type' => $type]));
        }

        /**
         * @var $morpho MorphToMany
         */
        $userId = $this->getAuthUserId();
        $morpho = $this->model->{$type}();

        $oldEmotion = (new EmotionablePivot())->where([
            'emotionable_type' =>  $morpho->getMorphClass(),
            'emotionable_id' =>  $relatedId,
            'user_id' =>  $userId,
            'emotion_id' => $emotionId,
        ])->first();

        if ($oldEmotion) {
            (new EmotionablePivot())->where([
                'emotionable_type' =>  $morpho->getMorphClass(),
                'emotionable_id' =>  $relatedId,
                'user_id' =>  $userId,
                'emotion_id' => $emotionId,
            ])->delete();
            $oldEmotion->exists = false;
            return $oldEmotion;
        }

        throw new ApiException(\ConstErrorCodes::ReactedEmotionNotFound, __('mobile.emotion.no_emotion', ['type' => $type]));
    }
}
