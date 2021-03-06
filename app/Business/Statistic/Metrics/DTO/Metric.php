<?php
declare(strict_types=1);

namespace App\Business\Statistic\Metrics\DTO;

/**
 * Class Metric
 *
 * @package App\Business\Statistic\Metrics\DTO
 */
class Metric
{

    /**
     * Семейство браузеров, через который перешел пользователь
     *
     * @var string
     */
    public $browserVersion;
    /**
     * Дата в строковом формате
     *
     * @var string
     */
    public $stringDate;
    /**
     * Id метрики в БД
     *
     * @var int
     */
    protected $id;
    /**
     * Дата создания
     *
     * @var
     */
    protected $createdAt;
    /**
     * Дата обновления
     *
     * @var
     */
    protected $updatedAt;
    /**
     * ID ссылки, которой приадлежит статистика
     *
     * @var int
     */
    public $linkDataId;
    /**
     * ip, с которого перешли
     *
     * @var string
     */
    public $ip;
    /**
     * Источник, откуда перешели по ссылке
     *
     * @var string
     */
    public $referLink;
    /**
     * Страна, где были переход.
     *
     * Вычисляется по ip
     *
     * @var string
     */
    public $country;

    public function __construct(
        int $linkDataId,
        string $ip,
        string $browserVersion,
        string $referLink,
        string $country,
        int $id = null,
        string $stringDate = null,
        $createdAt = null,
        $updatedAt = null
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->linkDataId = $linkDataId;
        $this->ip = $ip;
        $this->browserVersion = $browserVersion;
        $this->referLink = $referLink;
        $this->country = $country;
        $this->stringDate = $stringDate;
    }
}
