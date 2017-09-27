<?php

namespace Galahad\Forms;

use Galahad\Forms\Binding\BoundData;
use Galahad\Forms\Elements\Button;
use Galahad\Forms\Elements\Checkbox;
use Galahad\Forms\Elements\Date;
use Galahad\Forms\Elements\DateTimeLocal;
use Galahad\Forms\Elements\Email;
use Galahad\Forms\Elements\File;
use Galahad\Forms\Elements\FormOpen;
use Galahad\Forms\Elements\Hidden;
use Galahad\Forms\Elements\Label;
use Galahad\Forms\Elements\Password;
use Galahad\Forms\Elements\RadioButton;
use Galahad\Forms\Elements\Select;
use Galahad\Forms\Elements\Text;
use Galahad\Forms\Elements\TextArea;
use Galahad\Forms\ErrorStore\ErrorStoreInterface;
use Galahad\Forms\OldInput\OldInputInterface;

class FormBuilder
{
    /** @var OldInputInterface */
    protected $oldInput;

    /** @var ErrorStoreInterface */
    protected $errorStore;

    /** @var string */
    protected $csrfToken;

    /** @var BoundData */
    protected $boundData;

    /**
     * @param \Galahad\Forms\OldInput\OldInputInterface $oldInputProvider
     * @return $this
     */
    public function setOldInputProvider(OldInputInterface $oldInputProvider)
    {
        $this->oldInput = $oldInputProvider;

        return $this;
    }

    /**
     * @param \Galahad\Forms\ErrorStore\ErrorStoreInterface $errorStore
     * @return $this
     */
    public function setErrorStore(ErrorStoreInterface $errorStore)
    {
        $this->errorStore = $errorStore;

        return $this;
    }

    /**
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->csrfToken = $token;

        return $this;
    }

    /**
     * @return \Galahad\Forms\Elements\FormOpen
     */
    public function open()
    {
        $open = new FormOpen();

        if ($this->hasToken()) {
            $open->token($this->csrfToken);
        }

        return $open;
    }

    /**
     * @return string
     */
    public function close()
    {
        $this->unbindData();

        return '</form>';
    }

    /**
     * @param $name
     * @return \Galahad\Forms\Elements\Text
     */
    public function text($name)
    {
        $text = new Text($name);

        if (null !== $value = $this->getValueFor($name)) {
            $text->value($value);
        }

        return $text;
    }

    /**
     * @param $name
     * @return \Galahad\Forms\Elements\Date
     */
    public function date($name)
    {
        $date = new Date($name);

        if (null !== $value = $this->getValueFor($name)) {
            $date->value($value);
        }

        return $date;
    }

    /**
     * @param $name
     * @return \Galahad\Forms\Elements\DateTimeLocal
     */
    public function dateTimeLocal($name)
    {
        $date = new DateTimeLocal($name);

        if (null !== $value = $this->getValueFor($name)) {
            $date->value($value);
        }

        return $date;
    }

    /**
     * @param $name
     * @return \Galahad\Forms\Elements\Email
     */
    public function email($name)
    {
        $email = new Email($name);

        if (null !== $value = $this->getValueFor($name)) {
            $email->value($value);
        }

        return $email;
    }

    /**
     * @param $name
     * @return \Galahad\Forms\Elements\Hidden
     */
    public function hidden($name)
    {
        $hidden = new Hidden($name);

        if (null !== $value = $this->getValueFor($name)) {
            $hidden->value($value);
        }

        return $hidden;
    }

    /**
     * @param $name
     * @return \Galahad\Forms\Elements\TextArea
     */
    public function textarea($name)
    {
        $textarea = new TextArea($name);

        if (null !== $value = $this->getValueFor($name)) {
            $textarea->value($value);
        }

        return $textarea;
    }

    /**
     * @param $name
     * @return \Galahad\Forms\Elements\Password
     */
    public function password($name)
    {
        return new Password($name);
    }

    /**
     * @param $name
     * @param mixed $value
     * @return \Galahad\Forms\Elements\Checkbox
     */
    public function checkbox($name, $value = 1)
    {
        return (new Checkbox($name, $value))->setOldValue($this->getValueFor($name));
    }

    /**
     * @param $name
     * @param mixed $value
     * @return \Galahad\Forms\Elements\RadioButton
     */
    public function radio($name, $value = null)
    {
        return (new RadioButton($name, $value))->setOldValue($this->getValueFor($name));
    }

    /**
     * @param $value
     * @param string $name
     * @return \Galahad\Forms\Elements\Button
     */
    public function button($value, $name = null)
    {
        return new Button($value, $name);
    }

    /**
     * @param string $value
     * @return \Galahad\Forms\Elements\Button
     */
    public function reset($value = 'Reset')
    {
        return (new Button($value))->attribute('type', 'reset');
    }

    /**
     * @param string $value
     * @return \Galahad\Forms\Elements\Button
     */
    public function submit($value = 'Submit')
    {
        return (new Button($value))->attribute('type', 'submit');
    }

    /**
     * @param $name
     * @param array $options
     * @return \Galahad\Forms\Elements\Select
     */
    public function select($name, $options = [])
    {
        return (new Select($name, $options))->select($this->getValueFor($name));
    }

    /**
     * @param $label
     * @return \Galahad\Forms\Elements\Label
     */
    public function label($label)
    {
        return new Label($label);
    }

    /**
     * @param $name
     * @return \Galahad\Forms\Elements\File
     */
    public function file($name)
    {
        return new File($name);
    }

    /**
     * @return \Galahad\Forms\Elements\Hidden
     */
    public function token()
    {
        $token = $this->hidden('_token');

        if (null !== $this->csrfToken) {
            $token->value($this->csrfToken);
        }

        return $token;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasError($name)
    {
        if (null === $this->errorStore) {
            return false;
        }

        return $this->errorStore->hasError($name);
    }

    /**
     * @param $name
     * @param string $format
     * @return null|string
     */
    public function getError($name, $format = null)
    {
        if (null === $this->errorStore) {
            return null;
        }

        if (! $this->hasError($name)) {
            return '';
        }

        $message = $this->errorStore->getError($name);

        if ($format) {
            $message = str_replace(':message', $message, $format);
        }

        return $message;
    }

    /**
     * @param mixed $data
     * @return $this
     */
    public function bind($data)
    {
        $this->boundData = new BoundData($data);

        return $this;
    }

    /**
     * @param $name
     * @return string|null
     */
    public function getValueFor($name)
    {
        if ($this->hasOldInput()) {
            return $this->getOldInput($name);
        }

        if ($this->hasBoundData()) {
            return $this->getBoundValue($name, null);
        }

        return null;
    }

    /**
     * @param $name
     * @return \Galahad\Forms\Elements\Select
     */
    public function selectMonth($name = 'month')
    {
        return $this->select($name, [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ]);
    }

    /**
     * @return bool
     */
    protected function hasToken()
    {
        return null !== $this->csrfToken;
    }

    /**
     * @return bool
     */
    protected function hasOldInput()
    {
        if (null === $this->oldInput) {
            return false;
        }

        return $this->oldInput->hasOldInput();
    }

    /**
     * @param $name
     * @return mixed
     */
    protected function getOldInput($name)
    {
        return $this->oldInput->getOldInput($name);
    }

    /**
     * @return bool
     */
    protected function hasBoundData()
    {
        return null !== $this->boundData;
    }

    /**
     * @param $name
     * @param $default
     * @return mixed
     */
    protected function getBoundValue($name, $default)
    {
        return $this->boundData->get($name, $default);
    }

    /**
     * @return $this
     */
    protected function unbindData()
    {
        $this->boundData = null;

        return $this;
    }
}
