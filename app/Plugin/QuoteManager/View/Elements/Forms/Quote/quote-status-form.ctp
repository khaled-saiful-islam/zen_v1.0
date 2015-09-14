<fieldset>
  <?php if ($edit) { ?>
    <legend class='inner-legend'>
      Change Status
    </legend>
  <?php } ?> 

  <div id="quote_pricing" >    
    <table class="table-form-big">
      <tbody>       
        <tr>
          <th>
            <label for="">Status:</label>
          </th>
          <td>
            <?php echo $this->Form->input('QuoteStatus.status', array('placeholder'=>'Status','class'=>'required form-select','options'=>array('Review'=>'Review','Change'=>'Change','Approve'=>'Approve','Cancel'=>'Cancel'))); ?>
            <?php echo $this->Form->input('QuoteStatus.user_id', array('type'=>'hidden','value'=>$user_id)); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Comment:</label>
          </th>
          <td>
            <?php echo $this->Form->input('QuoteStatus.comment', array('placeholder'=>'Comment','cols'=>'80','rows'=>'3')); ?>
          </td>
        </tr>        
      </tbody>
    </table>
  </div>
</fieldset>
