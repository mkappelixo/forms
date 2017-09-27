<?php

namespace Galahad\Forms\Elements;

class Label extends Element
{
    /** @var \Galahad\Forms\Elements\Element */
    protected $element;

    /** @var bool */
    protected $labelBefore;

    /** @var string */
    protected $label;

    /**
     * @param $label
     */
    public function __construct($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function render()
    {
        $tags = [sprintf('<label%s>', $this->renderAttributes())];

        if ($this->labelBefore) {
            $tags[] = $this->label;
        }

        $tags[] = $this->renderElement();

        if (! $this->labelBefore) {
            $tags[] = $this->label;
        }

        $tags[] = '</label>';

        return implode($tags);
    }

    /**
     * @param $name
     * @return $this
     */
    public function forId($name)
    {
        $this->attribute('for', $name);

        return $this;
    }

    /**
     * @param \Galahad\Forms\Elements\Element $element
     * @return $this
     */
    public function before(Element $element)
    {
        $this->element = $element;
        $this->labelBefore = true;

        return $this;
    }

    /**
     * @param \Galahad\Forms\Elements\Element $element
     * @return $this
     */
    public function after(Element $element)
    {
        $this->element = $element;
        $this->labelBefore = false;

        return $this;
    }

    /**
     * @return string
     */
    protected function renderElement()
    {
        if (! $this->element) {
            return '';
        }

        return $this->element->render();
    }

    /**
     * @return \Galahad\Forms\Elements\Element
     */
    public function getControl()
    {
        return $this->element;
    }
}
