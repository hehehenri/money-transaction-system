<?php

namespace Src\Infrastructure\Models;

/**
 * @template TEntity
 */
abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    /** @return TEntity */
    abstract public function intoEntity();
}
