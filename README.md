<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://www.evertecinc.com/wp-content/uploads/2020/07/logo-evertec.png" width="400"></a></p>



## About Technical Test

storeevertec.test is a web application of simple store:
Modify file ENV. Add next Line.

- APP_IP=Use your IP
- PLACETOPAY_LOGIN= your login
- PLACETOPAY_TRANKEY= your trankey
- PLACETOPAY_URL= your url


This system send email.
- MAIL_HOST= your host smtp
- MAIL_PORT= your port
- MAIL_USERNAME= your username
- MAIL_PASSWORD= your password
- MAIL_FROM_ADDRESS= your email address

Also for session
- SESSION_LIFETIME=525600
- TIME_ZONE= your time zone


## How does it work?


- It has a cart that works only in session which lasts 1 year.
- The customer selects their product and adds it to the cart.
- You can remove the product from the cart
- If you are ready you can checkout
- anonymous client name, surname, mobile and email
- If you are a registered customer, your data will appear, which you can update only for that purchase.
-If the email is valid, one will arrive with the data of your order.
- Next, a unique order code is generated to track it and you must also enter your shipping information such as your street, city, state and zip code.
- Next you must choose a shipping package.
- Next is the option to decide to make the payment, so you will be redirected to evertec's PlacetoPay.
- You must apply your payment with the test cards, the order remains as PAYED if the payment is made.


## Registered user

You have the option to view your placed orders.

## Administator

You can change the status to SENDED by capturing the data from the shipping record el tranking_number

Greetings and thank you very much for taking the time to read.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
