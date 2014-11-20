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

        var clearing = false;
        var validating = false;
        dialogHolder.dialog({
          title: t('bav', 'BAV - Bank Account Validator (DE)'),
          width: 'auto',
          height: 'auto',
          modal: true,
          closeOnEscape: false,
          dialogClass: 'bav',
          resizable: false,
          buttons: [
            { 'text': t('bav', 'Clear'),
              'class': 'clear',
              'title': t('bav', 'Clear all fields of the input form'),
              click: function() {
                clearing = true;
                dialogHolder.find('input.bankAccountBIC').val('');
                dialogHolder.find('input.bankAccountIBAN').val('');
                dialogHolder.find('input.bankAccountBankId').val('');
                dialogHolder.find('input.bankAccountId').val('');
                dialogHolder.find('input.bankAccountBankName').val('');
                dialogHolder.find('div.status').html('');
                if (!validating) {
                  clearing = false;
                }
              }
            }
          ],
          open: function() {
            $('#navigation').hide();

            dialogHolder.find('input[type="text"]').
              off('blur').
              on('blur', function(event) {
              //alert('blur');
              if (clearing) {
                clearing = false;
                return false;
              }
              event.stopImmediatePropagation();
              validating = true;
              $.post(OC.generateUrl('/apps/bav/validate'),
                     dialogHolder.find('form').serialize()).success(function(result) {
                validating = false;
                if (clearing) {
                  clearing = false;
                  return false;
                }
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
