<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
    .labels{padding:5% 0}
    .alizarin{background:#e74c3c}
    .amethyst{background:#9b59b6}
    .emerald{background:#2ecc71}
    .midnight-blue{background:#2c3e50}
    .peter-river{background:#3498db}
    .dl{background:#f0f0f0;padding:30px 0;border-radius:20px;position:relative}
    .dl:before{content:" ";height:20px;width:20px;background:#ddd;border-radius:20px;position:absolute;left:50%;top:20px;margin-left:-10px}
    .dl .brand{text-transform:uppercase;letter-spacing:3px;padding:10px 15px;margin-top:10px;text-align:center;min-height:100px}
    .dl .discount{min-height:50px;position:relative;font-size:80px;line-height:80px;text-align:center;font-weight:700;padding:20px 15px 0;color:#f1c40f}
    .dl .discount:after{content:" ";border-right:20px solid transparent;border-left:20px solid transparent;position:absolute;bottom:-20px;left:20%}
    .dl .discount.alizarin:after{border-top:20px solid #e74c3c}
    .dl .discount.peter-river:after{border-top:20px solid #3498db}
    .dl .discount.emerald:after{border-top:20px solid #2ecc71}
    .dl .discount.amethyst:after{border-top:20px solid #9b59b6}
    .dl .discount .type{font-size:20px;letter-spacing:1px;text-transform:uppercase;margin-top:-30px}
    .dl .descr{color:#999;margin-top:10px;padding:20px 15px}
    .dl .ends{padding:0 15px;color:#f1c40f;margin-bottom:10px}
    .dl .coupon{min-height:50px;text-align:center;text-transform:uppercase;font-weight:700;font-size:18px;padding:20px 15px}
    .dl .coupon a.open-code{color:#16a085}
    .dl .coupon .code{letter-spacing:1px;border-radius:4px;margin-top:10px;padding:10px 15px;color:#f1c40f;background:#f0f0f0}`
    </style>
</head>
<body>
    <div class="labels">
        <div class="container">
            <div class="row">
                <div class="">
                  <div  class="dl">
                    <div class="brand">
                        <h2>CosmeticShop</h2>
                    </div>
                    <div class="discount emerald">
                        {{$discount['percent']}}%
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
                           {{$discount['code']}}
                        </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</body>


</html>


