<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
    /**
     * @param array $criteria
     * @return int|null
     */
    public function getCount(array $criteria = [])
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);

        return intval($persister->count($criteria));
    }
}
