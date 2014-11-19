<?php
if (!isset($_['dialog']) || !$_['dialog']) {
  \OCP\Util::addScript('bav', 'script');
  \OCP\Util::addStyle('bav', 'style');
}

$L = \OC_L10N::get('bav');

?>
<form class="bank-account-validator">
  <table>
    <tr>
      <td class="label">
        <?php echo $L->t('IBAN'); ?>
      </td><td>
        <input class="bankAccountIBAN"
               type="text"
               name="bankAccountIBAN"
               value="<?php $_['bankAccountIBAN']; ?>"
               placeholder="<?php echo $L->t("IBAN of bank account"); ?>" />
      </td>
    </tr>
    <tr>
      <td class="label">
        <?php echo $L->t('BIC'); ?>
      </td><td>
        <input class="bankAccountBIC"
               type="text"
               name="bankAccountBIC"
               value="<?php $_['bankAccountBIC']; ?>"
               placeholder="<?php echo $L->t("BIC of bank"); ?>" />
      </td>
    </tr>
    <tr>
      <td class="label">
        <?php echo $L->t('Bank Id'); ?>
      </td><td>
        <input class="bankAccountBankId"
               type="text"
               name="bankAccountBankId"
               value="<?php echo $_['bankAccountBankId']; ?>"
               placeholder="<?php echo $L->t("Bank id of bank account"); ?>" />
      </td>
    </tr>
    <tr>
      <td class="label">
        <?php echo $L->t('Account Id'); ?>
      </td><td>
        <input class="bankAccountId"
               type="text"
               name="bankAccountId"
               value="<?php $_['bankAccountId']; ?>"
               placeholder="<?php echo $L->t("Id of bank account"); ?>" />
      </td>
    </tr>
    <tr>
      <td>
        <?php echo $L->t('Bank'); ?>
      </td>
      <td>
        <input class="bankAccountBankName"
               type="text"
               name="bankAccountBankName"
               value="<?php echo $_['bankAccountBanName']; ?>"
               placeholder="<?php echo $L->t("Bank Name"); ?>"
               disabled="disabled"
               />
      </td>
    </tr>
  </table>
  <div class="status"></div>
  <div class="suggestions"></div>
</form>
