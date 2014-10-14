<?php 
$deliverable_code = $_REQUEST['deliverable'];
?>
<strong>3. Select the Product for your Buy Button</strong>&nbsp;<span id="step3_check"></span><br />
<?php 
echo AreteX_paid_content::deliverable_product_selector($deliverable_code);
?>
