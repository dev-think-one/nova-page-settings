<?php

namespace Thinkone\NovaPageSettings\QueryAdapter;

use Closure;
use Illuminate\Database\ConnectionInterface;

class InternalSettingsConnection implements ConnectionInterface
{
    public function getName(): string
    {
        return config('nova-page-settings.db_connection');
    }

    /**
     * @codeCoverageIgnore
     */
    public function table($table, $as = null)
    {
        return '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function raw($value)
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function selectOne($query, $bindings = [], $useReadPdo = true)
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function select($query, $bindings = [], $useReadPdo = true)
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function cursor($query, $bindings = [], $useReadPdo = true)
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function insert($query, $bindings = [])
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function update($query, $bindings = [])
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function delete($query, $bindings = [])
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function statement($query, $bindings = [])
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function affectingStatement($query, $bindings = [])
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function unprepared($query)
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function prepareBindings(array $bindings)
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function transaction(Closure $callback, $attempts = 1)
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function beginTransaction()
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function commit()
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function rollBack()
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function transactionLevel()
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function pretend(Closure $callback)
    {
        // unused
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDatabaseName()
    {
        // unused
    }
}
