
<?php

//echo $this->element('Forms/Quote/quote-form', array('data' => $quote_data,'legend' => 'Edit Quote', 'edit' => true));
echo $this->element('Forms/Quote/quote-form-edit', array('data' => $quote_data,'legend' => 'Edit Quote', 'edit' => true));
?>