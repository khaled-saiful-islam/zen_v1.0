<div class="installers index">
  <fieldset class="content-detail">
    <legend><?php echo __('Installer'); ?></legend>
    <div align="right">
      <a class="search_link" href="#">
        <span class="search-img">Search</span>
      </a>
    </div>
    <div id="search_div">
      <?php echo $this->Form->create('Installer', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
      <table class="table-form-big search_div" style="min-width:200px;">
        <tr>          
          <td>
            <?php echo $this->Form->input('id', array('options' => $this->InventoryLookup->getInstallerName(), 'empty' => true, 'class' => 'form-select', 'placeholder' => 'Name')); ?>
          </td> 
          <td>
            <?php echo $this->Form->input('phone', array('placeholder' => 'Phone Number', 'class' => 'phone-mask input-medium')); ?>
          </td> 
          <td>
            <?php echo $this->Form->input('pager', array('placeholder' => 'Pager Number', 'class' => 'phone-mask input-medium')); ?>
          </td> 
          <td>
            <?php echo $this->Form->input('cell', array('placeholder' => 'Cell Number', 'class' => 'phone-mask input-medium')); ?>
          </td> 
          <td class="width-min">
            <?php echo $this->Form->input('rating', array('placeholder' => 'Rating', 'class' => 'small-input')); ?>
          </td> 
          <td class="width-min">
            <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success', "style" => "position: relative; ;top: -20px;")); ?>
          </td>
        </tr>
      </table>
      <?php echo $this->Form->end(); ?>
    </div>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>        
        <tr class="grid-header">
          <th><?php echo $this->Paginator->sort('name_lookup_id', 'Name', array('direction' => 'asc')); ?></th>
          <th><?php echo $this->Paginator->sort('phone', 'Phone Number'); ?></th>
          <th><?php echo $this->Paginator->sort('pager', 'Pager Number'); ?></th>
          <th><?php echo $this->Paginator->sort('cell', 'Cell Number'); ?></th>
          <th><?php echo $this->Paginator->sort('rating', 'Rating'); ?></th>
          <th class="actions"><?php echo __(''); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($installers as $installer):
          ?>
          <tr>
            <td>	    
              <?php //echo $this->Html->link($installer['InventoryLookup']['name'], array('action' => DETAIL, $installer['Installer']['id']), array('class' => 'table-first-column-color show-tooltip show-detail-ajax')); ?>
              <?php echo $this->Html->link(h($installer['Installer']['name_lookup_id']), array('action' => DETAIL, $installer['Installer']['id']), array('class' => 'table-first-column-color show-tooltip show-detail-ajax')); ?>
            </td>
            <td><?php echo h($installer['Installer']['phone']); ?></td>
            <td><?php echo h($installer['Installer']['pager']); ?></td>
            <td><?php echo h($installer['Installer']['cell']); ?></td>
            <td><?php echo h($installer['Installer']['rating']); ?></td>
            <td class="actions">
              <?php echo $this->Html->link('', array('action' => DETAIL, $installer['Installer']['id']), array('class' => 'icon-file show-detail-ajax', 'title' => __('View'))); ?>
              <?php echo $this->Form->postLink('', array('action' => DELETE, $installer['Installer']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $installer['Installer']['id'])); ?>

            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php echo $this->element('Common/paginator'); ?>
  </fieldset>
</div>
