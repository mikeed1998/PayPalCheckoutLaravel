<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @php
        $itemNumber = "DP12345"; 
        $itemName = "Demo Product"; 
        $itemPrice = 10.00;  
    @endphp

    {{-- <script src="https://www.paypal.com/sdk/js?client-id=AZ-lUbJ4dvAetw7nHyFqNsvcmScm-mMikDT2DN5SXZ6oCtC5cXcGecgzVZP1citleZL0HRsox2bmGBqq&currency=MXN"></script> --}}
    <script src="https://www.paypal.com/sdk/js?client-id=AZLJzCzJ5BF6tbrLH-Gn5HsLY5YF12M8hAToi8FY3NbVyGnFfnL5T6Rdu9tHqv0OG33BCybIUpNVvcm1&currency=MXN"></script>

    <div class="panel">
        <div class="overlay hidden"><div class="overlay-content"><img src="css/loading.gif" alt="Processing..."/></div></div>

        <div class="panel-heading">
            <h3 class="panel-title">Charge {{ $itemPrice }} with PayPal</h3>
            
            <!-- Product Info -->
            <p><b>Item Name:</b>Producto 1</p>
            <p><b>Price:</b>${{ $itemPrice }} MXN</p>
        </div>
        <div class="panel-body">
            <!-- Display status message -->
            <div id="paymentResponse" class="hidden"></div>
            
            <!-- Set up a container element for the button -->
            <div id="paypal-button-container"></div>
        </div>
    </div>

    <script>
    paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
            return actions.order.create({
                "purchase_units": [{
                    "custom_id": "{{ $itemNumber }}",
                    "description": "{{ $itemName }}",
                    "amount": {
                        "currency_code": "MXN",
                        "value": <?php echo $itemPrice; ?>,
                        "breakdown": {
                            "item_total": {
                                "currency_code": "MXN",
                                "value": <?php echo $itemPrice; ?>
                            }
                        }
                    },
                    "items": [
                        {
                            "name": "{{ $itemName }}",
                            "description": "{{ $itemName }}",
                            "unit_amount": {
                                "currency_code": "MXN",
                                "value": <?php echo $itemPrice; ?>
                            },
                            "quantity": "1",
                            "category": "DIGITAL_GOODS"
                        },
                    ]
                }]
            });
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
            return actions.order.capture().then(function(orderData) {
                setProcessing(true);

                console.log(orderData);

                var postData = {paypal_order_check: 1, order_id: orderData.id};
                fetch('{{ route("checkout") }}', {
                    method: 'POST',
                    headers: {'Accept': 'application/json'},
                    body: encodeFormData(postData)
                })
                .then((response) => response.json())
                .then((result) => {
                    if(result.status == 1){
                        // window.location.href = "payment-status.php?checkout_ref_id="+result.ref_id;
                        alert('Pago exitoso');
                    }else{
                        const messageContainer = document.querySelector("#paymentResponse");
                        messageContainer.classList.remove("hidden");
                        messageContainer.textContent = result.msg;
                        
                        setTimeout(function () {
                            messageContainer.classList.add("hidden");
                            messageText.textContent = "";
                        }, 5000);
                    }
                    setProcessing(false);
                })
                .catch(error => console.log(error));
            });
        }
    }).render('#paypal-button-container');

    const encodeFormData = (data) => {
    var form_data = new FormData();

    for ( var key in data ) {
        form_data.append(key, data[key]);
    }
    return form_data;   
    }

    // Show a loader on payment form processing
    const setProcessing = (isProcessing) => {
        if (isProcessing) {
            document.querySelector(".overlay").classList.remove("hidden");
        } else {
            document.querySelector(".overlay").classList.add("hidden");
        }
    }    
    </script>
</body>
</html>