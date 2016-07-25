<?php namespace FrenchFrogs\Maker;


trait Docblock
{
    /**
     *
     *
     * @var string
     */
    protected $summary = '';


    /**
     * Description
     *
     * @var string
     */
    protected $description = '';

    /**
     * Tags
     *
     * @var array
     */
    protected $tags = [];


    /**
     * Annotations
     *
     * @var array
     */
    protected $annotations = [];

    /**
     * Getter for $summary
     *
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Setter for $summary
     *
     * @param $summary
     * @return $this
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * Setter for $description
     *
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = strval($description);
        return $this;
    }

    /**
     * Getter for $description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Setter for $tags
     *
     * @param array $tags
     * @return $this
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
        return $this;
    }


    /**
     * Clear all tags
     *
     * @return $this
     */
    public function clearTags()
    {
        $this->tags = [];
        return $this;
    }

    /**
     * Add a tag
     *
     * @param $name
     * @param $value
     */
    public function addTag($name, $value)
    {
        $this->tags[$name] = $value;
    }

    /**
     * Getter for tags
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }


    /**
     * Setter for $annotations
     *
     * @param array $annotations
     * @return $this
     */
    public function setAnnotation(array $annotations)
    {
        $this->annotations = $annotations;
        return $this;
    }


    /**
     * Clear all Annotations
     *
     * @return $this
     */
    public function clearAnnotations()
    {
        $this->annotations = [];
        return $this;
    }

    /**
     * Add a tag
     *
     * @param $name
     * @param $value
     */
    public function addAnnotation($value)
    {
        $this->annotations[] = $value;
    }

    /**
     * Getter for tags
     *
     * @return array
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

}