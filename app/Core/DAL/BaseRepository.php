<?php

namespace App\Core\DAL;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{

    /**
     * BaseRepository constructor.
     */
    public $table;
    public function __construct(Model $model)
    {
        $this->table = $model;
    }


    public function getAll()
    {
        return $this->table->all();
    }

    public function getById($id)
    {
        $item = $this->table->findOrFail($id);
        return $item;
    }

    /**
     * Saving model to database and retrieving model.
     * @param $model
     * @return mixed
     */
    public function createModel($model)
    {
        $model->save();
        return $model;
    }

    public function update($id, $values)
    {
        $item = $this->table->findOrFail($id);
        $item->update($values);
        $item->save();
        return $item;
    }

    public function delete($id)
    {
        return $this->table->findOrFail($id)->delete();
    }



}
