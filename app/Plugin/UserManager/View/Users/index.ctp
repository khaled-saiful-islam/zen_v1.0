<?php
if ($paginate) {
  ?>
  <div class="users index">
    <fieldset class="content-detail">
      <legend>
        <?php echo __('Users'); ?>
        <div class="report-buttons">
          <?php
          $url = $this->params['plugin'] . '/' . $this->params['controller'] . '/listing_report_print/';
          foreach ($this->params['named'] as $key => $value) {
            $url .= $key . ':' . $value . '/';
          }
          ?>
          <a href="<?php echo $this->webroot . $url; ?>" class="icon-print open-link show-tooltip" data_target="item_report" title="Print Listing"></a>
        </div>
      </legend>
      <div align="right">
        <a class="search_link" href="#">
          <span class="search-img">Search</span>
        </a>
      </div>
      <div id="search_div">
        <?php echo $this->Form->create('User', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
        <table class="table-form-big search_div">
          <tr>
            <td>
              <?php echo $this->Form->input('enhanced_search', array('placeholder' => 'Name')); ?>
            </td>
            <td>
              <?php echo $this->Form->input('username', array('placeholder' => 'User Name')); ?>
            </td>
            <td>
              <?php echo $this->Form->input('title', array('placeholder' => 'Title')); ?>
            </td>
            <td>
              <?php echo $this->Form->input('email1', array('placeholder' => 'Email')); ?>
            </td>
            <td>
              <?php echo $this->Form->input('role', array('options' => $this->InventoryLookup->InventoryLookup('user_role'), 'placeholder' => 'Role', 'empty' => true, 'class' => 'form-select')); ?>
            </td>
            <td class="width-min">
                <div style="margin-top: -20px;">
                    <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success')); ?>
                </div>
            </td>
          </tr>
        </table>
        <?php echo $this->Form->end(); ?>
      </div>
      <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
        <thead>
          <tr class="grid-header">
            <th><?php echo $this->Paginator->sort('name', 'Name', array('direction' => 'asc')); ?></th>
            <th><?php echo $this->Paginator->sort('empid', 'Employee Number'); ?></th>
            <th><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
            <th><?php echo $this->Paginator->sort('username', 'User Name'); ?></th>
            <th><?php echo $this->Paginator->sort('email1', 'Email 1'); ?></th>
            <th><?php echo $this->Paginator->sort('role'); ?></th>
            <th><?php echo $this->Paginator->sort('status'); ?></th>
            <th class="actions"><?php echo __(''); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($users as $user) {
            if ($login_user['id'] != $user['User']['id']) {
              ?>
              <tr>
                <td>
                  <?php
                  $user_name = h($user['User']['first_name']) . ' ' . h($user['User']['last_name']);
                  echo $this->Html->link($user_name, array('action' => DETAIL, $user['User']['id']), array('class' => 'table-first-column-color'));
                  ?>
                  &nbsp;
                </td>
                <td><?php echo h($user['User']['empid']); ?>&nbsp;</td>
                <td><?php echo h($user['User']['title']); ?>&nbsp;</td>
                <td><?php echo h($user['User']['username']); ?>&nbsp;</td>
                <td><?php echo h($user['User']['email1']); ?></td>
                <td>
                  <?php
                  if (!empty($user['User']['role'])) {
                    $role = $this->InventoryLookup->InventorySpecificLookup('user_role', $user['User']['role']);
                    echo h($role[$user['User']['role']]);
                  }
                  ?>
                </td>
                <td><?php
                  $status = $user['User']['status'] == '1' ? "Active" : "Inactive";
                  echo h($status);
                  ?>&nbsp;</td>
                <td class="actions">
                  <?php echo $this->Html->link('', array('action' => DETAIL, $user['User']['id']), array('title' => __('View'), 'class' => 'icon-file')); ?>
                  <?php echo $this->Form->postLink('', array('action' => DELETE, $user['User']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $user_name)); ?>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        </tbody>
      </table>

      <?php echo $this->element('Common/paginator'); ?>
    </fieldset>
  </div>
<?php } else { ?>
  <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
    <thead>
      <tr class="grid-header">
        <th><?php echo $this->Paginator->sort('name', 'Name', array('direction' => 'asc')); ?></th>
        <th><?php echo $this->Paginator->sort('empid', 'Employee Number'); ?></th>
        <th><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
        <th><?php echo $this->Paginator->sort('username', 'User Name'); ?></th>
        <th><?php echo $this->Paginator->sort('email1', 'Email 1'); ?></th>
        <th><?php echo $this->Paginator->sort('role'); ?></th>
        <th><?php echo $this->Paginator->sort('status'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($users as $user) {
        if ($login_user['id'] != $user['User']['id']) {
          ?>
          <tr>
            <td>
              <?php
              $user_name = h($user['User']['first_name']) . ' ' . h($user['User']['last_name']);
              echo $user_name;
              ?>
              &nbsp;
            </td>
            <td><?php echo h($user['User']['empid']); ?>&nbsp;</td>
            <td><?php echo h($user['User']['title']); ?>&nbsp;</td>
            <td><?php echo h($user['User']['username']); ?>&nbsp;</td>
            <td><?php echo h($user['User']['email1']); ?></td>
            <td>
              <?php
              if (!empty($user['User']['role'])) {
                $role = $this->InventoryLookup->InventorySpecificLookup('user_role', $user['User']['role']);
                echo h($role[$user['User']['role']]);
              }
              ?>
            </td>
            <td><?php
              $status = $user['User']['status'] == '1' ? "Active" : "Inactive";
              echo h($status);
              ?>&nbsp;</td>

          </tr>
          <?php
        }
      }
      ?>
    </tbody>
  </table>
<?php } ?>