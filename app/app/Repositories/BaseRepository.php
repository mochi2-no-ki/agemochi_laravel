<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected Model $model;

    /**
     * コンストラクタ：モデルインスタンスを注入
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * 全件取得
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * 主キーによる1件取得
     */
    public function find(string $id)
    {
        return $this->model->find($id);
    }

    /**
     * レコード作成
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * レコード更新
     */
    public function update(string $id, array $data)
    {
        $record = $this->find($id);
        if ($record) {
            $record->update($data);

            return $record;
        }

        return null;
    }

    /**
     * レコード削除
     */
    public function delete(string $id)
    {
        $record = $this->find($id);

        return $record ? $record->delete() : false;
    }

    /**
     * モデルのクエリビルダを返す（条件追加のための基点）
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function baseQuery()
    {
        return $this->model->newQuery();
    }
}
