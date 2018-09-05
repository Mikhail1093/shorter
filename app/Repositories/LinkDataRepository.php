<?php
declare(strict_types=1);

namespace App\Repositories;


use App\Models\LinkData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class LinkDataRepository implements RepositoryInterface
{
    /**
     *
     * @var \App\Models\LinkData
     */
    protected $linkData;

    /**
     * LinkDataRepository constructor.
     *
     * @param \App\Models\LinkData $linkData
     */
    public function __construct(LinkData $linkData)
    {
        $this->linkData = $linkData;
    }

    /**
     * Получить LinkData из БД
     *
     * @param int      $limit  LIMIT
     * @param array    $filter массив фильтра вида ['db_field_key' => $value]
     * @param array    $fields массив полей, который небхходимо получить вида ['db_field_key_1', 'db_field_key_2']
     * @param int|null $offset сдвиг LIMIT
     *
     * @return \Illuminate\Support\Collection
     */
    public function get(int $limit = 50, array $filter = [], array $fields = null, int $offset = null): Collection
    {

        return $this->linkData->where($filter)->limit($limit)->get($fields);

    }

    /**
     * Получить пагинацию объектов
     *
     * @param int $elementsCount
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $elementsCount = 50): LengthAwarePaginator
    {
        return $this->linkData->paginate($elementsCount);
    }

    /**
     * Сохранить модель в БД
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function add(Model $model): Model
    {
        // TODO: Implement add() method.
    }

    /**
     * Обновить запись в БД по объекту
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateByModelEntity(Model $model): Model
    {
        // TODO: Implement updateByModelEntity() method.
    }

    /**
     * Обновить запись в БД по id
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateById(int $id): Model
    {
        // TODO: Implement updateById() method.
    }

    /**
     * Удалить запись из БД по объекту
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return Model
     */
    public function deleteByModel(Model $model): Model
    {
        // TODO: Implement deleteByModel() method.
    }

    /**
     * Удалить запись из БД по id
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function deleteById(int $id): ?Model
    {
        // TODO: Implement deleteById() method.
    }

    public function deactivateLinkByField($field, $value)
    {
        return $this->linkData->where($field, '=', $value)->update(['active' => false]);
    }
}