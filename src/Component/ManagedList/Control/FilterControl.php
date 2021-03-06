<?php

namespace Presentation\Framework\Component\ManagedList\Control;

use Presentation\Framework\Base\ViewAggregate;
use Presentation\Framework\Input\InputOption;
use Presentation\Framework\Component\ManagedList\Control\View\FilterControlView;
use Presentation\Framework\Data\Operation\DummyOperation;
use Presentation\Framework\Data\Operation\FilterOperation;
use Stringy\StaticStringy;

class FilterControl extends ViewAggregate implements ControlInterface
{
    /** @var string */
    protected $field;

    /** @var string */
    protected $operator;

    /** @var InputOption */
    protected $valueOption;

    /**
     * @param string $field
     * @param string $operator
     * @param InputOption $input
     */
    public function __construct(
        $field,
        $operator = FilterOperation::OPERATOR_EQ,
        InputOption $input
    )
    {
        $this->field = $field;
        $this->operator = $operator;
        $this->valueOption = $input;
        parent::__construct(
            new FilterControlView(
                $this->valueOption->getKey(),
                $this->valueOption->getValue(),
                StaticStringy::humanize($this->field)
            )
        );
    }

    public function getOperation()
    {
        if (!$this->valueOption->hasValue()) {
            return new DummyOperation();
        }
        return new FilterOperation(
            $this->field,
            $this->operator,
            $this->valueOption->getValue()
        );
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }
}
