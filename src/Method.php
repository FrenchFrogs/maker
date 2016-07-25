<?php namespace FrenchFrogs\Maker;

/**
 *
 *
 * Class Method
 * @package FrenchFrogs\Maker
 */
class Method
{
    use Docblock;
    use Modifier;

    /**
     * @var Body
     */
    protected $body;


    /**
     * @var string
     */
    protected $name;

    /**
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Getter for $parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Add parameter
     *
     * @param mixed $name
     * @param bool $mandatory
     * @param null $default
     * @param null $type
     * @return $this
     */
    public function addParameter($name, $default = Maker::NO_VALUE, $type = null)
    {
        $parameter = $name instanceof Parameter ?  $name : new Parameter($name, $default, $type);
        $this->parameters[$name] = $parameter;
        return $this;
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
     * Method constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * Setter for $body
     *
     * @param $body
     * @return $this
     */
    public function setBody($body)
    {

        if (is_string($body)) {
            $body = new Body();
            $body->setContent($body);
        }

        if (!$body instanceof Body) {
            throw new \InvalidArgumentException('$body doit être de type string ou Body');
        }

        $this->setBody($body);
        return $this;
    }

    /**
     * Getter for $body
     *
     * @return Body
     */
    public function getBody()
    {
        return $this->body;
    }
}