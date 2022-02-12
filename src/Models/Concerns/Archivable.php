<?php

namespace Taskday\Models\Concerns;

use Taskday\Models\Scopes\ArchivableScope;
use Illuminate\Support\Carbon;

trait Archivable
{
    /**
     * Boot the archive trait for a model.
     *
     * @return void
     */
    public static function bootArchivable()
    {
        static::addGlobalScope(new ArchivableScope);
    }

    /**
     * Archive the model.
     */
    public function archive()
    {
        $this->{$this->getArchivedAtColumn()} = Carbon::now();
        $this->save();
    }

    /**
     * Restore the model from archive.
     */
    public function unarchive()
    {
        $this->{$this->getArchivedAtColumn()} = null;
        $this->save();
    }

    /**
     * Determine if the model instance has been archived.
     *
     * @return bool
     */
    public function isArchived()
    {
        return ! is_null($this->{$this->getArchivedAtColumn()});
    }

    /**
     * Get the fully qualified "archived at" column.
     *
     * @return string
     */
    public function getQualifiedArchivedAtColumn()
    {
        return $this->getTable().'.'.$this->getArchivedAtColumn();
    }

    /**
     * Get the name of the "archived at" column.
     *
     * @return string
     */
    public function getArchivedAtColumn()
    {
        return defined('static::ARCHIVED_AT') ? static::ARCHIVED_AT : 'archived_at';
    }
}
