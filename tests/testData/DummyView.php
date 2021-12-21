<?php

use Merophp\ViewEngine\ViewPlugin\ViewInterface;

class DummyView implements ViewInterface{

    /**
     * @var string
     */
    protected string $text;

    /**
     * @var string
     */
    protected string $contentType = 'text/plain;charset=utf-8';

    /**
     * @api
     */
    public function __construct()
    {}

    /**
     * @return false|string
     */
    public function render(): string
    {
        ob_start();
        echo $this->text;
        $result=ob_get_contents();
        ob_end_clean();
        return $result;
    }

    /**
     * @param $value
     * @api
     */
    public function dummy($value)
    {
        $this->setOutput($value);
    }

    /**
     * @param $value
     * @api
     */
    public static function dummy2($value)
    {
        echo 'foo';
    }


    /**
     * @param mixed $value
     */
    public function setOutput($value){
        $this->text = strval($value);
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }
}
