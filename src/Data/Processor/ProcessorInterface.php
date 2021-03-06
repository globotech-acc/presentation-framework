<?php
namespace Presentation\Framework\Data\Processor;

use Presentation\Framework\Data\Operation\OperationInterface;

interface ProcessorInterface
{
    /**
     * Applies operation to source and returns modified source.
     *
     * @param $src
     * @param OperationInterface $operation
     * @return mixed
     */
    public function process($src, OperationInterface $operation);
}
