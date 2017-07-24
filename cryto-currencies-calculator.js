jQuery(document).ready(function(){
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
        
        
        selectionDetailsTwo.html(amountValue + ' ' + currencySymbol + ' = ' + totalConversionTwo.toFixed(6) + ' ' + coinTitle + ' (' + coinSymbol + ')' );
        
        selectionLabelOne.html(coinSymbol + ' to ' + currencySymbol);
        selectionLabeltwo.html(currencySymbol + ' to ' + coinSymbol);
        
    }
    
    function numberWithCommas(x) {
         return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    } 
});