<?php

namespace LaraAreaUpload\Rules;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Validator;
use LaraAreaUpload\Traits\UploadProcessTrait;
use LaraAreaValidator\Rules\CustomRule;

class UniqueUploadRule extends CustomRule
{
    use UploadProcessTrait;

    /**
     *
     */
    public const FILE_REQUIRED = '_file_required_';

    /**
     * Rule name
     *
     * @var string
     */
    protected $rule = 'upload_unique';

    /**
     * Validate incoming file is unique or not
     *
     * @param $name
     * @param $value
     * @param $parameters
     * @param Validator $validator
     * @return bool
     */
    public function validate($name, $value, $parameters, Validator $validator)
    {
        if (empty($parameters[0])) {
            throw new \InvalidArgumentException('Second parameter is required for upload_unique validation');
        }

        if (! is_array($value)) {
            $this->setMessage(__('validation.array'));
            return false;
        }


        list($query, $primaryKey) = $this->getQueryAndKey($parameters);
        $requiredParameter = $parameters[0] ?? false;
        if ($requiredParameter == self::FILE_REQUIRED) {
            if (empty($value['file'])) {
                $this->setMessage('Please Upload file');
                return false;
            }

            if (!is_a($value['file'], UploadedFile::class)) {
                $this->setMessage('Please Upload file');
                return false;
            }

            array_shift($parameters);
        } elseif(empty($value['file'])) {
            return true;
        }

        $data = $validator->getData();
        $id = $data[$primaryKey] ?? null;
        $fileName = $this->getFileName($value['file'], $value);

        if ($id) {
            $query->where($primaryKey, '!=', $id);
        }

        $uploadColumn = array_shift($parameters);
        $uploadColumn = $uploadColumn ?? $name;
        $isExists = $query->where($uploadColumn, $fileName)->exists();
        if ($isExists) {
            $name = str_replace( '_path', '', $name);
            $this->setMessage(humanize($name) . ' with this [' . $fileName . ']name already exists');
            return false;
        }

        return true;
    }

    /**
     * Get query buildier and primary key
     *
     * @param $parameters
     * @return array
     */
    protected function getQueryAndKey(&$parameters)
    {
        $paramModel = array_shift($parameters);
        if (empty($paramModel)) {
            throw new \InvalidArgumentException('Second parameter is required for upload_unique validation');
        }

        if (class_exists($paramModel)) {
            $model = \App::make($paramModel);
            $primaryKey = $model->getKeyName();
            $query = $model->newQuery();
        } else {
            $primaryKey = 'id';
            $table = $paramModel;
            $query = \DB::table($table);
        }

        return [$query, $primaryKey];
    }


}
