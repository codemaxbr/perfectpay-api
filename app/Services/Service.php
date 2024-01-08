<?php

namespace App\Services;

interface Service
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param array $where
     * @return mixed
     */
    public function find(array $where);

    /**
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update(array $attributes, int $id);

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
