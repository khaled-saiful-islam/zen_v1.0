<div class="quote-report">

  <?php
  echo $this->Html->link(
          'Order Form', array('controller' => 'quotes', 'action' => 'order_form', $quote['Quote']['id']), array('class' => 'open-link btn btn-success', 'data_target' => 'quote_report', 'title' => 'Print Detail Information')
  );
  ?>

  <?php
  echo $this->Html->link(
          'Counter Top', array('controller' => 'quotes', 'action' => 'counter_top_form', $quote['Quote']['id']), array('class' => 'open-link btn btn-success', 'data_target' => 'quote_report', 'title' => 'Print Detail Information')
  );
  ?>

  <?php
  echo $this->Html->link(
          'Pricing', array('controller' => 'quotes', 'action' => 'pricing_form', $quote['Quote']['id']), array('class' => 'open-link btn btn-success', 'data_target' => 'quote_report', 'title' => 'Print Detail Information')
  );
  ?>
  <?php
  echo $this->Html->link(
          'Install Completion', array('controller' => 'quotes', 'action' => 'install_completion', $quote['Quote']['id']), array('class' => 'open-link btn btn-success', 'data_target' => 'quote_report', 'title' => 'Print Detail Information')
  );
  ?>
</div>
