<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'ultimatePOS') }} | Customer Display</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <style>
        /* Define the animation */
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        /* Apply the animation to the <div> element */
        div.marquee {
            white-space: nowrap;
            /* Prevent text from wrapping */
            overflow: hidden;
            /* Hide the overflow text */
            animation: marquee 10s linear infinite;
            /* Use the marquee animation */
        }

        /* Additional styling */
        div.marquee p {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            padding: 10px;
        }
    </style>
</head>

<body>
    
    <div class="row">
        <h3 class="text-center">{{ config('app.name', 'ultimatePOS') }} | {{config('constants.app_title')}}</h3>
        <h3 class="text-center">Customer Display <span class="fs-6">v1.0.4</span></h3>
        {{-- #king Text marquee here for ads or text --}}
        <div class="marquee">
            <p>Thank you for shopping with us</p>
        </div>
    <div class="col-md-6 mt-2 mx-3 table-responsive"
        style="max-height: 400px; overflow: scroll; display: flex; flex-direction: column;">
        <table id="customerItemDisplay" class="table table-striped-columns">
            <thead style="position: sticky; top: 0; z-index: 1;" class="table-dark">
                <tr>
                    <th>No</th>
                    
                    <th>Product</th>
                    <th class="">Quantity</th>
                    <th class="text-right">Unit Price</th>
                </tr>
            </thead>
            <tbody >
                <!-- Items entered by the cashier will be displayed here -->
            </tbody>
            <tfoot style="position: sticky; bottom: 0;" class="table-dark">
                <tr>
                    <th id="total">Total: 0.00</th>
                    <th id="totalUnitPrice">Total Price: 0.00</th>
                    <th id="discount">discount: 0.00</th>
                    <th id="rpRedeemed">Points: 0.00</th>
                </tr>
            </tfoot>
        </table>
    </div>


<div class="col-md-5 mt-2 mx-3">
   {{--#king product of the week --}}
    <div   class="border border-secondary-subtle border-2 rounded col" style="height: 400px;     overflow: scroll;">
        <p class="card-header fs-3 text-center">Products of the week</p>
   <div id="featuredProducts" class="row">
    @if(empty($featured_products))
    <div class="text-center col-md-12">
        <p>Product of the week coming soon!</p>
    </div>
    @else
    {{-- card one --}}
    @foreach($featured_products as $feature)
    <div class="card text-center col-md-6 mb-3">
        <div class="card-header">
            {{$feature->product->name}}
        </div>
        <div class="card-body">
            <img src="{{$feature->product->image_url}}" class="card-img-top" alt="product img">
        </div>
        <div class="card-footer text-body-secondary">
            {{$feature->sell_price_inc_tax}}
        </div>
    </div>
    @endforeach
    @endif
      </div>
      {{-- #king product of the week ends here --}}
       </div>
    </div>
    </div>







    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></> --}}

    <script>
        
        // Initialize the displayed products array
    var displayArray = [];


    //#king Function to update the customer display  
function updateCustomerDisplay() {
var items = localStorage.getItem("selectedProducts");
    // Add a check to ensure items is not empty or undefined
    if (!items) {
      
    console.error('No items to display.');
    return;
    }

 items = JSON.parse(items);
var tableBody = document.querySelector("#customerItemDisplay tbody");
// Clear the existing table
tableBody.innerHTML = "";

displayArray = []; 
items.forEach(function (item) {
var existingDisplayItemIndex = displayArray.findIndex(function (displayItem) {
return displayItem.name === item.name && displayItem.sku === item.sku;
});



if (item.name !== undefined) {
if (existingDisplayItemIndex !== -1) {
// Update the unit price and quantity for existing items
displayArray[existingDisplayItemIndex].quantity = item.quantity;
displayArray[existingDisplayItemIndex].unitPrice = item.unitPrice;
} else {
// Add new items to the display array
displayArray.push({
name: item.name,
quantity: item.quantity,
unitPrice: item.unitPrice,
sku: item.sku,
variation: item.variation,
type: item.type,
code: item.code,
symbol: item.symbol,
symbolPlacement: item.symbolPlacement,
rewardPointEnabled: item.rewardPointEnabled,
totalDiscount: item.totalDiscount,
discountType: item.discountType,
discountAmount: item.discountAmount,
rpRedeemed: item.rpRedeemed,
rpRedeemedAmount: item.rpRedeemedAmount,
orderTax: item.orderTax,
taxRateId: item.taxRateId,
taxCalculationAmount: item.taxCalculationAmount,
shippingChargesAmount: item.shippingChargesAmount,
finalTotal: item.finalTotal,
brand: item.brand,
prodType: item.prodType,
unit: item.unit,
});
}
} else {
//#king If the name is undefined
// console.log('Item name is undefined:', item);
}
});

displayArray.forEach(function (displayItem, index) {
var row = tableBody.insertRow();
// Insert No.
var numberCell = row.insertCell(0);
numberCell.textContent = index + 1;

// Insert Product Name and SKU
var productCell = row.insertCell(1);
var productName = document.createElement('div');
productName.textContent = displayItem.name;

// Check if the type is variable before adding the variation
if (displayItem.prodType === 'variable' || displayItem.prodType === 'combo') {
productName.textContent += ' - ' + displayItem.type;
}

var productSku = document.createElement('div');
productSku.textContent = 'Code: ' + displayItem.sku;
var productUnit = document.createElement('div');
productUnit.textContent = 'Unit: ' + displayItem.unit;
var prodductBrand = document.createElement('div');
prodductBrand.textContent = 'Brand: ' + displayItem.brand;
productCell.appendChild(productName);
productCell.appendChild(productSku);
productCell.appendChild(productUnit);
productCell.appendChild(prodductBrand);



var quantityCell = row.insertCell(2);
quantityCell.textContent = displayItem.quantity;

var priceCell = row.insertCell(3);
priceCell.textContent = displayItem.unitPrice;




});

updateTotalUnitPrice();

}
   
    //#king Update the customer display initially and listen for changes
function updateQuantity(index, newQuantity) {
var selectedProducts = JSON.parse(localStorage.getItem("selectedProducts")) || [];
if (selectedProducts.length > index) {
selectedProducts[index].quantity = newQuantity;


selectedProducts[index].unitPrice = calculateNewUnitPrice(selectedProducts[index].unitPrice, newQuantity);

localStorage.setItem("selectedProducts", JSON.stringify(selectedProducts));
}
updateCustomerDisplay();
updateTotalUnitPrice();
}

// Function to calculate the new unit price based on quantity
function calculateNewUnitPrice(unitPrice, newQuantity) {
// Remove any non-numeric characters from the unit price
var numericPrice = parseFloat(unitPrice.replace(/[^\d.]/g, "").trim());
var newPrice = (numericPrice * newQuantity).toFixed(2);
return newPrice;
}


    
 //#king Function to periodically update the customer display
function periodicallyUpdateCustomerDisplay() {
setInterval(function () {
// Clear the display
var tableBody = document.querySelector("#customerItemDisplay tbody");
tableBody.innerHTML = "";

// Update the display with the latest data
updateCustomerDisplay();
updateTotalUnitPrice();

// Check if the tbody is empty
if (tableBody.childElementCount === 0) {
// If the tbody is empty, reset the totalUnitPrice
document.getElementById('totalUnitPrice').innerHTML = 'Total: 0:00';
document.getElementById('total').innerHTML = 'Paying: 0:00';
document.getElementById('discount').innerHTML = 'Discount: 0:00';
document.getElementById('rpRedeemed').innerHTML = 'Points: 0:00';
document.getElementById('shipping').innerHTML = 'Shipping: 0:00';
}
}, 2000); // 2 seconds
}

// Update the customer display initially and start periodic updates
updateCustomerDisplay();
periodicallyUpdateCustomerDisplay();
    
    // function to update selected products
    function updateSelectedProducts() {
        var selectedProducts = [];
    
        $("#pos_table tbody tr.product_row").each(function () {
            // Extract product information and create a productInfo object
            var name = $(this).find('td:eq(0)').text().trim();
            var quantity = parseFloat($(this).find('input[name^="products[1][quantity]"]').val());
            var unitPrice = $(this).find('td:eq(3)').text().trim();
    
            var productInfo = {
                name: name,
                quantity: quantity,
                unitPrice: unitPrice,
            };
    
            
            selectedProducts.push(productInfo);
        });
    
        // Store the selected products 
        localStorage.setItem('selectedProducts', JSON.stringify(selectedProducts));
  
        
        updateCustomerDisplay();
    }
    
    


    $("input[name^='products[1][quantity]']").on("change", function () {
        // Get the index 
        var index = $(this).closest('tr').index();
    
        // Get the new quantity value
        var newQuantity = parseFloat($(this).val());
    
        updateSelectedProducts();
        updateQuantity(index, newQuantity); 
    });


function calculateTotalUnitPrice(items) {
var total = 0;
items.forEach(function (item) {
//#king Remove any non-numeric characters from the unit price
var numericPrice = parseFloat(item.unitPrice.replace(/[^\d.]/g, "").trim());

total += numericPrice;

});

return total.toFixed(2);

}

function updateTotalUnitPrice() {


var totalUnitPrice = calculateTotalUnitPrice(displayArray);

//#king Get the most recent values for discount, points, and shipping
var recentDiscount = displayArray.length > 0 ? parseFloat(displayArray[displayArray.length - 1].discountAmount) : 0;
var recentPoints = displayArray.length > 0 ? parseFloat(displayArray[displayArray.length - 1].rpRedeemedAmount) : 0;
var recentShipping = displayArray.length > 0 ? parseFloat(displayArray[displayArray.length - 1].shippingChargesAmount) :
0;

totalUnitPrice = parseFloat(totalUnitPrice.replace(/[^\d.-]/g, ''));


// Deduct the most recent from the totalUnitPrice
var finalAmount = (totalUnitPrice - recentDiscount)- recentPoints;


//#king Update the innerHTML of each header based on symbolPlacement
var totalUnitHeader = document.getElementById('totalUnitPrice');
var totalHeader = document.getElementById('total');
var discountHeader = document.getElementById('discount');
var rpRedeemedHeader = document.getElementById('rpRedeemed');
var shippingHeader = document.getElementById('shipping');


if (displayArray.length > 0) {
    console.log('display array length',displayArray.length);
var lastItem = displayArray[displayArray.length - 1];
if (lastItem.symbolPlacement === 'before') {
totalUnitHeader.innerHTML = 'Total: ' + lastItem.symbol + ' ' + totalUnitPrice.toLocaleString();  

totalHeader.innerHTML = 'Paying: ' + lastItem.symbol + ' ' + finalAmount.toFixed(2);
discountHeader.innerHTML = 'Discount: ' + lastItem.symbol + ' ' + recentDiscount.toFixed(2);
rpRedeemedHeader.innerHTML = 'Points: ' + lastItem.symbol + ' ' + recentPoints.toFixed(2);
// shippingHeader.innerHTML = 'Shipping: ' + lastItem.symbol + ' ' + recentShipping.toFixed(2);
} else {
    totalUnitHeader.innerHTML = 'Total: ' + totalUnitPrice.toLocaleString() + ' ' + lastItem.symbol;
totalHeader.innerHTML = 'Paying: ' + finalAmount.toLocaleString() + ' ' + lastItem.symbol;
discountHeader.innerHTML = 'Discount: ' + recentDiscount.toLocaleString() + ' ' + lastItem.symbol;
rpRedeemedHeader.innerHTML = 'Points: ' + recentPoints.toLocaleString() + ' ' + lastItem.symbol;
// shippingHeader.innerHTML = 'Shipping: ' + recentShipping.toLocaleString() + ' ' + lastItem.symbol;
}
}

}

</script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
    // #king function to handle the featured products shuffle
    var div = document.getElementById('featuredProducts');
    function shuffleDiv(){
        var children =Array.from(div.children);
        for (var i = 0; i < children.length; i++){
            var j = Math.floor(Math.random() * children.length)

            var temp = children[i];
            children[i] = children[j];
            children[j] = temp; 
        }
        while (div.firstChild) {
            div.removeChild(div.firstChild);
        }

        for(var i = 0; i < children.length; i++){
            div.appendChild(children[i]);
        }
    }
    setInterval(shuffleDiv,10000);
</script>
</body>

</html>