document.getElementById("amountInput").addEventListener("input", function() {
    var amount = parseInt(this.value);
    if (!isNaN(amount) && amount >= 200) {
        document.getElementById("acceptButton").style.display = "block";
    } else {
        document.getElementById("acceptButton").style.display = "none";
    }
});

document.getElementById("acceptButton").addEventListener("click", function() {
    var amount = parseInt(document.getElementById("amountInput").value);

    if (isNaN(amount) || amount < 200) {
        alert("Please enter a valid amount of at least 200 KES.");
        return;
    }

    var pin = prompt("Please enter your M-Pesa PIN to confirm payment of KES " + amount + " to 0790729721");

    if (pin === null || pin.trim() === "") {
        alert("Payment cancelled or PIN not provided.");
        return;
    }

    // Send the amount and PIN to the server to handle the payment
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "payment.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert("Payment successful! Amount: KES " + amount);
            } else {
                alert("Payment failed: " + response.error);
            }
        }
    };
    xhr.send(JSON.stringify({ amount: amount, pin: pin }));
});
