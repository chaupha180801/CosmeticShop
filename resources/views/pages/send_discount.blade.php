<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .wrap {
            width: 500px;
            background: rgb(235, 235, 235);
            padding: 0 20px 20px 20px;
            font-family: sans-serif;
        }

        .mail_header {
            padding: 10px;
            border-bottom: 1px solid rgb(231, 231, 231);
        }

        .mail_header h2 {
            text-align: center;
            margin: 10px 0;
            color: rgb(214, 18, 51);
        }

        .discount_p {
            padding: 5px 0;
            border: 4px dotted gray;
            background: rgb(208, 208, 208);
            text-align: center;
        }

        .time-up {
            width: 250px;
            text-align: center;
            background: rgb(247, 100, 47);
            color: white;
            margin: 0 auto;
            padding: 5px;
        }

        .mail_content h3 {
            margin: 0;
        }

        .mess {
            margin: 0 0 10px 0;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="mail_header">
            <h2><i class="far fa-envelope-open"></i> BEAUTY GROUP</h2>
        </div>
        <div class="mail_content">
            <h3>Hi,</h3>
            <p class="mess">Hiện tại shop đang có một voucher khuyến mãi   {{$discount['percent']}}% khi mua hàng tại shop <br>
            Ghé qua shop mua hàng để được nhận voucher này nhé!</p>
            <p class="discount_p">Mã giảm giá : <strong>   {{$discount['code']}} </strong></p>
            <div class="time-up">
              <strong> Mã giảm giá {{$discount['percent']}}% </strong> <br>
                <span>Ngày hết hạn  {{$discount['end_discount']}}</span>
            </div>
        </div>
    </div>
    {{-- <div class="labels">
        <div class="container">
            <div class="row">
                <div class="">
                  <div  class="dl">
                    <div class="brand">
                        <h2>CosmeticShop</h2>
                    </div>
                    <div class="discount emerald">
                      
                        <div class="type">
                            Onl
                        </div>
                    </div>
                    <div class="descr">
                        <strong>
                            {{$discount['desc']}} 
                        </strong> 
                        
                    <div class="ends">
                        <small>
                           Thời gian kết thúc: {{$discount['end_discount']}}
                        </small>
                    </div>
                    <div class="coupon midnight-blue">
                        <a data-toggle="collapse" href="#code-2" class="open-code">Get a code</a>
                        <div id="code-2" class="collapse in code">
                        
                        </div>
                    </div>
                  </div>
            </div>
        </div>
    </div> --}}
</body>


</html>


