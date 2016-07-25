<?php namespace FrenchFrogs\Maker;


class Body
{

    /**
     * @var string
     */
    protected $content = '';

    /**
     * Setter for $content
     *
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = strval($content);
        return $this;
    }

    /**
     * Concatenation du $content
     *
     * @param $content
     */
    public function addContent($content)
    {
        $this->content .= strval($content);
        return $this;
    }

    /**
     * Getter for $content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }


}