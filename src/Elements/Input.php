<?php

namespace Galahad\Forms\Elements;

abstract class Input extends FormControl
{
    const AUTO_COMPLETE_ON = 'on';
    const AUTO_COMPLETE_OFF = 'off';
    const AUTO_COMPLETE_HONORIFIC_PREFIX = 'honorific-prefix';
    const AUTO_COMPLETE_GIVEN_NAME = 'given-name';
    const AUTO_COMPLETE_ADDITIONAL_NAME = 'additional-name';
    const AUTO_COMPLETE_FAMILY_NAME = 'family-name';
    const AUTO_COMPLETE_HONORIFIC_SUFFIX = 'honorific-suffix';
    const AUTO_COMPLETE_NICKNAME = 'nickname';
    const AUTO_COMPLETE_USERNAME = 'username';
    const AUTO_COMPLETE_NEW_PASSWORD = 'new-password';
    const AUTO_COMPLETE_CURRENT_PASSWORD = 'current-password';
    const AUTO_COMPLETE_ORGANIZATION_TITLE = 'organization-title';
    const AUTO_COMPLETE_ORGANIZATION = 'organization';
    const AUTO_COMPLETE_STREET_ADDRESS = 'street-address';
    const AUTO_COMPLETE_ADDRESS_LINE1 = 'address-line1';
    const AUTO_COMPLETE_ADDRESS_LINE2 = 'address-line2';
    const AUTO_COMPLETE_ADDRESS_LINE3 = 'address-line3';
    const AUTO_COMPLETE_ADDRESS_LEVEL4 = 'address-level4';
    const AUTO_COMPLETE_ADDRESS_LEVEL3 = 'address-level3';
    const AUTO_COMPLETE_ADDRESS_LEVEL2 = 'address-level2';
    const AUTO_COMPLETE_ADDRESS_LEVEL1 = 'address-level1';
    const AUTO_COMPLETE_COUNTRY = 'country';
    const AUTO_COMPLETE_COUNTRY_NAME = 'country-name';
    const AUTO_COMPLETE_POSTAL_CODE = 'postal-code';
    const AUTO_COMPLETE_CC_NAME = 'cc-name';
    const AUTO_COMPLETE_CC_GIVEN_NAME = 'cc-given-name';
    const AUTO_COMPLETE_CC_ADDITIONAL_NAME = 'cc-additional-name';
    const AUTO_COMPLETE_CC_FAMILY_NAME = 'cc-family-name';
    const AUTO_COMPLETE_CC_NUMBER = 'cc-number';
    const AUTO_COMPLETE_CC_EXP = 'cc-exp';
    const AUTO_COMPLETE_CC_EXP_MONTH = 'cc-exp-month';
    const AUTO_COMPLETE_CC_EXP_YEAR = 'cc-exp-year';
    const AUTO_COMPLETE_CC_CSC = 'cc-csc';
    const AUTO_COMPLETE_CC_TYPE = 'cc-type';
    const AUTO_COMPLETE_TRANSACTION_CURRENCY = 'transaction-currency';
    const AUTO_COMPLETE_TRANSACTION_AMOUNT = 'transaction-amount';
    const AUTO_COMPLETE_LANGUAGE = 'language';
    const AUTO_COMPLETE_BDAY = 'bday';
    const AUTO_COMPLETE_BDAY_DAY = 'bday-day';
    const AUTO_COMPLETE_BDAY_MONTH = 'bday-month';
    const AUTO_COMPLETE_BDAY_YEAR = 'bday-year';
    const AUTO_COMPLETE_SEX = 'sex';
    const AUTO_COMPLETE_URL = 'url';
    const AUTO_COMPLETE_PHOTO = 'photo';

    const MODE_VERBATIM = 'verbatim';
    const MODE_LATIN = 'latin';
    const MODE_LATIN_NAME = 'latin-name';
    const MODE_LATIN_PROSE = 'latin-prose';
    const MODE_FULL_WIDTH_LATIN = 'full-width-latin';
    const MODE_KANA = 'kana';
    const MODE_KATAKANA = 'katakana';
    const MODE_NUMERIC = 'numeric';
    const MODE_TEL = 'tel';
    const MODE_EMAIL = 'email';
    const MODE_URL = 'url';

    /**
     * @return string
     */
    public function render()
    {
        return sprintf('<input%s>', $this->renderAttributes());
    }

    /**
     * @param string $value
     * @return $this
     */
    public function value($value)
    {
        return $this->setValue($value);
    }

    /**
     * @param int $size
     * @return $this
     */
    public function size($size)
    {
        return $this->attribute('size', $size);
    }

    /**
     * @param string $accept
     * @return $this
     */
    public function accept($accept)
    {
        return $this->attribute('accept', $accept);
    }

    /**
     * @return $this
     */
    public function acceptImages()
    {
        return $this->accept('image/*');
    }

    /**
     * @return $this
     */
    public function acceptAudio()
    {
        return $this->accept('audio/*');
    }

    /**
     * @return $this
     */
    public function acceptVideo()
    {
        return $this->accept('video/*');
    }

    /**
     * @param string $which
     * @return $this
     */
    public function autocomplete($which = self::AUTO_COMPLETE_ON)
    {
        return $this->attribute('autocomplete', $which);
    }

    /**
     * @return $this
     */
    public function noAutocomplete()
    {
        return $this->autocomplete(self::AUTO_COMPLETE_OFF);
    }

    /**
     * @param string $mode
     * @return $this
     */
    public function inputmode($mode)
    {
        return $this->attribute('inputmode', $mode);
    }

    /**
     * @param string $regex
     * @return $this
     */
    public function pattern($regex)
    {
        return $this->attribute('pattern', $regex);
    }

    /**
     * @param string $value
     * @return $this
     */
    protected function setValue($value)
    {
        return $this->attribute('value', $value);
    }
}
