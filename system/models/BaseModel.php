<?php
namespace Shibaji\Models;
use Shibaji\Core\Model;

class BaseModel extends Model
{
    /**
     * Get the table name.
     *
     * @return string The table name.
     */
    public function getTable(): string
    {
        return $this->table;
    }
}