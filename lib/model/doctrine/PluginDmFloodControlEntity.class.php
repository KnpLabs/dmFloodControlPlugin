<?php

abstract class PluginDmFloodControlEntity extends BaseDmFloodControlEntity
{

  public function consume($creditsUsed = 1)
  {
    $totalCreditsUsed = $this->get('credits_used') + $creditsUsed;
    
    $this->set('credits_used', $totalCreditsUsed);
    $this->save();

    return $totalCreditsUsed;
  }
}