<fieldset>
  <?php if ($edit) { ?>
    <legend class='inner-legend'>
      Edit Installer Paysheet
    </legend>
  <?php } ?> 

  <div id="installer_paysheet_items" >    
    <table class="table-form-big table-form-big-margin">
      <thead>
        <tr>   
          <th>Quantity</th>
          <th>Task Description</th>
          <th>Unit</th>
          <th>Price Each</th>
          <th>Total</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr class="clone-row hide">
          <td>
            <?php
            echo $this->Form->input("QuoteInstallerPaysheet.-1.quote_id", array("type" => "hidden", "class" => "quote_id user-input", 'value' => $this->data['Quote']['id']));

            echo $this->Form->input("QuoteInstallerPaysheet.-1.quantity", array(
                "class" => "quantity user-input small-input set-cost",
                "placeholder" => "Quantity",
                "label" => false,
                'type'=>'text'
            ));
            ?>
          </td>
          <td>
            <?php
            echo $this->Form->input("QuoteInstallerPaysheet.-1.task_description", array(
                "class" => "task_description user-input",
                "placeholder" => "Task Description",
                "label" => false
            ));
            ?>
          </td>
          <td>
            <?php
            echo $this->Form->input("QuoteInstallerPaysheet.-1.unit", array(
                "class" => "unit user-input",
                "placeholder" => "Unit",
                "label" => false,
                'type'=>'text'
            ));
            ?> 
          </td>
          <td class="">
            <?php
            echo $this->Form->input("QuoteInstallerPaysheet.-1.price_each", array(
                "class" => "price_each user-input set-cost",
                "placeholder" => "Price Each",
                "label" => false,
            ));
            ?> 
          </td>
          <td>          
            <?php
            echo $this->Form->input("QuoteInstallerPaysheet.-1.total", array(
                "class" => "total user-input small-input",
                "placeholder" => "Total",
                "label" => false,
                "readonly" => 'readonly',
            ));
            ?>          
          </td>          
          <td>
            <a href="#" class="icon-remove icon-remove-margin remove"></a>
          </td>
        </tr>
        <?php
        if (!empty($this->data['QuoteInstallerPaysheet'])) {
          foreach ($this->data['QuoteInstallerPaysheet'] as $index => $value) {
            ?>
            <tr class="clone-row">
              <td>
                <?php
                echo $this->Form->input("QuoteInstallerPaysheet.{$index}.quote_id", array("type" => "hidden", "class" => "quote_id user-input", 'value' => $this->data['Quote']['id']));

                echo $this->Form->input("QuoteInstallerPaysheet.{$index}.quantity", array(
                    "class" => "quantity user-input small-input set-cost",
                    "placeholder" => "Quantity",
                    "label" => false
                ));
                ?>
              </td>
              <td>
                <?php
                echo $this->Form->input("QuoteInstallerPaysheet.{$index}.task_description", array(
                    "class" => "task_description user-input",
                    "placeholder" => "Task Description",
                    "label" => false
                ));
                ?>
              </td>
              <td>
                <?php
                echo $this->Form->input("QuoteInstallerPaysheet.{$index}.unit", array(
                    "class" => "unit user-input",
                    "placeholder" => "Unit",
                    "label" => false,
                    'type'=>'text'
                ));
                ?> 
              </td>
              <td class="">
                <?php
                echo $this->Form->input("QuoteInstallerPaysheet.{$index}.price_each", array(
                    "class" => "price_each user-input small-input set-cost",
                    "placeholder" => "Price Each",
                    "label" => false,
                ));
                ?> 
              </td>
              <td>          
                <?php
                
                if(!empty($value['quantity']) && !empty($value['price_each']))
                  $total = number_format($value['quantity']*$value['price_each'],2,'.','');
                else
                  $total = 0.00;
                
                echo $this->Form->input("QuoteInstallerPaysheet.{$index}.total", array(
                    "class" => "total user-input small-wide-input",
                    "placeholder" => "Total",
                    "label" => false,
                    "readonly" => 'readonly',
                    'value' => $total
                ));
                ?>          
              </td>          
              <td>
                <a href="#" class="icon-remove icon-remove-margin remove"></a>
              </td>
            </tr>
            <?php
          }
        }
        ?>        
        <tr>
          <td colspan="6">
            <input type="button" class="btn btn-info add-more" value="Add More" />	
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</fieldset>
