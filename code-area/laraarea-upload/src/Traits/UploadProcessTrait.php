<?php

namespace LaraAreaUpload\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use LaraAreaUpload\Interfaces\UploadInterface;

/**
 *  @property Model|UploadInterface|UploadableTrait $model
 * Trait UploadProcessTrait
 * @package LaraAreaUpload\Traits
 */
trait UploadProcessTrait
{
    /**
     * Upload attribute related file
     *
     * @param $data
     * @param $attribute
     * @param null $key
     * @param string $disk
     * @param null $rootPath
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function upload($data, $attribute, $key = null, $disk = 'public', $rootPath = null)
    {
        $key = $key ?? $attribute;
        $fileData = \Arr::get($data, $key);
        $file = $fileData['file'] ?? null;
        if ($file && is_a($file, UploadedFile::class)) {
            // @TODO fix log image name, crop
            /* @var $file UploadedFile*/
            $filename = $this->getFileName($file, $fileData);

            $uploadFolderPath = $this->model->getUploadFolderPath($attribute, $rootPath);
            \Storage::disk($disk)->putFileAs($uploadFolderPath, $file, $filename);
            $data[$this->model->getDiskName($attribute)] = $disk;
            $data[$attribute] = $filename;
            $this->model->cacheUploadExists($disk, $uploadFolderPath, $filename, true);
        } else {
            unset($data[$key]);
        }

        return $data;
    }

    /**
     * Upload attribute related file
     *
     * @param $data
     * @param $attribute
     * @param null $key
     * @param string $disk
     * @param null $rootPath
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function uploadSubFile($fileData, $source, $value, $attribute, $disk = 'public', $rootPath = null)
    {
        $file = $fileData['file'] ?? null;
        if ($file && is_a($file, UploadedFile::class)) {
            // @TODO fix log image name, crop
            /* @var $file UploadedFile*/
            $filename = $this->model->getDefaultUpload();
            $uploadFolderPath = $this->model->getUploadSubFolderPath($attribute, $source . '/' . $value, $rootPath);
            \Storage::disk($disk)->putFileAs($uploadFolderPath, $file, $filename);
            $this->model->cacheUploadExists($disk, $uploadFolderPath, $filename, true);
        }
    }

    /**
     * Get filename where must be upload file
     *
     * @param UploadedFile $file
     * @param $fileData
     * @param string $attribute
     * @return mixed|string|null
     */
    protected function getFileName(UploadedFile $file, $fileData, $attribute = 'name')
    {
        if (!empty($fileData[$attribute])) {
            return $this->correctFileName($file, $fileData[$attribute]);
        }

        return $file->getClientOriginalName();
    }

    /**
     * Process upload file name
     *
     * @param UploadedFile $file
     * @param $filename
     * @return mixed|string
     */
    protected function correctFileName(UploadedFile $file, $filename)
    {
        $extension = $file->getClientOriginalExtension();
        $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
        if (empty($fileExtension)) {
            return $filename . '.' . $extension;
        }

        return str_replace($extension, $fileExtension, $filename);
    }
}
