<?php

namespace LaraAreaModel\Traits;

trait OldChangesAttribute
{
    /**
     * @var
     */
    protected $oldChanges = [];

    /**
     * Sync the changed attributes.
     *
     * @return $this
     */
    public function syncChanges()
    {
        $this->changes = $this->getDirty();
        foreach (array_keys($this->changes) as $attribute) {
            $this->oldChanges[$attribute] = $this->getOriginal($attribute);
        }

        return $this;
    }

    /**
     * Get old changes usefull after update
     *
     * @return mixed
     */
    public function getOldChanges()
    {
        return $this->oldChanges;
    }

    /**
     * Set old changes
     *
     * @param $changes
     * @return mixed
     */
    public function setOldChanges($changes)
    {
        return $this->oldChanges = $changes;
    }
}