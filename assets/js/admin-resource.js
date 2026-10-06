/**
 * The "Document or link" box on a resource (inc/resources-admin.php): choosing or
 * uploading its document from the Media Library, and removing it
 */
(function($) {
  $(function() {
    const box = $('#donphin_resource_meta');
    if (!box.length || !window.wp || !wp.media) return;

    const input = box.find('[data-dp-res-file]');
    const name = box.find('[data-dp-res-file-name]');
    const remove = box.find('[data-dp-res-remove]');
    let frame = null;

    box.on('click', '[data-dp-res-choose]', function(e) {
      e.preventDefault();
      if (!frame) {
        frame = wp.media({
          title: 'Choose the document',
          button: { text: 'Use this file' },
          multiple: false
        });
        frame.on('select', function() {
          const file = frame.state().get('selection').first().toJSON();
          input.val(file.id);
          name.text(file.filename);
          remove.show();
        });
      }
      frame.open();
    });

    remove.on('click', function(e) {
      e.preventDefault();
      input.val('');
      name.text('No file yet');
      remove.hide();
    });
  });
})(jQuery);
