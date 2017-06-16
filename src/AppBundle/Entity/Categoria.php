<?php
/* src/AppBundle/Entity/Categoria.php */
namespace AppBundle\Entity;

//use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="categoria")
 */
class Categoria implements \JsonSerializable
{
  /**
   * @var int
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue
   */
   private $id;
   
   /**
    * @var string
    * @ORM\Column(type="string", unique=true)
    */
   private $categoria;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set categoria
     * @param string $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
    
     public function jsonSerialize()
    {
        return $this->categoria;
    }

    public function __toString()
    {
        return $this->categoria;
    }
    
}
