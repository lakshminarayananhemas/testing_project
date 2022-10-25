<!DOCTYPE html>
<html>

<head>
    <title>ALTEC Invoice</title>
    <!-- <link rel="stylesheet" type="text/css" href="{{ base_path().'/assets/css/bootstrap.css' }}"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->


    <style>
    @media screen,
    print {

        table {
            width: 100%;
            /* border-spacing: 5px 0px 5px 0px; */
            font-size:8pt;
            font-family: "Arial Narrow", Arial, sans-serif;
            border-collapse: collapse!important;

        }
        table>tbody>tr{
            border-bottom: none;
        }
        th,
        td {
            text-align: left;
            vertical-align: top;

            /* margin: 5px 5px 5px 5px; */
            padding: 4px 4px 4px 4px;
        }
    }

    .right_align {
        text-align: right;
    }

    .center_align {
        text-align: center;
    }
    .justify_align{
        text-align: justify;
    }
    li {
        margin-bottom: 5px;
    }

    .red {
        color: red;
    }

    footer {
        position: fixed;
        bottom: -35px;
        left: 0px;
        right: 0px;
        /* background-color: lightblue; */
        height: 100px;
    }

    .p_lh {
        line-height: 1.5;
    }
    /* span {
        page-break-after: always;
    }

    span:last-child {
        page-break-after: never;
    } */
    body{
        font-family: "Arial Narrow", Arial, sans-serif;
        font-style: normal;
        font-size:11pt;

    }
    .p_st{
        font-size:8pt;
        line-height: 0.5;

    }
    /* Create three unequal columns that floats next to each other */
    .column {
    float: left;
    padding:10px;
    }

    .left {
    width: 25%;
    }
    
    .right {
    width: 8%;
    }

    .middle {
    width: 60%;
    }

    /* Clear floats after the columns */
    .row:after {
    content: "";
    display: table;
    clear: both;
    }
    </style>
</head>

<body>

    <footer>
        <p class="center_align" style="margin-bottom:-15px;"><strong>Page 1/1</strong></p>
        
        
    </footer>

    <main>

        <h2 class="text-center"><strong>Tax Invoice<strong></h2>

        <table  cellspacing="0" cellpadding="0" width="100%" >
            <tbody>
                
                <tr>
                    <td width="30%">
                        <br>
                        <p  class="p_st"><strong>From : </strong></p>
                        <p  class="p_st"><strong>ARIHANT DISTRIBUTORS</strong></p>
                        <p  class="p_st">0000085175</p>
                        <p  class="p_st">43, TIRUPALLI STREET, CHENNAI</p>
                        <p  class="p_st">Ph : 9840027737</p>
                        <p  class="p_st">GSTIN No : 33AABPD8460G1Z2</p>
                        <p  class="p_st">FSSAINo :</p>
                        <p  class="p_st">GST State : Tamil Nadu</p>
                    </td>
                    <td width="30%">
                        <br>
                        <p  class="p_st"><strong>To :</strong></p>
                        <p  class="p_st"><strong>KUBER MARKETING</strong></p>
                        <p  class="p_st"><strong>Shipping Address :</strong></p>
                        <p  class="p_st">No.40/16 PERUMAL MUDILA STREET,Chennai</p>
                        <p  class="p_st">GSTIN No : 33AABPD8460G1Z2</p>
                        <p  class="p_st">FSSAINo :</p>
                        <p  class="p_st">GST State : Tamil Nadu</p>
                    </td>
                    
                    <td width="20%"  class="right_align">
                        <br>
                        <p  class="p_st"><strong>Inv No : </strong></p>
                        <p  class="p_st">Date :</p>
                        <p  class="p_st">SM Name :</p>
                        <p  class="p_st">RT Name :</p>
                        <p  class="p_st">Phone :</p>
                        <p  class="p_st">Shipping Date :</p>
                    </td>
                    <td width="20%">
                        <br>
                        <p  class="p_st"><strong> {{ $invoice_number }}</strong></p>
                        <p  class="p_st"> {{ $invoice_date }}</p>
                        <p  class="p_st"> {{ $salesman_code }}</p>
                        <p  class="p_st">GEORGE TOWN WHOLESALE</p>
                        <p  class="p_st">8144444411</p>
                        <p  class="p_st"> {{ $invoice_date }}</p>
                    </td>
                </tr>
            </tbody>
        </table>


       
        <table border="1" width="100%" class="table-condensed">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>HSN Code</th>
                    <th>Product Name</th>
                    <th>MRP</th>
                    <th>Inv Qty</th>
                    <th>Rate</th>
                    <th>Scheme Disc</th>
                    <th>Gross Amt</th>
                    <th>CGST / IGST %</th>
                    <th>CGST / IGST</th>
                    <th>SGST / UTGST %</th>
                    <th>SGST / UTGST</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>

                @php 
                    $total_cgst_amount = 0;
                    $total_sgst_amount = 0;
                    $total_gross_amount = 0;
                @endphp
                @for ($i = 0; $i < $item_count; $i++)
                    @php
                        $cgst_amt = ($tax_amt[$i] / 2);
                        $sgst_amt = ($tax_amt[$i] / 2);

                        $total_cgst_amount += $cgst_amt;
                        $total_sgst_amount += $sgst_amt;

                    $total_gross_amount += $gross_amt[$i];

                    @endphp
                    <tr class="noborder">
                        <td>{{$i + 1}}</td>
                        <td>{{ $hsn_code[$i] }}</td>
                        <td>{{ $product_name[$i] }}</td>
                        <td>{{ $mrp[$i] }}</td>
                        <td>{{ $order[$i] }}</td>
                        <td>{{ $sell_rate[$i] }}</td>
                        <td>0.00</td>
                        <td>{{ $gross_amt[$i] }}</td>
                        <td>9.00</td>
                        <td>{{$cgst_amt}}</td>
                        <td>9.00</td>
                        <td>{{ $sgst_amt }}</td>
                        <td>{{ $net_amt[$i] }}</td>
                    </tr>

                @endfor

                
            </tbody>
            
        </table>
        <br>

        <div class="row">
            <div class="column left">
                <p class="p_st"><strong>Tax Details:<strong></p>
                <table border="1"  class="table-condensed">
                    <thead>
                        <tr>
                            <th>Tax Desc</th>
                            <th>Tax%</th>
                            <th>Taxable Amt</th>
                            <th>Tax Amt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>CGST</td>
                            <td>9.00</td>
                            <td>{{$total_gross_amount}}</td>
                            <td>
                                @php 
                                    $cgst_taxt_amount = (0.09 * $total_gross_amount)
                                @endphp
                                {{$cgst_taxt_amount}}
                            </td>
                        </tr>
                        <tr>
                            <td>SGST</td>
                            <td>9.00</td>
                            <td>{{$total_gross_amount}}</td>
                            <td>
                                @php 
                                    $sgst_taxt_amount = (0.09 * $total_gross_amount)
                                @endphp
                                {{$sgst_taxt_amount}}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <p class="p_st">Declaration:</p>
                <p class="p_st"><strong>(E. & O.E.)</strong></p>
            </div>
            @php 
                $put_tax_amt = ($sgst_taxt_amount + $sgst_taxt_amount);
                $put_net_amt = ($gross_amount + $put_tax_amt)
            @endphp
            <div class="column middle right_align">
                <p class="p_st">Gross Amt(incl.disc) : </p>
                <p class="p_st">Scheme Disc Amt(-) : </p>
                <p class="p_st">Others Disc Amt(-) : </p>
                <p class="p_st">Tax Amount(+) : </p>
                <p class="p_st">TCS Amount(+) : </p>
                <p class="p_st">Round Off : </p>
                <p class="p_st"><strong>Net Amount : </strong></p>
                <p class="p_st">Cr/Db Amt(+/-) : </p>
                <p class="p_st"><strong>Net Payable : </strong></p>

                <p class="p_st"><strong>For :ARIHANT DISTRIBUTORS</strong></p>
            </div>
            <div class="column right right_align">
                <p class="p_st"><span> {{$total_gross_amount}}</span></p>
                <p class="p_st"><span> 0.00</span></p>
                <p class="p_st"><span> 0:00</span></p>
                <p class="p_st"><span> {{$put_tax_amt}}</span></p>
                <p class="p_st"><span> 0.00</span></p>
                <p class="p_st"><span> 0.00</span></p>
                <p class="p_st"><strong><span> {{$put_net_amt}}</span></strong></p>
                <p class="p_st"><span> 0.00 </span></p>
                <p class="p_st"><strong><span> {{$put_net_amt}}</span></strong></p>

            </div>
        </div>


        <main>
</body>

</html>