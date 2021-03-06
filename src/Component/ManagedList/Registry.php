<?php

namespace Presentation\Framework\Component\ManagedList;

use Nayjest\Collection\Extended\ObjectCollectionReadInterface;
use Nayjest\Collection\Extended\Registry as BaseRegistry;

use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Component\Repeater;
use Presentation\Framework\Component\ManagedList\Control\ControlInterface;

class Registry extends BaseRegistry
{
    const SUBMIT_BUTTON_POSITION = 100;

    protected $root;

    public function __construct(array $items = [], ComponentInterface $root)
    {
        parent::__construct($items);
        $this->root = $root;
    }

    public function useDefaults()
    {
        $this->has('form') || $this->setForm(new Tag('form'));
        $this->has('repeater') || $this->setRepeater(new Repeater());
        $this->has('container') || $this->setContainer(new Tag('div'));
        $this->has('submit_button') || $this->setSubmitButton(
            new Tag('input', ['type' => 'submit'])
        );
    }

    /**
     * @return ComponentInterface
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param string $itemName
     * @return null|object
     */
    public function get($itemName)
    {
        if (!$this->has($itemName)) {
            $this->useDefaults();
        }
        return parent::get($itemName);
    }
    /**
     * @return ComponentInterface|null
     */
    public function getForm()
    {
        return $this->get('form');
    }

    protected function changeControlsContainer($containerName, ComponentInterface $component)
    {
        $controls = null;
        if ($this->has($containerName)) {
            $controls = $this->getControls()->toArray();
        }
        $this->set($containerName, $component);
        if ($controls) {
            $this->setControls($controls);
        }
    }

    /**
     * @param ComponentInterface $component
     * @return $this
     */
    public function setForm(ComponentInterface $component)
    {
        $this->changeControlsContainer('form', $component);
        return $this;
    }


    /**
     * @return Repeater|null
     */
    public function getRepeater()
    {
        return $this->get('repeater');
    }

    /**
     * @param ComponentInterface|null $component
     * @return $this
     */
    public function setRepeater(ComponentInterface $component = null)
    {
        return $this->set('repeater', $component);
    }

    /**
     * @return ComponentInterface|null
     */
    public function getContainer()
    {
        return $this->get('container');
    }

    /**
     * @param ComponentInterface|null $component
     * @return $this
     */
    public function setContainer(ComponentInterface $component = null)
    {
        return $this->set('container', $component);
    }


    /**
     * @return ComponentInterface|null
     */
    public function getRecordView()
    {
        return $this->get('record_view');
    }

    /**
     * @param ComponentInterface|null $component
     * @return $this
     */
    public function setRecordView(ComponentInterface $component = null)
    {
        return $this->set('record_view', $component);
    }


    /**
     * @return ObjectCollectionReadInterface|ControlInterface[]
     */
    public function getControls()
    {
        /** @var ObjectCollectionReadInterface $formChildren */
        $components =  $this->root->getChildrenRecursive();
        return $components->filterByType(ControlInterface::class);
    }

    public function setControls($controls)
    {
        $old = $this->getControls();
        foreach($old as $control) {
            $control->detach();
        }
        $this->getForm()->addChildren($controls);
    }


    /**
     * @return ComponentInterface|null
     */
    public function getSubmitButton()
    {
        return $this->get('submit_button');
    }

    /**
     * @param ComponentInterface|null $component
     * @return $this
     */
    public function setSubmitButton(ComponentInterface $component = null)
    {
        $component->setSortPosition(static::SUBMIT_BUTTON_POSITION);
        return $this->set('submit_button', $component);
    }
}