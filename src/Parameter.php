<?php namespace FrenchFrogs\Maker;


class Parameter
{

    /**
     * @var string
     */
    protected $name;

    /**
     *
     * @var bool
     */
    protected $is_mandatory = false;

    /**
     * Default value
     *
     * @var mixed
     */
    protected $default = null;

    /**
     *
     * @var string
     */
    protected $type;


    /**
     * Parameter constructor.
     *
     *
     * @param $name
     * @param bool $mandatory
     * @param null $default
     * @param null $type
     */
    public function __construct($name, $default = Maker::NO_VALUE, $type = null)
    {
        $this->setName($name);
        $this->setDefault($default);

        if (!is_null($type)) {
            $this->setType($type);
        }
    }

    /**
     * Setter for $type
     *
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Getter for $type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Return TRUE is ype is set
     *
     * @return bool
     */
    public function hasType()
    {
        return isset($this->type);
    }

    /**
     * Unset $type
     *
     * @return $this
     */
    public function removeType()
    {
        unset($this->type);
        return $this;
    }



    /**
     * Setter for default
     *
     * @param $default
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * Getter for default
     *
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Getter for $name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * Setter for $name
     *
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = strval($name);
        return $this;
    }

    /**
     * Set $is_mandatory to TRUE
     *
     * @return $this
     */
    public function enableMandatory()
    {
        $this->is_mandatory = true;
        return $this;
    }

    /**
     * Set $is_mandatory to FALSE
     *
     * @return $this
     */
    public function disableMandatory()
    {
        $this->is_mandatory = false;
        return $this;
    }

    /**
     * Getter for $is_mandatory
     *
     * @return bool
     */
    function isMandatory()
    {
        return $this->is_mandatory;
    }
}