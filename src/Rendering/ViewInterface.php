<?php
namespace Presentation\Framework\Rendering;

/**
 * Interface ViewInterface
 */
interface ViewInterface
{
    /**
     * Renders view.
     *
     * @return string
     */
    public function render();

    /**
     * Returns rendering result  when object is treated like a string.
     *
     * @return mixed
     */
    public function __toString();
}
