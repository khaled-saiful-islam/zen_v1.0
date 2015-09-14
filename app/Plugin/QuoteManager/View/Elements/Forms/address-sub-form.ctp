<!-- <table> -->
<tr>
  <th><label for="QuoteAddress1">Address: </label></th>
  <td colspan="3">
    <?php echo $this->Form->input('address_1', array('class' => 'required wide-input', 'placeholder' => 'Address Line 1')); ?>
    &nbsp;
    <?php echo $this->Form->input('address_2', array('class'=>'wide-input','placeholder' => 'Address Line 2')); ?>
  </td>
</tr>
<tr>
  <th class=""><label for="QuoteCity">City: </label></th>
  <td><?php echo $this->Form->input('city', array('class' => 'required')); ?></td>
  <th><label for="QuoteSate">Sate: </label></th>
  <td><?php echo $this->Form->input('state', array('class' => 'required')); ?></td>
</tr>
<tr>
  <th><label for="QuoteZip">Zip: </label></th>
  <td><?php echo $this->Form->input('zip', array('class' => 'required')); ?></td>
  <th><label for="QuoteCountry">Country: </label></th>
  <td><?php echo $this->Form->input('country', array('class' => 'required')); ?></td>
</tr>
<!-- </table> -->