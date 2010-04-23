<?php

class PluginDmFloodControlEntityTable extends myDoctrineTable
{

  /**
   * Fetch a record or create it
   * @return DmFloodControlEntity
   */
  public function findOneByIpAndActionCodeOrCreate($ip, $actionCode)
  {
    $record = $this->createQuery('r')
    ->where('r.ip = ?', $ip)
    ->andWhere('r.action_code = ?', $actionCode)
    ->fetchRecord();

    if(!$record)
    {
      $record = $this->create(array(
        'ip' => $ip,
        'action_code' => $actionCode
      ));
    }

    return $record;
  }
}