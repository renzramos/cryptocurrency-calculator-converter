<header>Crytocurrency Converter</header>

        <div class="row row-options">
        
	        <div class="col-md-4">
	            
	            <div class="form-group">
	                <label>1. Enter the amount to convert</label>
	                <input onfocus="if(this.value == '0') { this.value = ''; }" type="number" id="amount" value="0" min="0" class="form-control"/>
	            </div>
	            
	        </div>
	        
	        
	         <div class="col-md-4 crytocurrency-container">
	              <div class="form-group">
	                <label>2. Select cryptocurrency</label>
    			    <select id="select-cryptocurrency" class="form-control">
    			        <?php while ( $query->have_posts() ) { 
    			            
        			        $query->the_post();
                        	$id =  get_the_id();
                        	$price_details = get_post_meta( $id, 'price_details', true );
        					$price_details = unserialize($price_details);
        					$id = $price_details["id"];
        					$coin_name = $price_details["name"];
        					$coin_symbol = $price_details["symbol"];
        					$coin_rank = $price_details["rank"];
        					$coin_price_usd = $price_details["price_usd"];
        					$coin_price_btc = $price_details["price_btc"];
        					$coin_24h_volume_usd = $price_details["24h_volume_usd"];
        					$coin_market_cap_usd = $price_details["market_cap_usd"];
        					$coin_available_supply = $price_details["available_supply"];
        					$coin_total_supply = $price_details["total_supply"];
        					$coin_percent_change_1h = $price_details["percent_change_1h"];
        					$coin_percent_change_24h = $price_details["percent_change_24h"];
        					$coin_percent_change_7d = $price_details["percent_change_7d"];
        					$coin_last_updated = $price_details["last_updated"];
        					
        					if ($coin_price_usd == '') continue;
    					?>
    			        
    			        <option data-symbol="<?php echo $coin_symbol; ?>" <?php echo (get_the_title() == 'Bitcoin') ? 'selected' : ''; ?> data-usd="<?php echo $coin_price_usd; ?>"><?php echo get_the_title(); ?></option>
    			        
    			        <?php } ?>
    			    </select>
    			  </div>
	         </div>
	         
	         
	         <div class="col-md-4 currency-container">
	             <div class="form-group">
	               <label>3. Select Currency</label>
	               <?php 
	               $currencies = json_decode(file_get_contents('http://api.fixer.io/latest?base=USD')); 
	               $rates = $currencies->rates;
	               ?>
	               <select id="select-currency" class="form-control">
	                   <option data-code="USD" data-value="1"><?php echo $currencies->base; ?></option>
	                   <?php  foreach ($rates as $key => $rate) { ?>
	                        <option data-code="<?php echo $key; ?>" data-value="<?php echo $rate; ?>"><?php echo $key; ?></option>
	                   <?php } ?>
	                   
	                   
	               </select>
	               
	           </div>
	         </div>
	         
	        
	     </div>
         
         <div class="row row-results">
           
           
           <div class="col-md-6">
               <label id="selection-label-one">-</label>
               <p class="selection-details" id="selection-details-one"></p>
           </div>  
           
           <div id="col-md-6">
               <label id="selection-label-two">-</label>
               <p class="selection-details" id="selection-details-two"></p>
           </div>  
             
         </div>
    
</div>

<?php
$coins = json_decode(curl_download("http://api.coinmarketcap.com/v1/ticker/"));
function curl_download($url){
 
    // is cURL installed yet?
    if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }
 
    // OK cool - then let's create a new cURL resource handle
    $ch = curl_init();
 
    // Now set some options (most are optional)
 
    // Set URL to download
    curl_setopt($ch, CURLOPT_URL, $Url);
 
    // Set a referer
    curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/yay.htm");
 
    // User agent
    curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
 
    // Include header in result? (0 = yes, 1 = no)
    curl_setopt($ch, CURLOPT_HEADER, 0);
 
    // Should cURL return or print out the data? (true = return, false = print)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
    // Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
 
    // Download the given URL, and return output
    $output = curl_exec($ch);
 
    // Close the cURL resource, and free system resources
    curl_close($ch);
 
    return $output;
}
?>