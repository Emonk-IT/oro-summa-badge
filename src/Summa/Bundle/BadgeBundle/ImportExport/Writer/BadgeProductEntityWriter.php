<?php

namespace Summa\Bundle\BadgeBundle\ImportExport\Writer;

use Doctrine\DBAL\Exception\RetryableException;
use Oro\Bundle\ImportExportBundle\Writer\EntityWriter;

/**
 * Import-Export database entity writer for the RelatedProduct entities.
 */
class BadgeProductEntityWriter extends EntityWriter
{
    /**
     * {@inheritdoc}
     */
    public function write(array $items): void
    {
        try {
            $entityManager = $this->doctrineHelper->getEntityManager($this->getClassName($items));
            foreach ($items as $item) {
                $entityManager->persist($item);
            }
            $entityManager->flush();

            $configuration = $this->getConfig();

            if (empty($configuration[self::SKIP_CLEAR])) {
                $entityManager->clear();
            }
        } catch (RetryableException $e) {
            $context = $this->contextRegistry->getByStepExecution($this->stepExecution);
            $context->setValue('deadlockDetected', true);
        }
    }
}
