<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update(int $id, array $attributes);

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * @return mixed
     */
    public function all();
}
