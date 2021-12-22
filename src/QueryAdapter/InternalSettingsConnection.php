<?php

namespace Thinkone\NovaPageSettings\QueryAdapter;

use Closure;
use Illuminate\Database\ConnectionInterface;

class InternalSettingsConnection implements ConnectionInterface
{
    public function getName(): string
    {
        return static::class;
    }

    public function table($table, $as = null)
    {
        return '';
    }

    public function raw($value)
    {
        // unused
    }

    public function selectOne($query, $bindings = [], $useReadPdo = true)
    {
        // unused
    }

    public function select($query, $bindings = [], $useReadPdo = true)
    {
        // unused
    }

    public function cursor($query, $bindings = [], $useReadPdo = true)
    {
        // unused
    }

    public function insert($query, $bindings = [])
    {
        // unused
    }

    public function update($query, $bindings = [])
    {
        // unused
    }

    public function delete($query, $bindings = [])
    {
        // unused
    }

    public function statement($query, $bindings = [])
    {
        // unused
    }

    public function affectingStatement($query, $bindings = [])
    {
        // unused
    }

    public function unprepared($query)
    {
        // unused
    }

    public function prepareBindings(array $bindings)
    {
        // unused
    }

    public function transaction(Closure $callback, $attempts = 1)
    {
        // unused
    }

    public function beginTransaction()
    {
        // unused
    }

    public function commit()
    {
        // unused
    }

    public function rollBack()
    {
        // unused
    }

    public function transactionLevel()
    {
        // unused
    }

    public function pretend(Closure $callback)
    {
        // unused
    }

    public function getDatabaseName()
    {
        // unused
    }
}
