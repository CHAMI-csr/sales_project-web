function paymentGateway() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = () => {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      var paymentObject = JSON.parse(xhttp.responseText);
      console.log(paymentObject);



payhere.onCompleted = function onCompleted(orderId) {
    console.log("Payment completed. OrderID:" + orderId);


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            console.log("Database update response: " + xhttp.responseText);
            if (xhttp.responseText.trim() === "success") {
                alert("Payment successful! Your order has been placed.");
                window.location.href = "success.php"; 
            } else {
                alert("Payment was successful, but there was an error updating your order.");
            }
        }
    };
 
    xhttp.open("POST", "updateDatabase.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("orderId=" + orderId);
};

      payhere.onDismissed = function onDismissed() {
        console.log("Payment dismissed");
      };


      payhere.onError = function onError(error) {
        
        console.log("Error:" + error);
      };

      
      var payment = {
        sandbox: true,
        merchant_id: paymentObject["merchant_id"], 
        return_url: "http://localhost/PayHere/", 
        cancel_url: "http://localhost/PayHere/", 
        notify_url: "http://sample.com/notify",
        order_id: paymentObject["order_id"],
        items: paymentObject["item"],
        amount: paymentObject["amount"],
        currency: paymentObject["currency"],
        hash: paymentObject["hash"], 
        first_name: "Saman",
        last_name: "Perera",
        email: "samanp@gmail.com",
        phone: "0771234567",
        address: "No.1, Galle Road",
        city: "Colombo",
        country: "Sri Lanka",
        delivery_address: "No. 46, Galle road, Kalutara South",
        delivery_city: "Kalutara",
        delivery_country: "Sri Lanka",
        custom_1: "",
        custom_2: "",
      };

      payhere.startPayment(payment);
    }
  };

  xhttp.open("GET", "paymentProcess.php", true);
  xhttp.send();
}
