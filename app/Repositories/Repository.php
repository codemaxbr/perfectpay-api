<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /** @var Model */
    protected $model;

    /** @var Application */
    protected $app;

    /** @param Application $app */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Configura o Model
     *
     * @return string
     */
    abstract public function model();

    /**
     * Cria uma instância do Model
     *
     * @throws \Exception
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("A Classe {$this->model()} precisa ser uma instância de Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Lista todos os resultados com os critérios de filtro fornecidos
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*'], $where = [])
    {
        $query = $this->model::query();
        foreach ($where as $key => $value) {
            $query->where($key, $value);
        }
        $query->select($columns);

        return $query->get();
    }

    /**
     * Cria um novo registro no banco de dados
     *
     * @param array $input
     * @return Model
     */
    public function create($data)
    {
        try {
            $model = $this->model->newInstance();
            $model->fill($data);
            $model->save();

            return $model;
        } catch (\Exception $e) {
            if (gettype($e->getCode()) == 'string') {
                throw new \Exception($e->getMessage(), 500);
            } else {
                throw new \Exception($e->getMessage(), 500);
            }
        }
    }

    public function update($data, $id)
    {
        try {
            $model = $this->find(['id' => $id]);
            $model->fill($data);
            $model->save();

            return $model;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        try {
            $model = $this->find(['id' => $id]);
            $model->delete();

            return $model;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }

    public function find($where = [])
    {
        $query = $this->model::query();
        foreach ($where as $key => $value) {
            $query->where($key, $value);
        }

        $model = $query->get();
        if ($model->isEmpty()) {
            throw new \Exception("Registro não encontrado.", 404);
        }

        return $model->first();
    }
}
