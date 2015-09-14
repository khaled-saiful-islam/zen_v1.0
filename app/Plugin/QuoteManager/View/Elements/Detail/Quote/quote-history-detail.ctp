<fieldset>
  <?php
  App::import('Model', 'QuoteManager.Quote');
  $quote_model = new Quote();
//  $quote_model->recursive = -1;
  $versions = $quote_model->find('all', array('conditions' => array('Quote.vid' => $quote['Quote']['id']), 'order' => array('Quote.id' => 'DESC')));

  if (isset($versions) && !empty($versions)) {
    ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>
        <tr class="grid-header">
          <th>Status</th>
          <th>Posted&nbsp;By</th>
          <th>Posted&nbsp;Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($versions as $key => $revision) {
          ?>
          <tr>
            <td>
              <?php
              echo $this->Html->link(
                      h($revision['Quote']['status']), array('controller' => 'quotes', 'action' => 'print_detail', $revision['Quote']['id']), array('class' => 'open-link table-first-column-color', 'data_target' => 'quote_log')
              );
              ?>
              &nbsp;
            </td>
            <td><?php echo h($revision['User']['first_name'] . ' ' . $revision['User']['last_name']); ?>&nbsp;</td>
            <td><?php echo h($this->Util->formatDate($revision['Quote']['created'])); ?>&nbsp;</td>
          </tr>

          <?php
        }
        ?>
      </tbody>
    </table>
    <?php
  } else {
    ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>
        <tr class="grid-header">
          <th>Status</th>
          <th>Posted&nbsp;By</th>
          <th>Posted&nbsp;Date</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="3">
            <label class="text-cursor-normal">No data here</label>
          </td>
        </tr>
      </tbody>
    </table>
  <?php } ?>
</fieldset>
<script type="text/javascript">
  $(".quote-status-form").validate({ignore: null});
  $(".quote-status-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#quote-status-detail'});
</script>
