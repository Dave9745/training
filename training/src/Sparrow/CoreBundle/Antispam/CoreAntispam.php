<?php

namespace Sparrow\CoreBundle\Antispam;

class CoreAntispam
{
  private $mailer;
  private $locale;
  private $minLength;

  public function __construct(\Swift_Mailer $mailer, $locale, $minLength)
  {
    $this->mailer    = $mailer;
    $this->locale    = $locale;
    $this->minLength = (int) $minLength;
  }
    
    public function isSpam($text)
  {
    return strlen($text) < $this->minLength;
  }
  
}