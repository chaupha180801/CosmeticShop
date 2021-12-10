<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* body{
            font-family: Arial;
        }
        .coupon{
            border : 5px dotted #bbb;
            width: 80%;
            border-radius: 15px;
            margin : 0 auto;
            max-width: 600px;
        }
        .container{
            padding: 2px 16px;
            background-color: #f1f1f1;
        }
        .promo{
            background: #ccc;
            padding: 3px;
        }
        .expire{
            color:red;
        }

        p.code{
            text-align: center;
            font-size: 20px;
        }
        p.expire{
            text-align: center;
        }
        h2.note{
            text-align: center;
            font-size: larger;
            text-decoration: underline;
        } */

        .coupon {
            border: 5px dotted #bbb; /* Dotted border */
            width: 80%;
            border-radius: 15px; /* Rounded border */
            margin: 0 auto; /* Center the coupon */
            max-width: 600px;
        }

        .container {
            padding: 2px 16px;
            background-color: #f1f1f1;
        }

        .promo {
            background: #ccc;
            padding: 3px;
        }

        .expire {
            color: red;
        }
    </style>
</head>
<body>
 <!--   <div class="coupon">
       <div class="container">
           <h3>Mã khuyến mãi từ shop <a  target="_blank" href="http://localhost:8080/CosmeticShop/">http://localhost:8080/CosmeticShop</a></h3>
       </div>
       <div class="container" style="blackground-color:white">
            <h2 class="note">
                <b>
                    {{$discount['desc']}}.
                    Giảm {{$discount['percent']}}% cho tổng đơn hàng.
                 </b>
            </h2>
            <p>Quý khách đã mua hàng tại shop CosmeticShop. Nếu đã có tài khoản vui lòng đăng nhập để mua hàng và nhập mã code phía dưới để 
                được giảm giá, xin cảm ơn quý khách. Chúc quý khách có trải nghiệm mua hàng vui vẻ.
            </p>
       </div>
       <div class="container">
           <p class="code">Sử dụng code sau: <span class="promo">{{$discount['code']}}</span>chỉ còn {{$discount['quantity']}} mã giảm giá.</p>
           <p class="expire">Ngày bắt đầu: {{$discount['start_discount']}}/ Ngày hết hạn: {{$discount['end_discount']}}</p>
       </div>
   </div> -->
        <div class="coupon">
        <div class="container">
            <h3>CosmeticShop</h3>
        </div>
        <img src="{{'public/backEnd/images/my-pham-3.png'}}" alt="Avatar" style="width:100%;">
        <div class="container" style="background-color:white">
            <h2> 
                <b>
                    {{$discount['desc']}}.
                    Giảm {{$discount['percent']}}% cho tổng đơn hàng.
                 </b>
            </h2>
            <p>
                Quý khách đã mua hàng tại shop CosmeticShop. Nếu đã có tài khoản vui lòng đăng nhập để mua hàng và nhập mã code phía dưới để 
                được giảm giá, xin cảm ơn quý khách. Chúc quý khách có trải nghiệm mua hàng vui vẻ.
            </p>
        </div>
        <div class="container">
            <p>Use Promo Code: <span class="promo">{{$discount['code']}}</span>chỉ còn {{$discount['quantity']}} mã giảm giá.</p>
            <p class="expire">Ngày bắt đầu: {{$discount['start_discount']}}/ Ngày hết hạn: {{$discount['end_discount']}}</p>
        </div>
        </div>
</body>
</html>