<style>
	section.section.section-calculator {
        padding: 15px 0px 30px;
    }
	.calculator-container {
        margin: 0px;
        background: #2c3e50;
        padding: 20px 0px;
        color: white;
    }
    .calculator-container h2 {
        font-size: 1.6em;
        text-transform: uppercase;
        font-weight: bolder;
        margin-bottom: 5px;
        text-align: center;
    }
    .row-options .option .form-group {
        padding: 0px 20px;
    }
    .row-options .option select, .row-options .option input {
        width: 100%;
        font-size: 14px;
        padding: 5px;
    }
    .row-options .option {
        width: 33.3%;
        float: left;
    }
    .row-results p {
        font-size: 17px;
    }
    .row-results label {
        text-decoration: underline;
        font-weight: bolder;
        margin-bottom: 3px;
        display: inline-block;
        margin-top: 10px;
    }
    .row-results .option {
        width: 50%;
        float: left;
    }
    .row-results {
        text-align: center;
        width: 70%;
        margin: 0 auto;
    }
    @media screen and (max-width:970px){
       .calculator-container {
            padding: 15px;
            margin: 15px;
        }
        .row-results {
            width: 100%;
        }
        
    }
    @media screen and (max-width:420px){
        .row-options label {
            margin-bottom: 10px;
        }
        .row-options .option {
            width: 100%;
            float: none;
            margin-bottom: 15px;
        }
        .row-results .option {
            width: 100%;
            float: none;
            margin-bottom: 10px;
        }
        .row-options .option input {
            width: 95%;
        }
        .row-options .option .form-group {
            padding: 0px 15px;
        }
    }
	</style>


<div class="calculator-container">

        <div class="row-options">
        
            <div class="option">
                
                <div class="form-group">
                    <label>1. Enter the amount to convert</label>
                    <input onfocus="if(this.value == '0') { this.value = ''; }" type="number" id="amount" value="0" min="0" class="form-control"/>
                </div>
                
            </div>
            
            
             <div class="option crytocurrency-container">
                  <div class="form-group">
                    <label>2. Select Cryptocurrency</label>
                    <select id="select-cryptocurrency" class="form-control">
                        <?php
                        $coins = json_decode(file_get_contents('https://api.coinmarketcap.com/v1/ticker/'));
                        foreach ($coins as $coin){ 
                            
                            $rate =  $coin->price_usd;
                            
                            
                            if($coin->name == 'Bitcoin'){
                                $data = json_decode(file_get_contents('https://api.coindesk.com/v1/bpi/currentprice/BTC.json'));
                                $rate = number_format($data->bpi->USD->rate_float,2, '.', '');
                            }
                      
                        ?>
                        <option data-symbol="<?php echo $coin->symbol; ?>" <?php echo ($coin->name == 'Bitcoin') ? 'selected' : ''; ?> data-usd="<?php echo $rate; ?>"><?php echo $coin->name; ?></option>
                       
                        <?php  } ?>
                        
                    </select>
                  </div>
             </div>
             
             
             <div class="option currency-container">
                 <div class="form-group">
                   <label>3. Select Currency</label>
                   <?php 
                   $currencies = json_decode(file_get_contents('http://api.fixer.io/latest?base=USD')); 
                   $rates = $currencies->rates;
                   ?>
                   <select id="select-currency" class="form-control">
                       <option data-code="USD" data-value="1"><?php echo $currencies->base; ?></option>
                       <?php  foreach ($rates as $key => $rate) { ?>
                            <option value="<?php echo $key; ?>" data-code="<?php echo $key; ?>" data-value="<?php echo $rate; ?>"><?php echo $key; ?></option>
                       <?php } ?>
                       
                       
                   </select>
                   
               </div>
             </div>
         </div>
         <div class="clear"></div>
         
         <div class="row-results">
           
           
           <div class="option">
               <label id="selection-label-one">-</label>
               <p class="selection-details" id="selection-details-one"></p>
           </div>  
           
           <div id="option">
               <label id="selection-label-two">-</label>
               <p class="selection-details" id="selection-details-two"></p>
           </div>  
           
             
         </div>
    <div class="clear"></div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
// crytocurrencty converter 
    var selectCryptocurrency= $('#select-cryptocurrency');
    var selectCurrency= $('#select-currency');
    var amount = $('#amount');
    var result = $('#result');
    var amountValue  = 0;
    var priceValue = -1;
    var coinSymbol = '';
    var coinTitle = '';
    
    var selectionDetails = $('#selection-details-one');
    var selectionDetailsTwo = $('#selection-details-two');
    var selectionLabelOne = $('#selection-label-one');
    var selectionLabeltwo = $('#selection-label-two');
    
    var currencySymbol = 'USD';
    var currencyValue = 0;
    var totalConversionOne = 0;
    var totalConversionTwo = 0;
    
    $('.crytocurrency-container').appendTo($('.row-options'));
    
    convert();
    
    amount.bind('keyup mouseup', function(){
        convert();
    });
    
    selectCryptocurrency.change(function(){
        convert();
    });
    
    selectCurrency.change(function(){
        convert();
    });
    
    function convert(){
        
        amountValue = amount.val();
        
        coinSymbol = selectCryptocurrency.find('option:selected').attr('data-symbol');
        priceValue = selectCryptocurrency.find('option:selected').attr('data-usd');
        coinTitle = selectCryptocurrency.find('option:selected').val();
        
        currencySymbol = selectCurrency.find('option:selected').attr('data-code');
        currencyValue = selectCurrency.find('option:selected').attr('data-value');
        
        
        totalConversionOne = ((parseFloat(amountValue) * parseFloat(priceValue)) * parseFloat(currencyValue));
        totalConversionTwo = ( parseFloat(amountValue) / parseFloat(currencyValue) / parseFloat(priceValue) );
        
        selectionDetails.html(amountValue + ' ' + coinTitle + ' (' + coinSymbol + ') = ' + totalConversionOne.toFixed(6) + ' ' + currencySymbol );
        
        
        selectionDetailsTwo.html(amountValue + ' ' + currencySymbol + ' = ' + totalConversionTwo + ' ' + coinTitle + ' (' + coinSymbol + ')' );
        
        selectionLabelOne.html(coinSymbol + ' to ' + currencySymbol);
        selectionLabeltwo.html(currencySymbol + ' to ' + coinSymbol);
        
    }
    
    function numberWithCommas(x) {
         return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

</div>
