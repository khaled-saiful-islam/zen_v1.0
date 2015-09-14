<?php
$row_size = 5;
$col_size = 3;
for ($index = 0; $index < $row_size; $index++) {
  for ($sub_index = 0; $sub_index < $col_size; $sub_index++) {
    ?>

    <div style="float:left;">
      <div class="header" style="text-align: center;">
        <div style="font-size: 15pt;"><?php echo h($item['Item']['item_title']); ?></div>
        <div style="font-size: 10pt;"><?php echo h($item['Item']['description']); ?></div>
      </div>
      <?php echo $this->Html->image('header_logo.jpg', array('widht' => '50px', 'height' => '50px')); ?>
      &nbsp;
      <?php echo $this->Html->image('/inventory/items/barcode/' . $item['Item']['id']); ?>
      <?php
      if ($sub_index < ($col_size - 1))
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
      ?>
    </div>
    <?php
  }
  echo '<p style="clear:both;">&nbsp;</p>';
}
exit;

