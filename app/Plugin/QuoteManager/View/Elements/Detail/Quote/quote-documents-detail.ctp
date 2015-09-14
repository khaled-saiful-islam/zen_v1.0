<div class="">
  <table class="table table-bordered table-hover listing">
    <thead>
      <tr class="grid-header">
        <th>Title</th>
        <th>File Name</th>
        <th>description</th>
        <th>Uploaded Date</th>
        <th>Operation</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($uploads) {
        foreach ($uploads as $upload) {
          ?>
          <tr>
            <td><?php echo $this->Html->link(__(h($upload['Upload']['title']), true), array('action' => 'download_single_file', $upload['Upload']['id'])); ?></td>
            <td><?php echo $upload['Upload']['filename']; ?></td>
            <td><?php echo $upload['Upload']['description']; ?></td>
            <td><?php echo $upload['Upload']['created']; ?></td>
            <td style="width:20px">
              <?php echo $this->Html->link(__('', true), array('action' => 'download_single_file', $upload['Upload']['id']), array('class' => 'icon-download-alt')); ?>
              <?php
								$quote_status = $this->InventoryLookup->QuoteStatus($quote['Quote']['id']);
								if($quote_status != 'Review' && $quote['Quote']['delete'] == 0)
								echo $this->Html->link(__('', true), array('action' => 'delete_single_file', $quote['Quote']['id'], $upload['Upload']['id']), array('class' => 'icon-trash ask-delete', 'data-button' => "Delete {$upload['Upload']['filename']}", 'data-msg' => "Do you really want to delet the file '{$upload['Upload']['filename']}'")); 
							?>
            </td>
          </tr>
          <?php
        }
      } else {
        ?>
        <tr>
          <td colspan="5">There is no file to download</td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>


