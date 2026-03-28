<?php
session_start();

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">

<h2>Upgrade Your Account</h2>

<p>
Unlock the full SokoPrep CBT question bank and practice like the real exam.
</p>

<div class="upgrade-box">

<h3>Full Access Package</h3>

<p>
✔ Access all exam questions<br>
✔ Unlimited practice tests<br>
✔ Full exam simulation
</p>

<h2>₦2000</h2>

<button class="btn-primary" onclick="payWithPaystack()">Pay Now</button>

</div>

<br>

<a class="btn-secondary" href="dashboard.php">Back to Dashboard</a>
<script src="https://js.paystack.co/v1/inline.js"></script>

<script>
function payWithPaystack(){

var handler = PaystackPop.setup({

key: 'pk_live_3f109a0b046f44eb4944558c916b3be63e0e25f3',

email: "test@sokoprep.com",

amount: 200000,

currency: "NGN",

callback: function(response){
    window.location = "verify_payment.php?reference=" + response.reference;
},

onClose: function(){
    alert('Payment window closed.');
}

});

handler.openIframe();
}
</script>
</div>