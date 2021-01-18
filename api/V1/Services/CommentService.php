<?php

namespace Api\V1\Services;

use Api\V1\Models\Comment;
use LaraAreaApi\Exceptions\ApiException;

class CommentService extends BaseService
{
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $aliases;

    /**
     * @var Comment
     */
    protected $model;

    public function __construct(Comment $model, $validator = null)
    {
        parent::__construct($model, $validator);
        $this->aliases = config('codearea_comments.aliases');
    }

    /**
     * @param $commentableType
     * @param $commentableId
     * @param $options
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws ApiException
     */
    public function commentsByType($commentableType, $commentableId, $options)
    {
        $type = $this->aliases[$commentableType] ?? $commentableType;
        $permittedTypes = $this->model->getPermittedCommentableTypes();
        if (! in_array($type, $permittedTypes)) {
            throw new ApiException(\ConstErrorCodes::NOT_PERMITTED_COMMENT_TYPE, __('mobile.comment.This type is not permitted'));
        }

        $commentbleModel = array_flip($permittedTypes)[$type];
        $ifExists = $commentbleModel::whereKey($commentableId)->exists();
        if (! $ifExists) {
            throw new ApiException(\ConstErrorCodes::COMMENTABLE_INSTANCE_NOT_FOUND, __('mobile.comment.invalid_type', compact('type')));
        }

        $optionDynamic = [
            'where' => [
                'commentable_type' => $type,
                'commentable_id' => $commentableId,
                'parent_id' => null
            ],
//            'latest'=> true,
            'with_count' => ['sub_comments', 'emotions'],
            'with' => [
                'user' => [
                    'columns' => [
                        'id',
                        'name',
                        'profile_disk',
                        'profile_path'
                    ]
                ],
                'emotions' => [
                    'columns' => [
                        'emotions.id',
                        'emotions.name',
                        'emotions.image_path',
                    ],
                    'order_by' => 'position'
                ],
                'sub_comments' => [
                    'select' => [
                        '*',
                    ],
                    'group_by' => 'parent_id',
                    'latest'=> true,
                    'with_count' => ['emotions'],
                    'with' => [
                        'user' => [
                            'columns' => [
                                'id',
                                'name',
                                'profile_disk',
                                'profile_path',
                            ]
                        ],
                        'emotions' => [
                            'columns' => [
                                'emotions.id',
                                'emotions.name',
                                'emotions.image_path',
                            ],
                            'order_by' => 'position'
                        ],
                    ]
                ]
            ],
        ];
        return $this->index(array_merge($optionDynamic, $options));
    }

    /**
     * @param $commentId
     * @param $options
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws ApiException
     */
    public function subComments($commentId, $options)
    {
        $comment = $this->model->whereKey($commentId)->first();
        if (! $comment) {
            throw new ApiException(\ConstErrorCodes::COMMENTABLE_INSTANCE_NOT_FOUND, __('mobile.comment.invalid_comment'));
        }
        if ($comment->parent_id) {
            throw new ApiException(\ConstErrorCodes::COMMENTABLE_INSTANCE_NOT_FOUND, __('mobile.comment.invalid_main_comment'));
        }

        $optionDynamic = [
            'where' => [
                'parent_id' => $commentId
            ],
            'with' => [
                'user' => [
                    'columns' => [
                        'id',
                        'name',
                        'profile_disk',
                        'profile_path'
                    ]
                ],
                'emotions' => [
                    'columns' => [
                        'emotions.id',
                        'emotions.name',
                        'emotions.image_path',
                    ],
                    'order_by' => 'position'
                ]
            ],
            'with_count' => 'emotions',
            'paginate' => true,
            'per_page' => 200
        ];
        return $this->index(array_merge($optionDynamic, $options));
    }


    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws ApiException
     */
    public function create($data)
    {
        $permittedTypes = $this->model->getPermittedCommentableTypes();
        $this->validate($data, [
            'comment' => 'required|max:500',
            'commentable_type' => 'required|in:' . implode(',', array_merge($permittedTypes, array_keys($this->aliases))),
            'commentable_id' => 'required:integer'
        ]);

        $commentAbleTypes = $this->aliases;
        $commentbleType = $commentAbleTypes[$data['commentable_type']] ?? $data['commentable_type'];

        $commentbleModel = array_flip($permittedTypes)[$commentbleType];
        $ifExists = $commentbleModel::whereKey($data['commentable_id'])->exists();
        if (! $ifExists) {
            throw new ApiException(\ConstErrorCodes::COMMENTABLE_INSTANCE_NOT_FOUND, __('mobile.comment.invalid_type', ['type' => $commentbleType ]));
        }

        $data['commentable_type'] = $commentbleType;
        $data['user_id'] = $this->getAuthUserId();

        return $this->_create($data);
    }

    /**
     * @param $commentId
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws ApiException
     */
    public function createSubComment($commentId, $data)
    {
        $this->validate($data, [
            'comment' => 'required|max:500',
        ]);

        $comment = $this->model->whereKey($commentId)->first();
        if (! $comment) {
            throw new ApiException(\ConstErrorCodes::COMMENTABLE_INSTANCE_NOT_FOUND, __('mobile.comment.invalid_comment'));
        }

        $parentId = $comment->parent_id ?? $commentId;
        $data['parent_id'] = $parentId;
        $data['user_id'] = $this->getAuthUserId();

        return $this->_create($data);
    }

    public function update($id, $data)
    {
        $this->validate($data, [
            'comment' => 'required|max:500',
        ]);

        $comment = $this->model->whereKey($id)->first();
        if (! $comment) {
            throw new ApiException(\ConstErrorCodes::COMMENTABLE_INSTANCE_NOT_FOUND, __('mobile.comment.invalid_comment'));
        }

        $userId = $this->getAuthUserId();
        if ($comment->user_id != $userId) {
            throw new ApiException(\ConstErrorCodes::NOT_PERMITTED, __('mobile.comment.not_your_comment'));
        }


        return $this->_updateExisting($comment, $data); // TODO: Change the autogenerated stub
    }

    /**
     * @param $item
     * @return mixed
     * @throws ApiException
     */
    public function deleteExisting($item)
    {
        if ($item->user_id != $this->getAuthUserId()) {
            throw new ApiException(\ConstErrorCodes::NOT_PERMITTED, __('mobile.comment.not_your_comment'));
        }
        return parent::deleteExisting($item); // TODO: Change the autogenerated stub
    }
}
