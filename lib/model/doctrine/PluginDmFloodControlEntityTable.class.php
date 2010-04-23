<?php

class PluginDmFloodControlEntityTable extends myDoctrineTable
{

  /**
   * Fetch a record or create it
   * @return DmFloodControlEntity
   */
  public function findOneByActionCodeAndIpOrCreate($actionCode, $ip)
  {
    $record = $this->createQuery('r')
    ->where('r.action_code = ?', $actionCode)
    ->andWhere('r.ip = ?', $ip)
    ->fetchRecord();

    if(!$record)
    {
      $record = $this->create(array(
        'ip' => $ip,
        'action_code' => $actionCode
      ))->saveGet();
    }

    return $record;
  }

  public function clearByActionCode($actionCode)
  {
    $this->createQuery()
    ->delete()
    ->where('action_code = ?', $actionCode)
    ->execute();
  }

  public function clearByActionCodeAndIp($actionCode, $ip)
  {
    $this->createQuery()
    ->delete()
    ->where('action_code = ?', $actionCode)
    ->andWhere('ip = ?', $ip)
    ->execute();
  }
}