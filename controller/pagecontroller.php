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

namespace OCA\TestApp\Controller;


use \OCP\IRequest;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\AppFramework\Controller;

class PageController extends Controller {

  private $userId;

  public function __construct($appName, IRequest $request, $userId){
    parent::__construct($appName, $request);
    $this->userId = $userId;
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
  public function doBlahEcho($foobar, $echo, $blahfoobar) {
    return array('echo' => $echo.$foobar.'blub'.$blahfoobar);
  }


}