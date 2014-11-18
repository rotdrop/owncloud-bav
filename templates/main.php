<?php
if (!isset($_['dialog']) || !$_['dialog']) {
  \OCP\Util::addScript('bav', 'script');
  \OCP\Util::addStyle('bav', 'style');
}
?>
<form class="bank-account-validator">
  <input class="bankAccountIBAN"
         type="text"
         name="bankAccountIBAN"
         value="<?php $_['bankAccountIBAN']; ?>"
         placeholder="<?php echo "IBAN of bank account"; ?>" />
  <br/>
  <input class="bankAccountBIC"
         type="text"
         name="bankAccountBIC"
         value="<?php $_['bankAccountBIC']; ?>"
         placeholder="<?php echo "BIC of bank"; ?>" />
  <br/>
  <input class="bankAccountBankId"
         type="text"
         name="bankAccountBankId"
         value="<?php echo $_['bankAccountBankId']; ?>"
         placeholder="<?php echo "Bank id of bank account"; ?>" />
  <br/>
  <input class="bankAccountId"
         type="text"
         name="bankAccountId"
         value="<?php $_['bankAccountId']; ?>"
         placeholder="<?php echo "Id of bank account"; ?>" />
  <br/>
</form>
