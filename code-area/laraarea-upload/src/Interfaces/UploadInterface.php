<?php

namespace LaraAreaUpload\Interfaces;

use Illuminate\Http\UploadedFile;

interface UploadInterface
{
    /**
     * Get Default upload
     *
     * @return string|null
     */
    public function getDefaultUpload();

    /**
     * Set Default upload
     *
     * @return string|null
     */
    public function setDefaultUpload($value);

    /**
     * Get uploadable columns
     *
     * @return array
     */
    public function getUploadable();

    /**
     * Set uploadable columns
     *
     * @param array $value
     * @return $this
     */
    public function setUploadable(array  $value);

    /**
     * Upload file
     *
     * @param UploadedFile $file
     * @param $attribute
     * @param $filename
     * @param null $disk
     * @param array $options
     * @param null $rootPath
     * @return false|string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function uploadByFile(UploadedFile $file, $attribute, $filename, $disk = null, $options = [], $rootPath = null);

    /**
     * Upload Defaut File
     *
     * @param UploadedFile $file
     * @param $attribute
     * @param array $options
     * @param null $rootPath
     * @return false|string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function uploadDefaultFile(UploadedFile $file, $attribute, $options = [], $rootPath = null);

    /**
     * Upload file by conetnet
     *
     * @param $fileContent
     * @param $attribute
     * @param $filename
     * @param null $disk
     * @param array $options
     * @param null $rootPath
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function uploadByFileContent($fileContent, $attribute, $filename, $disk = null, $options = [], $rootPath = null);

    /**
     * Get url for acces uploaded file
     *
     * @param $attribute
     * @param null $rootPath
     * @return mixed
     */
    public function getUrlByAttribute($attribute, $rootPath = null);

    /**
     * Return default value if no any uploaded file
     *
     * @param $attribute
     * @param null $rootPath
     * @return string
     */
    public function getDefaultUploadUrl($attribute, $rootPath = null);

    /**
     * Return default value if no any uploaded file
     *
     * @param $attribute
     * @param null $rootPath
     * @return string
     */
    public static function defaultUploadUrl($attribute, $rootPath = null);

    /**
     * Cache uploaded file exists or not
     *
     * @return mixed
     */
    public function isUploadExists($disk, $uploadFolderPath, $filename);

    /**
     * Set upload exists by that disk
     * Must be use when one file deleted, moved other disk, ..etc
     *
     * @param $disk
     * @param $uploadFolderPath
     * @param $filename
     * @param bool $isExists
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function cacheUploadExists($disk, $uploadFolderPath, $filename, $isExists = true);

    /**
     * Get unique cache key for each disk, file, uploadpath
     *
     * @param $disk
     * @param $uploadPath
     * @param $filename
     * @return string
     */
    public function getCacheKey($disk, $uploadPath, $filename);

    /**
     * Get uploaded file full name
     *
     * @param $attribute
     * @param null $rootPath
     * @return string
     */
    public function getUploadFullPath($attribute, $rootPath = null);

    /**
     * Get folder path where must be upload file
     *
     * @param $attribute
     * @param null $rootPath
     * @return string
     */
    public function getUploadFolderPath($attribute, $rootPath = null);

    /**
     * Get folder path where must be upload file
     *
     * @param $attribute
     * @param null $rootPath
     * @return string|null
     */
    public function getDefaultUploadFolderPath($attribute, $rootPath = null);

    /**
     * Get disk where must uploaded file
     *
     * @param $attribute
     * @return string
     */
    public function getDisk($attribute);

    /**
     * Get default uploaded disks
     *
     * @return string
     */
    public function getDefaultDisk();

    /**
     * Get attribute corresond disk name
     *
     * @return string
     */
    public function getDiskName($attribute);

    /**
     * Get uploaded related attribute name
     *
     * @param $uploadAttribute
     * @param string $attribute
     * @return string
     */
    public function getUploadRelatedName($uploadAttribute, $attribute = '');
}