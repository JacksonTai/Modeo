<?php
session_start();
require '../helper/setUserType.php';
include '../helper/autoloader.php';

$cartItem = new CartItemController();
$product = new ProductController();

// Http request through Ajax.
if (isset($_POST['action'])) {

     $checkoutInfo = $cartItem->getCheckoutInfo($userInfo['user_id']);

     // Add order information
     $order = new OrderController();
     $orderInfo = $order->addOrder(
          $userInfo['user_id'],
          $checkoutInfo['checkoutItems'],
          $checkoutInfo['totalPrice']
     );

     // Add billing information.
     $billing = new billingController();
     $billing->addBilling($orderInfo['orderId'], $_POST);

     // Remove users cart item.
     foreach ($checkoutInfo['checkoutItems'] as $checkoutItem) {
          $cartItem->deleteCartItem($checkoutItem['cart_item_id']);
     }

     // Update product stock.
     $product->updateProductStock($checkoutInfo['checkoutItems']);

     $_SESSION['payment'] = [
          'orderId' => $orderInfo['orderId'],
          'date' => $orderInfo['orderDate'],
          'time' => $orderInfo['orderTime'],
          'totalPrice' => $checkoutInfo['totalPrice']
     ];
     exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../templates/head.php' ?>
     <title>Checkout - Modeo</title>
</head>

<body>

     <?php include '../../templates/header.php' ?>

     <h2 class="checkout-title">Checkout</h2>

     <div class="checkout-wrapper">

          <main class="checkout-main">
               <section class="checkout-section checkout-section--summary">
                    <div class="checkout-section__header">
                         <div class="checkout-section__header-wrapper">
                              <img class="checkout-section__header-cart-icon" src="../../img/icons/cart.jpg" alt="Cart">
                              <span class="checkout-section__header-text">Show order summary</span>
                              <img class="checkout-section__up-triangle hide-triangle" src="../../img/icons/up.jpg">
                              <img class="checkout-section__down-triangle" src="../../img/icons/down.jpg">
                         </div>
                         <?php
                         $checkoutInfo = $cartItem->getCheckoutInfo($userInfo['user_id']);
                         $checkoutItems = $checkoutInfo['checkoutItems'];
                         ?>
                         <span class="checkout-section__header-total-price"><?php echo htmlspecialchars('RM' . $checkoutInfo['totalPrice']); ?></span>
                    </div>
                    <div class="checkout-section__body">
                         <table class="checkout-table">
                              <tbody>
                                   <?php foreach ($checkoutItems as $checkoutItem) : ?>
                                        <tr class="checkout-table__row">
                                             <td class="checkout-table__data checkout-table__data--img">
                                                  <img src="data:image/jpg;charset=utf8;base64,<?php echo htmlspecialchars($checkoutItem['image']); ?>" alt="<?php echo htmlspecialchars($checkoutItem['name']); ?>">
                                             </td>
                                             <td class="checkout-table__data checkout-table__data--content">
                                                  <span><?php echo htmlspecialchars($checkoutItem['name']); ?></span>
                                                  <span>Size: <?php echo htmlspecialchars($checkoutItem['size']); ?></span>
                                                  <span>Quantity: <?php echo htmlspecialchars($checkoutItem['quantity']); ?></span>
                                             </td>
                                             <td class="checkout-table__data checkout-table__data--total-price">
                                                  <?php echo htmlspecialchars('RM' . $checkoutItem['quantity'] * $checkoutItem['price']); ?>
                                             </td>
                                        </tr>
                                   <?php endforeach; ?>
                              </tbody>
                         </table>
                    </div>
               </section>
               <section class="checkout-section checkout-section--delivery">
                    <form class="checkout-form checkout-form--delivery" method="POST">
                         <div class="checkout-form__header">
                              <img class="checkout-section__title-icon" src="../../img/icons/box.svg">
                              <h3 class="checkout-section__title">
                                   Delivery Information
                              </h3>
                         </div>
                         <div class="checkout-form__item-wrapper checkout-form__item-wrapper--delivery">
                              <div class="checkout-form__item-container">
                                   <label class="checkout-delivery-form__label" for="firstName">First name:</label>
                                   <input class="checkout-delivery-form__input" type="text" name="firstName" id="firstName">
                                   <p class="checkout-error-msg invalid-rules-text"></p>

                              </div>
                              <div class="checkout-form__item-container">
                                   <label class="checkout-delivery-form__label" for="lastName">Last name:</label>
                                   <input class="checkout-delivery-form__input" type="text" name="lastName" id="lastName">
                                   <p class="checkout-error-msg invalid-rules-text"></p>
                              </div>
                         </div>
                         <div class="checkout-form__item-container">
                              <label class="checkout-delivery-form__label" for="phone">Phone:</label>
                              <input class="checkout-delivery-form__input" type="tel" name="phone" id="phone">
                              <p class="checkout-error-msg invalid-rules-text"></p>
                         </div>
                         <div class="checkout-form__item-container checkout-form__item-wrapper--delivery">
                              <label class="checkout-delivery-form__label" for="country">Country:</label>
                              <select class="checkout-delivery-form__input" id="country" name="country">
                                   <option disabled selected></option>
                                   <option value="Afganistan">Afghanistan</option>
                                   <option value="Albania">Albania</option>
                                   <option value="Algeria">Algeria</option>
                                   <option value="American Samoa">American Samoa</option>
                                   <option value="Andorra">Andorra</option>
                                   <option value="Angola">Angola</option>
                                   <option value="Anguilla">Anguilla</option>
                                   <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                   <option value="Argentina">Argentina</option>
                                   <option value="Armenia">Armenia</option>
                                   <option value="Aruba">Aruba</option>
                                   <option value="Australia">Australia</option>
                                   <option value="Austria">Austria</option>
                                   <option value="Azerbaijan">Azerbaijan</option>
                                   <option value="Bahamas">Bahamas</option>
                                   <option value="Bahrain">Bahrain</option>
                                   <option value="Bangladesh">Bangladesh</option>
                                   <option value="Barbados">Barbados</option>
                                   <option value="Belarus">Belarus</option>
                                   <option value="Belgium">Belgium</option>
                                   <option value="Belize">Belize</option>
                                   <option value="Benin">Benin</option>
                                   <option value="Bermuda">Bermuda</option>
                                   <option value="Bhutan">Bhutan</option>
                                   <option value="Bolivia">Bolivia</option>
                                   <option value="Bonaire">Bonaire</option>
                                   <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                   <option value="Botswana">Botswana</option>
                                   <option value="Brazil">Brazil</option>
                                   <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                   <option value="Brunei">Brunei</option>
                                   <option value="Bulgaria">Bulgaria</option>
                                   <option value="Burkina Faso">Burkina Faso</option>
                                   <option value="Burundi">Burundi</option>
                                   <option value="Cambodia">Cambodia</option>
                                   <option value="Cameroon">Cameroon</option>
                                   <option value="Canada">Canada</option>
                                   <option value="Canary Islands">Canary Islands</option>
                                   <option value="Cape Verde">Cape Verde</option>
                                   <option value="Cayman Islands">Cayman Islands</option>
                                   <option value="Central African Republic">Central African Republic</option>
                                   <option value="Chad">Chad</option>
                                   <option value="Channel Islands">Channel Islands</option>
                                   <option value="Chile">Chile</option>
                                   <option value="China">China</option>
                                   <option value="Christmas Island">Christmas Island</option>
                                   <option value="Cocos Island">Cocos Island</option>
                                   <option value="Colombia">Colombia</option>
                                   <option value="Comoros">Comoros</option>
                                   <option value="Congo">Congo</option>
                                   <option value="Cook Islands">Cook Islands</option>
                                   <option value="Costa Rica">Costa Rica</option>
                                   <option value="Cote DIvoire">Cote DIvoire</option>
                                   <option value="Croatia">Croatia</option>
                                   <option value="Cuba">Cuba</option>
                                   <option value="Curaco">Curacao</option>
                                   <option value="Cyprus">Cyprus</option>
                                   <option value="Czech Republic">Czech Republic</option>
                                   <option value="Denmark">Denmark</option>
                                   <option value="Djibouti">Djibouti</option>
                                   <option value="Dominica">Dominica</option>
                                   <option value="Dominican Republic">Dominican Republic</option>
                                   <option value="East Timor">East Timor</option>
                                   <option value="Ecuador">Ecuador</option>
                                   <option value="Egypt">Egypt</option>
                                   <option value="El Salvador">El Salvador</option>
                                   <option value="Equatorial Guinea">Equatorial Guinea</option>
                                   <option value="Eritrea">Eritrea</option>
                                   <option value="Estonia">Estonia</option>
                                   <option value="Ethiopia">Ethiopia</option>
                                   <option value="Falkland Islands">Falkland Islands</option>
                                   <option value="Faroe Islands">Faroe Islands</option>
                                   <option value="Fiji">Fiji</option>
                                   <option value="Finland">Finland</option>
                                   <option value="France">France</option>
                                   <option value="French Guiana">French Guiana</option>
                                   <option value="French Polynesia">French Polynesia</option>
                                   <option value="French Southern Ter">French Southern Ter</option>
                                   <option value="Gabon">Gabon</option>
                                   <option value="Gambia">Gambia</option>
                                   <option value="Georgia">Georgia</option>
                                   <option value="Germany">Germany</option>
                                   <option value="Ghana">Ghana</option>
                                   <option value="Gibraltar">Gibraltar</option>
                                   <option value="Great Britain">Great Britain</option>
                                   <option value="Greece">Greece</option>
                                   <option value="Greenland">Greenland</option>
                                   <option value="Grenada">Grenada</option>
                                   <option value="Guadeloupe">Guadeloupe</option>
                                   <option value="Guam">Guam</option>
                                   <option value="Guatemala">Guatemala</option>
                                   <option value="Guinea">Guinea</option>
                                   <option value="Guyana">Guyana</option>
                                   <option value="Haiti">Haiti</option>
                                   <option value="Hawaii">Hawaii</option>
                                   <option value="Honduras">Honduras</option>
                                   <option value="Hong Kong">Hong Kong</option>
                                   <option value="Hungary">Hungary</option>
                                   <option value="Iceland">Iceland</option>
                                   <option value="Indonesia">Indonesia</option>
                                   <option value="India">India</option>
                                   <option value="Iran">Iran</option>
                                   <option value="Iraq">Iraq</option>
                                   <option value="Ireland">Ireland</option>
                                   <option value="Isle of Man">Isle of Man</option>
                                   <option value="Israel">Israel</option>
                                   <option value="Italy">Italy</option>
                                   <option value="Jamaica">Jamaica</option>
                                   <option value="Japan">Japan</option>
                                   <option value="Jordan">Jordan</option>
                                   <option value="Kazakhstan">Kazakhstan</option>
                                   <option value="Kenya">Kenya</option>
                                   <option value="Kiribati">Kiribati</option>
                                   <option value="Korea North">Korea North</option>
                                   <option value="Korea Sout">Korea South</option>
                                   <option value="Kuwait">Kuwait</option>
                                   <option value="Kyrgyzstan">Kyrgyzstan</option>
                                   <option value="Laos">Laos</option>
                                   <option value="Latvia">Latvia</option>
                                   <option value="Lebanon">Lebanon</option>
                                   <option value="Lesotho">Lesotho</option>
                                   <option value="Liberia">Liberia</option>
                                   <option value="Libya">Libya</option>
                                   <option value="Liechtenstein">Liechtenstein</option>
                                   <option value="Lithuania">Lithuania</option>
                                   <option value="Luxembourg">Luxembourg</option>
                                   <option value="Macau">Macau</option>
                                   <option value="Macedonia">Macedonia</option>
                                   <option value="Madagascar">Madagascar</option>
                                   <option value="Malaysia">Malaysia</option>
                                   <option value="Malawi">Malawi</option>
                                   <option value="Maldives">Maldives</option>
                                   <option value="Mali">Mali</option>
                                   <option value="Malta">Malta</option>
                                   <option value="Marshall Islands">Marshall Islands</option>
                                   <option value="Martinique">Martinique</option>
                                   <option value="Mauritania">Mauritania</option>
                                   <option value="Mauritius">Mauritius</option>
                                   <option value="Mayotte">Mayotte</option>
                                   <option value="Mexico">Mexico</option>
                                   <option value="Midway Islands">Midway Islands</option>
                                   <option value="Moldova">Moldova</option>
                                   <option value="Monaco">Monaco</option>
                                   <option value="Mongolia">Mongolia</option>
                                   <option value="Montserrat">Montserrat</option>
                                   <option value="Morocco">Morocco</option>
                                   <option value="Mozambique">Mozambique</option>
                                   <option value="Myanmar">Myanmar</option>
                                   <option value="Nambia">Nambia</option>
                                   <option value="Nauru">Nauru</option>
                                   <option value="Nepal">Nepal</option>
                                   <option value="Netherland Antilles">Netherland Antilles</option>
                                   <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                   <option value="Nevis">Nevis</option>
                                   <option value="New Caledonia">New Caledonia</option>
                                   <option value="New Zealand">New Zealand</option>
                                   <option value="Nicaragua">Nicaragua</option>
                                   <option value="Niger">Niger</option>
                                   <option value="Nigeria">Nigeria</option>
                                   <option value="Niue">Niue</option>
                                   <option value="Norfolk Island">Norfolk Island</option>
                                   <option value="Norway">Norway</option>
                                   <option value="Oman">Oman</option>
                                   <option value="Pakistan">Pakistan</option>
                                   <option value="Palau Island">Palau Island</option>
                                   <option value="Palestine">Palestine</option>
                                   <option value="Panama">Panama</option>
                                   <option value="Papua New Guinea">Papua New Guinea</option>
                                   <option value="Paraguay">Paraguay</option>
                                   <option value="Peru">Peru</option>
                                   <option value="Phillipines">Philippines</option>
                                   <option value="Pitcairn Island">Pitcairn Island</option>
                                   <option value="Poland">Poland</option>
                                   <option value="Portugal">Portugal</option>
                                   <option value="Puerto Rico">Puerto Rico</option>
                                   <option value="Qatar">Qatar</option>
                                   <option value="Republic of Montenegro">Republic of Montenegro</option>
                                   <option value="Republic of Serbia">Republic of Serbia</option>
                                   <option value="Reunion">Reunion</option>
                                   <option value="Romania">Romania</option>
                                   <option value="Russia">Russia</option>
                                   <option value="Rwanda">Rwanda</option>
                                   <option value="St Barthelemy">St Barthelemy</option>
                                   <option value="St Eustatius">St Eustatius</option>
                                   <option value="St Helena">St Helena</option>
                                   <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                   <option value="St Lucia">St Lucia</option>
                                   <option value="St Maarten">St Maarten</option>
                                   <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                   <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                   <option value="Saipan">Saipan</option>
                                   <option value="Samoa">Samoa</option>
                                   <option value="Samoa American">Samoa American</option>
                                   <option value="San Marino">San Marino</option>
                                   <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                   <option value="Saudi Arabia">Saudi Arabia</option>
                                   <option value="Senegal">Senegal</option>
                                   <option value="Seychelles">Seychelles</option>
                                   <option value="Sierra Leone">Sierra Leone</option>
                                   <option value="Singapore">Singapore</option>
                                   <option value="Slovakia">Slovakia</option>
                                   <option value="Slovenia">Slovenia</option>
                                   <option value="Solomon Islands">Solomon Islands</option>
                                   <option value="Somalia">Somalia</option>
                                   <option value="South Africa">South Africa</option>
                                   <option value="Spain">Spain</option>
                                   <option value="Sri Lanka">Sri Lanka</option>
                                   <option value="Sudan">Sudan</option>
                                   <option value="Suriname">Suriname</option>
                                   <option value="Swaziland">Swaziland</option>
                                   <option value="Sweden">Sweden</option>
                                   <option value="Switzerland">Switzerland</option>
                                   <option value="Syria">Syria</option>
                                   <option value="Tahiti">Tahiti</option>
                                   <option value="Taiwan">Taiwan</option>
                                   <option value="Tajikistan">Tajikistan</option>
                                   <option value="Tanzania">Tanzania</option>
                                   <option value="Thailand">Thailand</option>
                                   <option value="Togo">Togo</option>
                                   <option value="Tokelau">Tokelau</option>
                                   <option value="Tonga">Tonga</option>
                                   <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                   <option value="Tunisia">Tunisia</option>
                                   <option value="Turkey">Turkey</option>
                                   <option value="Turkmenistan">Turkmenistan</option>
                                   <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                   <option value="Tuvalu">Tuvalu</option>
                                   <option value="Uganda">Uganda</option>
                                   <option value="United Kingdom">United Kingdom</option>
                                   <option value="Ukraine">Ukraine</option>
                                   <option value="United Arab Erimates">United Arab Emirates</option>
                                   <option value="United States of America">United States of America</option>
                                   <option value="Uraguay">Uruguay</option>
                                   <option value="Uzbekistan">Uzbekistan</option>
                                   <option value="Vanuatu">Vanuatu</option>
                                   <option value="Vatican City State">Vatican City State</option>
                                   <option value="Venezuela">Venezuela</option>
                                   <option value="Vietnam">Vietnam</option>
                                   <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                   <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                   <option value="Wake Island">Wake Island</option>
                                   <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                   <option value="Yemen">Yemen</option>
                                   <option value="Zaire">Zaire</option>
                                   <option value="Zambia">Zambia</option>
                                   <option value="Zimbabwe">Zimbabwe</option>
                              </select>
                              <p class="checkout-error-msg invalid-rules-text"></p>
                         </div>
                         <div class="checkout-form__item-container">
                              <label class="checkout-delivery-form__label" for="address">Address:</label>
                              <input class="checkout-delivery-form__input" type="text" name="address" id="address">
                              <p class="checkout-error-msg invalid-rules-text"></p>
                         </div>
                         <div class="checkout-form__item-wrapper checkout-form__item-wrapper--delivery">
                              <div class="checkout-form__item-container">
                                   <label class="checkout-delivery-form__label" for="state">State:</label>
                                   <input class="checkout-delivery-form__input" type="text" name="state" id="state">
                                   <p class="checkout-error-msg invalid-rules-text"></p>
                              </div>
                              <div class="checkout-form__item-container">
                                   <label class="checkout-delivery-form__label" for="city">City:</label>
                                   <input class="checkout-delivery-form__input" type="text" name="city" id="city">
                                   <p class="checkout-error-msg invalid-rules-text"></p>
                              </div>
                              <div class="checkout-form__item-container">
                                   <label class="checkout-delivery-form__label" for="zipCode">Zip Code:</label>
                                   <input class="checkout-delivery-form__input" type="text" name="zipCode" id="zipCode" maxlength="5">
                                   <p class="checkout-error-msg invalid-rules-text"></p>
                              </div>
                         </div>
                    </form>
               </section>
               <section class="checkout-section checkout-section--payment">
                    <form class="checkout-form checkout-form--payment" method="POST">
                         <div class="checkout-form__header">
                              <img class="checkout-section__title-icon" src="../../img/icons/paymentCard.svg">
                              <h3 class="checkout-section__title checkout-section__title--payment">
                                   Payment Information
                                   <span>All transactions are secured and encrypted.</span>
                              </h3>
                         </div>
                         <div class="checkout-form__item-container">
                              <label class="checkout-payment-form__label" for="cardHolder">Card Holder:</label>
                              <input class="checkout-payment-form__input" type="text" name="cardHolder" id="cardHolder">
                              <p class="checkout-error-msg invalid-rules-text"></p>
                         </div>
                         <div class="checkout-form__item-container">
                              <label class="checkout-payment-form__label" for="cardNumber">Card Number:</label>
                              <input class="checkout-payment-form__input" type="text" name="cardNumber" id="cardNumber" maxlength="16">
                              <p class="checkout-error-msg invalid-rules-text"></p>
                         </div>
                         <div class="checkout-form__item-wrapper checkout-form__item-wrapper--payment">
                              <div class="checkout-form__item-container">
                                   <label class="checkout-payment-form__label" for="expirationDate">Expiration Date:</label>
                                   <input class="checkout-payment-form__input" type="text" name="expirationDate" id="expirationDate" placeholder="MM/YY">
                                   <p class="checkout-error-msg invalid-rules-text"></p>
                              </div>
                              <div class="checkout-form__item-container">
                                   <label class="checkout-payment-form__label" for="securityCode">Security Code:</label>
                                   <input class="checkout-payment-form__input" type="text" name="securityCode" id="securityCode" placeholder="CVV">
                                   <p class="checkout-error-msg invalid-rules-text"></p>
                              </div>
                         </div>
                         <button class="btn pay-now-btn" type="submit">Pay now</button>
                    </form>
               </section>
          </main>

          <aside class="checkout-aside">
               <table class="checkout-table">
                    <tbody>
                         <?php foreach ($checkoutItems as $checkoutItem) : ?>
                              <tr class="checkout-table__row">
                                   <td class="checkout-table__data checkout-table__data--img">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo htmlspecialchars($checkoutItem['image']); ?>" alt="<?php echo htmlspecialchars($checkoutItem['name']); ?>">
                                   </td>
                                   <td class="checkout-table__data checkout-table__data--content">
                                        <span><?php echo htmlspecialchars($checkoutItem['name']); ?></span>
                                        <span>Size: <?php echo htmlspecialchars($checkoutItem['size']); ?></span>
                                        <span>Quantity: <?php echo htmlspecialchars($checkoutItem['quantity']); ?></span>
                                   </td>
                                   <td class="checkout-table__data checkout-table__data--total-price">
                                        <?php echo htmlspecialchars('RM' . $checkoutItem['quantity'] * $checkoutItem['price']); ?>
                                   </td>
                              </tr>
                         <?php endforeach; ?>
                         <tr class="checkout-table__row">
                              <td class="checkout-section__aside-total-price-label" colspan="2">
                                   Total:
                              </td>
                              <td class="checkout-section__aside-total-price" colspan="1">
                                   <?php echo htmlspecialchars('RM' . $checkoutInfo['totalPrice']); ?>
                              </td>
                         </tr>
                    </tbody>
               </table>
          </aside>
     </div>

     <?php include '../../templates/footer.php' ?>
     <script src="../../js/script.js"></script>
     <script src="../../js/checkout.js"></script>
</body>

</html>