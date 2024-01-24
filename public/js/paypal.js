

paypal.Buttons({
    // Sets up the transaction when a payment button is clicked
    createOrder: (data, actions) => {
       Http;
        return fetch('api/orders', {
            method: 'POST',
            
            body:JSON.stringify({
                'userId' : "{{auth()->user()->id}}",
            })
            
        }).then(function(res) {
            return res.json();
        }).then(function(orderData) {
            return orderData.id;
        });
    },
    // Finalize the transaction after payer approval
    onApprove: (data, actions) => {
        return fetch('/orders/${data.orderID}/capture' , {
            method: 'POST',
            body :JSON.stringify({
                orderId : data.orderID,
                userId: "{{ auth()->user()->id }}",
            })
        }).then(function(res) {
            return res.json();
        }).then(function(orderData) {
            $('#success').slideDown(200);
            $('.card-body').slideUp(0);
        });
    }
  }).render('#paypal-button-container');