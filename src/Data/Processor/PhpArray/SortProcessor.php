<?php
namespace Presentation\Framework\Data\Processor\PhpArray;

use Presentation\Framework\Data\Operation\OperationInterface;
use Presentation\Framework\Data\Operation\SortOperation;
use Presentation\Framework\Data\Processor\ProcessorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class SortProcessor implements ProcessorInterface
{
    /**
     * @param $src
     * @param OperationInterface|SortOperation $operation
     * @return mixed
     */
    public function process($src, OperationInterface $operation)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $field = $operation->getField();
        $desc = $operation->getOrder() === SortOperation::DESC;
        usort($src, function ($row1, $row2) use ($accessor, $field, $desc) {
            $val1 = $accessor->getValue($row1, $field);
            $val2 = $accessor->getValue($row2, $field);
            if ($val1 == $val2) {
                return 0;
            }
            $res = $val1 < $val2 ? -1 : 1;
            return $desc ? -$res : $res;

        });
        return $src;
    }
}
