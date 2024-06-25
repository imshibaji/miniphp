<?php

trait JoinModel{

    /**
     * Set the table name.
     *
     * @param string $name The table name.
     * @return void
     */
    public function setTable($name)
    {
        $this->table = $name;
    }

    /**
     * Get the table name.
     *
     * @return string The table name.
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Get the joined table name.
     *
     * @return string The joined table name.
     */
    public function getJoinedTable()
    {
        return $this->joinedTable;
    }

    /**
     * Set the joined table name.
     *
     * @param string $name The joined table name.
     * @return void
     */
    public function setJoinedTable($name)
    {
        $this->joinedTable = $name;
    }

    /**
     * Set the joined table alias.
     *
     * @param string $name The joined table alias.
     * @return void
     */
    public function setJoinedTableAlias($name)
    {
        $this->joinedTableAlias = $name;
    }

    /**
     * Get the joined table alias.
     *
     * @return string The joined table alias.
     */
    public function getJoinedTableAlias()
    {
        return $this->joinedTableAlias;
    }

    /**
     * Get the joined table columns.
     *
     * @return array The joined table columns.
     */
    public function getJoinedTableColumns()
    {
        return $this->joinedTableColumns;
    }

    /**
     * Set the joined table columns.
     *
     * @param array $columns The joined table columns.
     * @return void
     */
    public function setJoinedTableColumns($columns)
    {
        $this->joinedTableColumns = $columns;
    }
}