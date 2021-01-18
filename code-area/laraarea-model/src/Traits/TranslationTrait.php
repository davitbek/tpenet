<?php

namespace LaraAreaModel\Traits;

trait TranslationTrait
{
    /**
     * @var
     */
    protected $translateable;

    /**
     * Define all translations relations
     *
     * @return mixed
     */
    public function translations()
    {
        return $this->hasMany(get_class($this), 'parent_id');
    }

    /**
     * Get all translateable cols
     *
     * @return mixed
     */
    public function getTranslateAbleColumns()
    {
        return $this->translateable ?? $this->getFillable();
    }

    /**
     * Define relationships main means initial data need translate
     *
     * @return mixed
     */
    public function main()
    {
        return $this->belongsTo(get_class($this), 'parent_id');
    }

    /**
     * Get Translation
     *
     * @return mixed
     */
    public function getTranslationAttribute()
    {
        return $this->translations->first();
    }

    /**
     * Get actions for translations
     *
     * @param $group
     * @return array
     */
    public function getActions($group = self::PAGINATE_GROUP)
    {
        if ($group == \ConstIndexableGroup::TRANSLATIONS) {
            return [
                'list' => ['edit', 'show', 'destroy'],
                'is_separate' => true,
                'label' => 'Actions'
            ];
        }

        return [
            'list' => ['edit', 'show', 'translations.index', 'destroy'],
            'is_separate' => true,
            'label' => 'Actions'
        ];
    }

    /**
     * @return mixed|string
     */
    public function getLanguageAttribute()
    {
        $languages = config('languages');
        return $languages[$this->attributes['lang']] ?? 'Unknown';
    }

    /**
     * @param bool $makeProperty
     * @param null $lang
     * @param string $langCol
     * @return $this
     */
    public function translate($makeProperty = true, $lang = null, $langCol = 'lang')
    {
        if (key_exists('translations', $this->relations)) {
            $this->traslation = $this->translations->where($langCol, $lang)->first();
        } else {
            $this->traslation = null;
        }

        $translationAbleColumns = $this->getTranslateAbleColumns();
        if ($makeProperty) {
            foreach ($translationAbleColumns as $column) {
                if (key_exists($column, $this->attributes)) {
                    $this->{$column . '_translated'} = $this->traslation->{$column} ?? $this->{$column};
                }
            }
            return $this;
        }

        foreach ($translationAbleColumns as $column) {
            if (key_exists($column, $this->attributes)) {
                $this->{$column} = $this->traslation->{$column} ?? $this->{$column};
            }
        }

        return $this;
    }
}
