<div class="">
  <table class="table table-bordered table-hover listing">
    <thead>
      <tr class="grid-header">
        <th>Payment Method</th>
        <th>Payment Date</th>
        <th>Amount</th>
        <th>Operation</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($upload_payment) {
        foreach ($upload_payment as $upload) {
          ?>
          <tr>
            <td><?php echo $this->Html->link(__(h($upload['UploadPayment']['payment_method']), true), array('action' => 'download_single_file_payment', $upload['UploadPayment']['id'])); ?></td>
            <td><?php echo $this->Util->formatDate($upload['UploadPayment']['payment_date']); ?></td>
            <td><?php echo "$".$upload['UploadPayment']['amount']; ?></td>
            <td style="width:20px">
              <?php
								if($upload['UploadPayment']['filesize'] != 0)
									echo $this->Html->link(__('', true), array('action' => 'download_single_file_payment', $upload['UploadPayment']['id']), array('class' => 'icon-download-alt')); 
							?>
              <?php
								$wo_status = $this->InventoryLookup->WorkOrderStatus($work_order['WorkOrder']['id']);
								if($wo_status != 'Approve')
									echo $this->Html->link(__('', true), array('action' => 'delete_single_file_payment', $work_order['WorkOrder']['id'], $upload['UploadPayment']['id']), array('class' => 'icon-trash ask-delete', 'data-button' => "Delete {$upload['UploadPayment']['filename']}", 'data-msg' => "Do you really want to delet the file '{$upload['UploadPayment']['filename']}'")); 
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


