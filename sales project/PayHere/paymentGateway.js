function paymentGateway() {
  const checkoutBtn = document.getElementById("checkoutButton");
  if (checkoutBtn) {
    checkoutBtn.disabled = true;
    checkoutBtn.innerText = "Connecting to PayHere...";
  }

  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (xhttp.readyState === 4) {
      if (checkoutBtn) {
        checkoutBtn.disabled = false;
        checkoutBtn.innerHTML = `
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          Pay with PayHere
        `;
      }

      if (xhttp.status === 200) {
        let paymentObject;
        try {
          paymentObject = JSON.parse(xhttp.responseText);
        } catch (e) {
          console.error("Failed to parse PayHere response:", xhttp.responseText);
          alert("Error preparing payment. Server response: " + xhttp.responseText);
          return;
        }

        console.log("PayHere Payment Object:", paymentObject);

        payhere.onCompleted = function onCompleted(orderId) {
          console.log("Payment completed. OrderID: " + orderId);

          const updateHttp = new XMLHttpRequest();
          updateHttp.onreadystatechange = function () {
            if (updateHttp.readyState === 4 && updateHttp.status === 200) {
              console.log("Database update response:", updateHttp.responseText);
              if (updateHttp.responseText.trim() === "success") {
                window.location.href = "success.php";
              } else {
                alert("Payment was successful, but there was an error updating your order: " + updateHttp.responseText);
              }
            }
          };

          updateHttp.open("POST", "updateDatabase.php", true);
          updateHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          updateHttp.send("orderId=" + encodeURIComponent(orderId));
        };

        payhere.onDismissed = function onDismissed() {
          console.log("PayHere payment modal dismissed by user.");
        };

        payhere.onError = function onError(error) {
          console.error("PayHere Error:", error);
          alert("PayHere Sandbox Error: " + error + "\n\nPlease check your Merchant ID and Merchant Secret in PayHere/paymentProcess.php");
        };

        const currentUrl = window.location.href.split('?')[0];
        const basePath = currentUrl.substring(0, currentUrl.lastIndexOf('/') + 1);

        const payment = {
          sandbox: true,
          merchant_id: paymentObject.merchant_id,
          return_url: basePath + "success.php",
          cancel_url: currentUrl,
          notify_url: "https://sample.com/notify",
          order_id: paymentObject.order_id,
          items: paymentObject.items || paymentObject.item,
          amount: paymentObject.amount,
          currency: paymentObject.currency,
          hash: paymentObject.hash,
          first_name: paymentObject.first_name || "Customer",
          last_name: "User",
          email: paymentObject.email || "customer@techub.com",
          phone: "0771234567",
          address: "123 Main Street",
          city: "Galle",
          country: "Sri Lanka",
          delivery_address: "123 Main Street, Wilpattuwa",
          delivery_city: "Galle",
          delivery_country: "Sri Lanka",
        };

        payhere.startPayment(payment);
      } else {
        alert("Failed to contact paymentProcess.php. Status code: " + xhttp.status);
      }
    }
  };

  xhttp.open("GET", "paymentProcess.php", true);
  xhttp.send();
}
