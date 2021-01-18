<?php

namespace LaraAreaUpload\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Trait UploadableTrait
 * @package LaraAreaModel\Traits
 */
trait UploadableTrait
{
    /**
     * Default upload name when no any upload data
     *
     * @var
     */
    protected $defaultUpload;

    /**
     * Uploadabale columns
     *
     * @var
     */
    protected $uploadable;

    /**
     * Used for local cache
     *
     * @var array
     */
    protected $_uploadable = [];

    /**
     * Get Default upload
     *
     * @return string|null
     */
    public function getDefaultUpload()
    {
        return $this->defaultUpload;
    }

    /**
     * Set Default upload
     *
     * @return string|null
     */
    public function setDefaultUpload($value)
    {
        $this->defaultUpload = $value;
        return $this;
    }

    /**
     * Get uploadable columns
     *
     * @return array
     */
    public function getUploadable()
    {
        if (! empty($this->uploadable)) {
            return $this->uploadable;
        }

        $uploadable = [];
        $fillable = $this->getFillable();
        foreach ($fillable as $column) {
            if (Str::endsWith($column, '_path')) {
                $uploadable[] = $column;
            }
        }

        return $uploadable;
    }

    /**
     * Set uploadable columns
     *
     * @param array $value
     * @return $this
     */
    public function setUploadable(array  $value)
    {
        $this->uploadable = $value;
        return $this;
    }

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
    public function uploadByFile(UploadedFile $file, $attribute, $filename, $disk = null, $options = [], $rootPath = null)
    {
        $disk = $disk ?? $this->getDiskName($attribute);
        $uploadFolderPath = $this->getUploadFolderPath($attribute, $rootPath);
        $isUploaded = \Storage::disk($disk)->putFileAs($uploadFolderPath, $file, $filename, $options);
        $this->cacheUploadExists($disk, $uploadFolderPath, $filename, true);
        return $isUploaded;
    }

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
    public function uploadDefaultFile(UploadedFile $file, $attribute, $options = [], $rootPath = null)
    {
        $filename = $this->getDefaultUpload();
        $disk = $this->getDefaultDisk();
        $uploadFolderPath = $this->getDefaultUploadFolderPath($attribute, $rootPath);
        $isUploaded = \Storage::disk($disk)->putFileAs($uploadFolderPath, $file, $filename, $options);
        $this->cacheUploadExists($disk, $uploadFolderPath, $filename, true);
        return $isUploaded;
    }

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
    public function uploadByFileContent($fileContent, $attribute, $filename, $disk = null, $options = [], $rootPath = null)
    {
        unset( $this->_uploadable[$attribute]);
        $disk = $disk ??$this->getDiskName($attribute);
        $uploadFolderPath = $this->getUploadFolderPath($attribute, $rootPath);
        $fullPath = $uploadFolderPath . '/' . $filename;
        $isUploaded = Storage::disk($disk)->put($fullPath, $fileContent, $options);
        $this->cacheUploadExists($disk, $uploadFolderPath, $filename, true);
        return $isUploaded;
    }

    /**
     * Get url for acces uploaded file
     *
     * @param $attribute
     * @param $source
     * @param $value
     * @param null $rootPath
     * @return mixed
     */
    public function getSubUrlBy($source, $value, $attribute, $rootPath = null, $useMain = true)
    {
        $filename = $this->getDefaultUpload();
        $sourceAttribute = $source . '_' . $value . '_' . $filename;

        if (key_exists($sourceAttribute, $this->_uploadable)) {
            return $this->_uploadable[$sourceAttribute];
        }

        $uploadFolderPath = $this->getUploadSubFolderPath($attribute, $source . '/' . $value, $rootPath);
        $disk = $this->getDisk($attribute);
        $isExists = $this->isUploadExists($disk, $uploadFolderPath, $filename);
        if ($isExists) {
            $fullPath = $uploadFolderPath . '/' . $filename;
            $fullPath = $uploadFolderPath . '/' . $filename;
            $this->_uploadable[$sourceAttribute] = Storage::disk($disk)->url($fullPath);
        } else {
            $this->_uploadable[$sourceAttribute] = $useMain ? $this->getUrlByAttribute($attribute, $rootPath) : '';
        }

        return $this->_uploadable[$sourceAttribute];
    }

    /**
     * Get url for acces uploaded file
     *
     * @param $attribute
     * @param null $rootPath
     * @return mixed
     */
    public function getUrlByAttribute($attribute, $rootPath = null)
    {
        if (key_exists($attribute, $this->_uploadable)) {
            return $this->_uploadable[$attribute];
        }

        $filename = $this->attributes[$attribute] ?? '';
        $disk = $this->getDisk($attribute);
        if (empty($filename)) {
            $this->_uploadable[$attribute] = $this->getDefaultUploadUrl($attribute, $rootPath);
            return $this->_uploadable[$attribute];
        }

        $uploadFolderPath = $this->getUploadFolderPath($attribute, $rootPath);
        $isExists = $this->isUploadExists($disk, $uploadFolderPath, $filename);

        if ($isExists) {
            $fullPath = $uploadFolderPath . '/' . $filename;
            $this->_uploadable[$attribute] = Storage::disk($disk)->url($fullPath);
        } else {
            $this->_uploadable[$attribute] = $this->getDefaultUploadUrl($attribute, $rootPath);
        }

        return $this->_uploadable[$attribute];
    }

    /**
     * Return default value if no any uploaded file
     *
     * @param $attribute
     * @param null $rootPath
     * @return string
     */
    public function getDefaultUploadUrl($attribute, $rootPath = null)
    {
        $defaultUpload = $this->getDefaultUpload();
        if (empty($defaultUpload)) {
            return '';
        }

        $disk = $this->getDisk($attribute);
        $uploadFolderPath = $this->getDefaultUploadFolderPath($attribute, $rootPath);
        $fullPath = $uploadFolderPath . '/' . $defaultUpload;
        $isExists = $this->isUploadExists($disk, $uploadFolderPath, $defaultUpload);

        return $isExists ? Storage::disk($disk)->url($fullPath) : '';
    }

    /**
     * Return default value if no any uploaded file
     *
     * @param $attribute
     * @param null $rootPath
     * @return string
     */
    public static function defaultUploadUrl($attribute, $rootPath = null)
    {
        $instance = new static();
        $defaultUpload = $instance->getDefaultUpload();
        if (empty($defaultUpload)) {
            return '';
        }

        $disk = $instance->getDisk($attribute);
        $uploadFolderPath = $instance->getDefaultUploadFolderPath($attribute, $rootPath);
        $fullPath = $uploadFolderPath . '/' . $defaultUpload;
        $isExists = $instance->isUploadExists($disk, $uploadFolderPath, $defaultUpload);

        return $isExists ? Storage::disk($disk)->url($fullPath) : '';
    }

    /**
     * Cache uploaded file exists or not
     *
     * @return mixed
     */
    public function isUploadExists($disk, $uploadFolderPath, $filename)
    {
        $fullPath = $uploadFolderPath . '/' . $filename;
        $cacheKay =  $this->getCacheKey($disk, $uploadFolderPath, $filename);
        return Cache::remember($cacheKay, 24 * 60 * 60, function () use ($disk, $fullPath) {
            return Storage::disk($disk)->exists($fullPath);
        });
    }

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
    public function cacheUploadExists($disk, $uploadFolderPath, $filename, $isExists = true)
    {
        $cacheKay =  $this->getCacheKey($disk, $uploadFolderPath, $filename);
        Cache::set($cacheKay, $isExists, 24 * 60 * 60);
    }

    /**
     * Get unique cache key for each disk, file, uploadpath
     *
     * @param $disk
     * @param $uploadPath
     * @param $filename
     * @return string
     */
    public function getCacheKey($disk, $uploadPath, $filename)
    {
        return $cacheKay = 'uploads_' . $disk . '_' . $uploadPath . '_' . $filename;
    }

    /**
     * Get uploaded file full name
     *
     * @param $attribute
     * @param null $rootPath
     * @return string
     */
    public function getUploadFullPath($attribute, $rootPath = null)
    {
        return $this->getUploadFolderPath($attribute, $rootPath) . '/' . $this->{$attribute};
    }

    /**
     * Get folder path where must be upload file
     *
     * @param $attribute
     * @param null $rootPath
     * @return string
     */
    public function getUploadFolderPath($attribute, $rootPath = null)
    {
        $prePtah = $this->getUploadRootPath($attribute, $rootPath);
        if ($this->includeAttributeNameInPath($attribute)) {
            $prePtah .= $attribute ? '/' . $this->processPathAttribute($attribute) : '';
        }

        return $this->includeIdInPath($attribute) ? $prePtah . '/' .  $this->getKey() : $prePtah ;
    }

    /**
     * Get folder path where must be upload file
     *
     * @param $attribute
     * @param null $rootPath
     * @return string
     */
    public function getUploadSubFolderPath($attribute, $subPath, $rootPath = null)
    {
        return $this->getUploadFolderPath($attribute, $rootPath) . '/' . $subPath;
    }

    /**
     * Get folder path where must be upload file
     *
     * @param $attribute
     * @param null $rootPath
     * @return string|null
     */
    public function getDefaultUploadFolderPath($attribute, $rootPath = null)
    {
        $prePtah = $this->getUploadRootPath($attribute, $rootPath);
        if ($this->includeAttributeNameInPath($attribute)) {
            $prePtah .= $attribute ? '/' . $this->processPathAttribute($attribute) : '';
        }

        return $prePtah;
    }

    /**
     * Get disk where must uploaded file
     *
     * @param $attribute
     * @return string
     */
    public function getDisk($attribute)
    {
        $attribute = $this->getDiskName($attribute);
        return  $this->attributes[$attribute] ?? $this->getDefaultDisk();
    }

    /**
     * Get default uploaded disks
     *
     * @return string
     */
    public function getDefaultDisk()
    {
        return 'local';
    }

    /**
     * Get attribute corresond disk name
     *
     * @return string
     */
    public function getDiskName($attribute)
    {
        return $this->getUploadRelatedName($attribute, 'disk');
    }

    /**
     * Get uploaded related attribute name
     *
     * @param $uploadAttribute
     * @param string $attribute
     * @return string
     */
    public function getUploadRelatedName($uploadAttribute, $attribute = '')
    {
        if ($attribute && ! Str::startsWith($attribute, '_')) {
            $attribute = '_' . $attribute;
        }
        return Str::replaceLast('_path', '', $uploadAttribute) . $attribute;
    }

    /**
     * Determine is need save each attribute related file separte folder or not
     *
     * @param $attribute
     * @return bool
     */
    protected function includeAttributeNameInPath($attribute)
    {
        return count($this->getUploadable()) > 1;
    }

    /**
     * Determine include resource id in path
     *
     * @param $attribute
     * @return bool
     */
    protected function includeIdInPath($attribute)
    {
        return false;
    }

    /**
     * Process folder name where must be save uploaded filr
     *
     * @param $attribute
     * @return string
     */
    protected function processPathAttribute($attribute)
    {
        return Str::plural($this->getUploadRelatedName($attribute));
    }

    /**
     * Get upload root path
     *
     * @param $attribute
     * @param null $rootPath
     * @return mixed|null
     */
    public function getUploadRootPath($attribute, $rootPath = null)
    {
        if ($rootPath) {
            return $rootPath;
        }

        return $this->getRootResource();
    }

    /**
     * @return mixed
     */
    protected function getRootResource()
    {
        return  method_exists($this, 'getResource') ? $this->getResource() : $this->getTable();
    }
}