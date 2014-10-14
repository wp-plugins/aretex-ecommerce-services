<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    
    <nav>
    <div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px;">
    
    
    
    
    <div class="button-set">
        <button id="home" class="menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-home"></span>Home</button>
        
        <button id="contact" class="menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-person"></span>Contact</button>
    
        <button id="payments" class="menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-suitcase"></span>Payments</button>    
 <?php
        if ($signed_up->tier_1_commission_group_id > 0) {
 ?>
        <button id="promote" class="menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-star"></span>Referral</button>
 <?php
        }       
 ?>      
        
    </div>
    
    
    
    </div>
    </nav>

    </div> <!-- END Column -->
</div> <!-- END ROW -->