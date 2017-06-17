<?php
/* src/AppBundle/Entity/Projecte.php */
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjecteRepository")
 * @ORM\Table(name="projecte")
 */
class Projecte
{
  const NUM_ITEMS = 6;
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
   private $id;
   
   /**
    * @ORM\Column(type="string")
    */
   private $foto;
   
   /**
    * @ORM\Column(type="string")
    */
   private $titol;
   
   /**
    * @ORM\Column(type="text")
    */
   private $descripcio;
   
   /**
    * @ORM\Column(type="integer")
    */
   private $anny;
    
    /**
    * @ORM\Column(type="integer")
    */
   private $tipus;   
   
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
     * Set foto
     * @param string $foto
     * @return Projecte
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set titol
     *
     * @param string $titol
     *
     * @return Projecte
     */
    public function setTitol($titol)
    {
        $this->titol = $titol;

        return $this;
    }

    /**
     * Get titol
     *
     * @return string
     */
    public function getTitol()
    {
        return $this->titol;
    }

    /**
     * Set descripcio
     *
     * @param string $descripcio
     *
     * @return Projecte
     */
    public function setDescripcio($descripcio)
    {
        $this->descripcio = $descripcio;

        return $this;
    }

    /**
     * Get descripcio
     *
     * @return string
     */
    public function getDescripcio()
    {
        return $this->descripcio;
    }

    /**
     * Set anny
     *
     * @param integer $anny
     *
     * @return Projecte
     */
    public function setAnny($anny)
    {
        $this->anny = $anny;

        return $this;
    }

    /**
     * Get anny
     *
     * @return integer
     */
    public function getAnny()
    {
        return $this->anny;
    }

    public function setTipus($tipus)
    {
      $this->tipus = $tipus;

        return $this;
    }
   
    public function getTipus()
    {
        return $this->tipus;
    }
   
}
