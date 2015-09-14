<div id="item_notes" class="tab-pane">
  <fieldset>
    <legend <?php if ($edit) { ?>class="inner-legend"<?php } ?>><?php echo __('Edit Item Notes'); ?></legend>
    <div class="item-notes">
      <table class="table-form-big" style="width: 65%;">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr class="clone-row">
            <td>
              <?php
              echo $this->Form->input("ItemNote.0.id", array("type" => "hidden",));

              echo $this->Form->input("ItemNote.0.name", array(
                  "class" => "name user-input",
                  "placeholder" => "Title",
                  "label" => false,
              ));
              ?>
            </td>
            <td>
              <?php
              echo $this->Form->input("ItemNote.0.value", array(
                  "class" => "value user-input",
                  "placeholder" => "Description",
                  "label" => false,
              ));
              ?>
            </td>
            <td>
              <?php
              echo $this->Form->input("ItemNote.0.note_date", array(
                  "class" => "note_date user-input dateP",
                  "placeholder" => "Date",
                  "label" => false,
              ));
              ?>
              <a href="#" class="icon-remove hide remove"></a>
            </td>
          </tr>
          <?php
          if (!empty($this->data['ItemNote'])) {
            foreach ($this->data['ItemNote'] as $index => $value) {
              if ($index == 0)
                continue; // skip the first 1 as it is already in place
              ?>
              <tr class="clone-row">
                <td>
                  <?php
                  echo $this->Form->input("ItemNote.{$index}.id", array("type" => "hidden", 'class' => 'user-input'));

                  echo $this->Form->input("ItemNote.{$index}.name", array(
                      "class" => "name user-input",
                      "placeholder" => "Title",
                      "label" => false,
                      'type' => 'text',
                  ));
                  ?>
                </td>
                <td>
                  <?php
                  echo $this->Form->input("ItemNote.{$index}.value", array(
                      "class" => "value user-input",
                      "placeholder" => "Description",
                      "label" => false,
                  ));
                  ?>
                </td>
                <td>
                  <?php
                  echo $this->Form->input("ItemNote.{$index}.note_date", array(
                      "class" => "note_date user-input dateP",
                      "placeholder" => "Date",
                      "label" => false,
                  ));
                  ?>
                  <a href="#" class="icon-remove remove"></a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
          <tr>
            <td colspan="3">
              <input type="button" class="btn btn-info add-more" value="Add More" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </fieldset>
</div>