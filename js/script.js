/**
 * ownCloud - bav
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Claus-Justus Heine <himself@claus-justus-heine.de>
 * @copyright Claus-Justus Heine 2014
 */

(function ($, OC) {

  $(document).ready(function () {

    var anchor = $('#apps li[data-id="bav"] a');
    anchor.click(function(event) {
      $.post(OC.generateUrl('/apps/bav/bav'), {}).success(function(result) {
        var dialogHolder = $('<div id="bav-container"></div>');
        dialogHolder.html(result);
        $('body').append(dialogHolder);
        dialogHolder = $('#bav-container');

        dialogHolder.dialog({
          title: t('bav', 'BAV - Bank Account Validator (DE)'),
          width: 'auto',
          height: 'auto',
          modal: true,
          closeOnEscape: false,
          dialogClass: 'bav',
          resizable: false,
          open: function() {
            $('#navigation').hide();

            dialogHolder.find('input[type="text"]').
              off('blur').
              on('blur', function(event) {
              event.stopImmediatePropagation();
              $.post(OC.generateUrl('/apps/bav/validate'),
                     dialogHolder.find('form').serialize()).success(function(result) {
                //alert('RESULT '+result.bankAccountIBAN);
                dialogHolder.find('input.bankAccountBIC').val(result.bankAccountBIC);
                dialogHolder.find('input.bankAccountIBAN').val(result.bankAccountIBAN);
                dialogHolder.find('input.bankAccountBankId').val(result.bankAccountBankId);
                dialogHolder.find('input.bankAccountId').val(result.bankAccountId);
                dialogHolder.find('input.bankAccountBankName').val(result.bankAccountBankName);
                dialogHolder.find('div.status').html(result.message);
                return false;
              });
              return false;
            });
          },
          close: function(event) {
            dialogHolder.dialog('destroy');
            dialogHolder.remove();
          }
        });
      });
      return false;
    });

  });

})(jQuery, OC);
