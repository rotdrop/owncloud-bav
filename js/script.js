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
          title: 'bav dialog',
          width: 'auto',
          height: 'auto',
          modal: true,
          closeOnEscape: false,
          dialogClass: 'bav',
          resizable: true,
          open: function() {
            $('#navigation').hide();
          },
          close: function(event) {
            dialogHolder.dialog('destroy');
            dialogHolder.remove();
          }
        });
      });
      return false;
    });

    $('#hello').click(function () {
      alert('Hello from your script file');
    });

    $('#echo').click(function () {
      var url = OC.generateUrl('/apps/bav/echo');
      var data = {
	echo: $('#echo-content').val(),
        foobar: 'blub',
        blahfoobar: 'huhu'
      };

      $.post(url, data).success(function (response) {
	$('#echo-result').text(response.echo);
      });
      
    });
  });

})(jQuery, OC);
