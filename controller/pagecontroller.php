<?php
/**
 * ownCloud - bav
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Claus-Justus Heine <himself@claus-justus-heine.de>
 * @copyright Claus-Justus Heine 2014
 */

namespace OCA\BAV\Controller;


use \OCP\IRequest;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\AppFramework\Controller;

class PageController extends Controller
{
  private $l;
  private $userId;

  public function __construct($appName, IRequest $request, $userId){
    parent::__construct($appName, $request);
    $this->userId = $userId;
    $this->l = \OC_L10N::get('bav');
  }

  /********************************************************
   * Funktion zur Erstellung einer IBAN aus BLZ+Kontonr
   * Gilt nur fuer deutsche Konten
   ********************************************************/
  private static function makeIBAN($blz, $kontonr) {
    $blz8 = str_pad ( $blz, 8, "0", STR_PAD_RIGHT);
    $kontonr10 = str_pad ( $kontonr, 10, "0", STR_PAD_LEFT);
    $bban = $blz8 . $kontonr10;
    $pruefsumme = $bban . "131400";
    $modulo = (bcmod($pruefsumme,"97"));
    $pruefziffer =str_pad ( 98 - $modulo, 2, "0",STR_PAD_LEFT);
    $iban = "DE" . $pruefziffer . $bban;
    return $iban;
  }

  /**
   * CAUTION: the @Stuff turn off security checks, for this page no admin is
   *          required and no CSRF check. If you don't know what CSRF is, read
   *          it up in the docs or you might create a security hole. This is
   *          basically the only required method to add this exemption, don't
   *          add it to any other method if you don't exactly know what it does
   *
   * @NoAdminRequired
   * @NoCSRFRequired
   */
  public function index() {
    $params = array('user' => $this->userId,
                    'dialog' => false,
                    'bankAccountIBAN' => '',
                    'bankAccountBIC' => '',
                    'bankAccountBankId' => '',
                    'bankAccountId' => '');
    return new TemplateResponse('bav', 'main', $params);  // templates/main.php
  }

  /**
   * CAUTION: the @Stuff turn off security checks, for this page no admin is
   *          required and no CSRF check. If you don't know what CSRF is, read
   *          it up in the docs or you might create a security hole. This is
   *          basically the only required method to add this exemption, don't
   *          add it to any other method if you don't exactly know what it does
   *
   * @NoAdminRequired
   * @NoCSRFRequired
   */
  public function dialog() {
    $params = array('user' => $this->userId,
                    'dialog' => true,
                    'bankAccountIBAN' => '',
                    'bankAccountBIC' => '',
                    'bankAccountBankId' => '',
                    'bankAccountId' => '');
    return new TemplateResponse('bav', 'main', $params, '');  // templates/main.php
  }

  /**
   * Simply method that posts back the payload of the request
   * @NoAdminRequired
   */
  public function validate($bankAccountIBAN, $bankAccountBIC, $bankAccountBankId, $bankAccountId)
  {
    $message = '';
    $suggestions = '';
    $nl = "\n";
    $anyInput = $bankAccountIBAN.$bankAccountBIC.$bankAccountBankId.$bankAccountId != '';
    
    $bav = new \malkusch\bav\BAV;

    if ($bankAccountIBAN != '') {
      $iban = new \IBAN($bankAccountIBAN);
      
      if (!$iban->Verify()) {
        $message .= $this->l->t('Failed to validate IBAN').$nl;
        $suggestions = array();
        foreach ($iban->MistranscriptionSuggestions() as $alternative) {
          if ($iban->Verify($alternative)) {
            $alternative = $iban->MachineFormat($alternative);
            $alternative = $iban->HumanFormat($alternative);
            $suggestions[] = $alternative;
          }
        }
        $suggestions = implode(', ', $suggestions).$nl;
      }
    }

    if ($bankAccountBankId != '') {
      $blz = $bankAccountBankId;
      if ($bav->isvalidBank($blz)) {
        $bavBIC = $bav->getMainAgency($blz)->getBIC();
        if ($bankAccountBIC == '') {
          $bankAccountBIC = $bavBIC;
        } else if ($bankAccountBIC != $bavBIC) {
          $message .= $this->l->t("Computed BIC %s and submitted BIC %s do not coincide",
                                  array($bavBIC, $bankAccountBIC)).$nl;
        }
      }
      if ($bankAccountId != '') {
        $kto = $bankAccountId;
        if ($bav->isValidAccount($kto)) {
          $selfIBAN = self::makeIBAN($blz, $kto);
          if ($bankAccountIBAN == '') {
            $bankAccountIBAN = $selfIBAN;
          } else if ($bankAccountIBAN != $selfIBAN) {
            $message .= $this->l->t("Generated IBAN %s and submitted IBAN %s do not coincide",
                                    array($selfIBAN, $bankAccountIBAN));
          }
        } else {
          $message .= $this->l->t('The account number %s @ %s appears not to be valid German bank account id.',
                                  array($kto, $blz)).$nl;
        }
      }
    }

    if ($message == '' && $anyInput) {
      $message = $this->l->t('No errors found, but use at your own risk.');
    }
    return array('bankAccountIBAN' => $bankAccountIBAN,
                 'bankAccountBIC' => $bankAccountBIC,
                 'bankAccountBankId' => $bankAccountBankId,
                 'bankAccountId' => $bankAccountId,
                 'message' => nl2br($message),
                 'suggestions' => nl2br($suggestions));
  }

}