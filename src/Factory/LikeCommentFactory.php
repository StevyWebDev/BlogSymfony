<?php

namespace App\Factory;

use App\Entity\LikeComment;
use App\Repository\LikeCommentRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<LikeComment>
 *
 * @method static LikeComment|Proxy createOne(array $attributes = [])
 * @method static LikeComment[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static LikeComment|Proxy find(object|array|mixed $criteria)
 * @method static LikeComment|Proxy findOrCreate(array $attributes)
 * @method static LikeComment|Proxy first(string $sortedField = 'id')
 * @method static LikeComment|Proxy last(string $sortedField = 'id')
 * @method static LikeComment|Proxy random(array $attributes = [])
 * @method static LikeComment|Proxy randomOrCreate(array $attributes = [])
 * @method static LikeComment[]|Proxy[] all()
 * @method static LikeComment[]|Proxy[] findBy(array $attributes)
 * @method static LikeComment[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static LikeComment[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static LikeCommentRepository|RepositoryProxy repository()
 * @method LikeComment|Proxy create(array|callable $attributes = [])
 */
final class LikeCommentFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(LikeComment $likeComment): void {})
        ;
    }

    protected static function getClass(): string
    {
        return LikeComment::class;
    }
}
