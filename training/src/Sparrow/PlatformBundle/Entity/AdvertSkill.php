<?php

namespace Sparrow\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="advert_skill")
 */
class AdvertSkill
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="level", type="string", length=255)
   */
  private $level;

  /**
   * @ORM\ManyToOne(targetEntity="Sparrow\PlatformBundle\Entity\Advert")
   * @ORM\JoinColumn(nullable=false)
   */
  private $advert;

  /**
   * @ORM\ManyToOne(targetEntity="Sparrow\PlatformBundle\Entity\Skill")
   * @ORM\JoinColumn(nullable=false)
   */
  private $skill;


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
     * Set level
     *
     * @param string $level
     *
     * @return AdvertSkill
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set advert
     *
     * @param \Sparrow\PlatformBundle\Entity\Advert $advert
     *
     * @return AdvertSkill
     */
    public function setAdvert(\Sparrow\PlatformBundle\Entity\Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \Sparrow\PlatformBundle\Entity\Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * Set skill
     *
     * @param \Sparrow\PlatformBundle\Entity\Skill $skill
     *
     * @return AdvertSkill
     */
    public function setSkill(\Sparrow\PlatformBundle\Entity\Skill $skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return \Sparrow\PlatformBundle\Entity\Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }
}
