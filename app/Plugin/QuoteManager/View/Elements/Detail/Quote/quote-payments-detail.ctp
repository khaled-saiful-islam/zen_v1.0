<div class="">
  <table class="table table-bordered table-hover listing">
    <thead>
      <tr class="grid-header">
				<th>Serial Number</th>
        <th>Payment Method</th>
        <th>Payment Date</th>
        <th>Amount</th>
				<th>Comment</th>
        <th>Operation</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($upload_payment) {
        foreach ($upload_payment as $upload) {
          ?>
          <tr>
						<td><?php echo sprintf('%05u', $upload['UploadPayment']['serial_no']); ?></td>
            <td><?php echo $this->Html->link(__(h($upload['UploadPayment']['payment_method']), true), array('action' => 'download_single_file_payment', $upload['UploadPayment']['id'])); ?></td>
            <td><?php echo $this->Util->formatDate($upload['UploadPayment']['payment_date']); ?></td>
            <td><?php echo "$".$upload['UploadPayment']['amount']; ?></td>
						<td><?php echo $upload['UploadPayment']['comment']; ?></td>
            <td style="width:20px">
              <?php 
								if($upload['UploadPayment']['filesize'] != 0)
									echo $this->Html->link(__('', true), array('action' => 'download_single_file_payment', $upload['UploadPayment']['id']), array('class' => 'icon-download-alt')); 
								if($upload['UploadPayment']['filesize'] == 0)
									echo $this->Html->link(__('', true), array('action' => 'edit_payment', $upload['UploadPayment']['id']), array('data-target' => '#payment-info','class' => 'icon-upload ajax-sub-content')); 
							?>
              <?php
								$quote_status = $this->InventoryLookup->QuoteStatus($quote['Quote']['id']);
								if($quote_status != 'Review' && $quote['Quote']['delete'] == 0)
								echo $this->Html->link(__('', true), array('action' => 'delete_single_file_payment', $quote['Quote']['id'], $upload['UploadPayment']['id']), array('class' => 'icon-trash ask-delete', 'data-button' => "Delete {$upload['UploadPayment']['filename']}", 'data-msg' => "Do you really want to delet the file '{$upload['UploadPayment']['filename']}'")); 
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


