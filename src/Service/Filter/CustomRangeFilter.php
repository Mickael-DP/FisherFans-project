<?php

namespace App\Service\Filter;

use ApiPlatform\Doctrine\Common\Filter\RangeFilterInterface;
use ApiPlatform\Doctrine\Common\Filter\RangeFilterTrait;
use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class CustomRangeFilter extends AbstractFilter implements RangeFilterInterface
{
    use RangeFilterTrait;
    private RangeFilter $filter;

    public function __construct(ManagerRegistry $managerRegistry, LoggerInterface $logger = null, ?array $properties = null, ?NameConverterInterface $nameConverter = null)
    {
        parent::__construct($managerRegistry, $logger, $properties, $nameConverter);
        $this->filter = new RangeFilter($managerRegistry, $logger, $properties, $nameConverter);
    }

    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        $this->filter->filterProperty($property, $value, $queryBuilder, $queryNameGenerator, $resourceClass, $operation, $context);
    }

    public function getDescription(string $resourceClass): array
    {
        $description = [];

        $properties = $this->getProperties();
        if (null === $properties) {
            $properties = array_fill_keys($this->getClassMetadata($resourceClass)->getFieldNames(), null);
        }

        foreach ($properties as $property => $unused) {
            if (!$this->isPropertyMapped($property, $resourceClass)) {
                continue;
            }

            $description += $this->getFilterDescription($property, self::PARAMETER_GREATER_THAN);
            $description += $this->getFilterDescription($property, self::PARAMETER_LESS_THAN);
        }

        return $description;
    }
}