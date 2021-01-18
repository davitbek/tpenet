<?php

namespace LaraAreaProperty\Traits;

use Illuminate\Support\Str;

trait DynamicTrait
{
    /**
     * @var int
     */
    protected $mainFolderInDeep = 1;

    /**
     * @var
     */
    protected $rootNamespace;

    /**
     * @var string
     */
    protected $relativeNamespace;

    /**
     * @var array
     */
    protected $namespacesConfig = [
        'resource' => 'Http\Resource',
        'resourceCollection' => 'Http\ResourceCollection'
    ];

    /**
     * @var
     */
    private $classMainName;

    /**
     * Get class name where need inject this property
     *
     * @param $pattern
     * @param string $suffix
     * @param null $default
     * @return string|null
     */
    protected function dynamicClassName($pattern, $suffix = '', $default = null)
    {
        $classPropertyName = $pattern . 'Class';
        $className  = $this->{$classPropertyName}();

        if (! empty($className)) {
            return $className;
        }

        if (! empty($this->{$classPropertyName})) {
            return $this->{$classPropertyName};
        }

        $className =  $this->getNamespace($pattern) . '\\' . $this->getClassMainName() . $suffix;
        if ($default && ! class_exists($className)) {
            $className = $default;
        }

        $this->{$classPropertyName} = $className;
        return $this->{$classPropertyName};
    }

    /**
     * Get fully qualified namespace
     *
     * @param $pattern
     * @return string
     */
    protected function getNamespace($pattern)
    {
        $namespace = $this->getRootNamespace() . $this->getRelativeNamespace();
        $dynamicNamespace = $this->namespacesConfig[$pattern] ?? ucfirst($pattern);
        return $namespace . '\\' . Str::plural($dynamicNamespace) ;
    }

    /**
     * Get relative namespace based root
     *
     * @return string
     */
    protected function getRelativeNamespace()
    {
        return  $this->relativeNamespace;
    }

    /**
     * Get root namespace
     *
     * @return mixed
     */
    protected function getRootNamespace()
    {
        if ($this->rootNamespace) {
            return $this->rootNamespace;
        }
        $class = get_class($this);
        $parts = explode('\\', $class);
        return head($parts);
    }

    /**
     * Get class name
     *
     * @return mixed
     */
    protected function getClassMainName()
    {
        if (! empty($this->classMainName)) {
            return $this->classMainName;
        }

        $parts = explode("\\", get_class($this));
        $className = array_pop($parts);
        $classType = [];
        for ($i = 0; $i < $this->mainFolderInDeep; $i++) {
            array_unshift($classType, array_pop($parts));
        }

        if (empty($classType)) {
            return $this->classMainName = str_replace($classType, '', $className);
        }

        $mainClassName = array_shift($classType);
        $mainClassName = Str::singular($mainClassName);
        $mainClassName = str_replace($mainClassName, '', $className);
        $classType[] = $mainClassName;
        return $this->classMainName = implode('\\', $classType);
    }
}
