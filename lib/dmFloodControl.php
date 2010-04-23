<?php

class dmFloodControl extends dmConfigurable
{
  protected $request;

  public function __construct(sfWebRequest $request, array $options = array())
  {
    $this->request = $request;

    $this->configure($options);
  }

  public function getDefaultOptions()
  {
    return array(
      'entity_model' => 'DmFloodControlEntity'
    );
  }

  /**
   * The current client consumes an action.
   * It uses a given amount of credits.
   * If the client credits for this action reaches the limit,
   * a dmFloodControlOutOfCreditException is thrown.
   *
   * @param int     $actionCode     code of the used action
   * @param int     $creditsLimit   maximum amount of credits a client can use for this action
   * @param int     $creditsUsed    number of credits used the client uses right now
   *
   * @return bool   true
   * @throws dmFloodControlOutOfCreditException if the maximum credits amount is reached.
   *
   * Example:
   * $floodControl->consume(SIGN_PETITION_ACTION_CODE, 10); // The client signs one petition. He can signs 10 petitions.
   * $floodControl->consume(SEND_MAIL_ACTION_CODE, 20, 4);  // The client sends 4 mails. He can send 20 mails.
   */
  public function consume($actionCode, $creditsLimit, $creditsUsed = 1)
  {
    $ip = $this->getCurrentClientIp();
    
    $entity = $this->getEntityTable()->findOneByIpAndActionCodeOrCreate($ip, $actionCode);

    $totalCreditsUsed = $entity->consume($creditsUsed);

    if($totalCreditsUsed > $creditsLimit)
    {
      throw new dmFloodControlOutOfCreditException(sprintf('%s exceeded credit limit of %d for action code %d',
        $ip, $creditsLimit, $actionCode
      ));
    }
  }

  /**
   * @return string the client IP
   */
  public function getCurrentClientIp()
  {
    // localhost
    if(!$ip = $this->request->getForwardedFor())
    {
      $ip = $this->request->getRemoteAddress();
    }
    // proxies
    elseif(is_array($ip))
    {
      $ip = $ip[0];
    }

    return $ip;
  }

  /**
   * @return DmFloodControlEntityTable
   */
  public function getEntityTable()
  {
    return dmDb::table($this->getOption('entity_model'));
  }
}