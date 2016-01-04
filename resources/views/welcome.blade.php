<!DOCTYPE html>
<html>
    <head>
        <meta name="_token" content="{{ csrf_token() }}"/>
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <!--jQuery-->
        <script type="text/javascript" src="{{ asset('jquery-1.11.1.min.js') }}"></script>

        {{--<style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>--}}
    </head>
    <body>
    <div>
        <!-- Generate a form for adding article -->
        {!! Form::open([
            'route' => 'add.product',
         ]) !!}
        <div class="form-group">
            <label for="name">Product Name</label>
            <input id="name" type="text" name="title">
        </div>
        <div class="form-group">
            <label for="quantity">Quantity in stock</label>
            <input id="quantity" type="text" name="quantity">
        </div>
        <div class="form-group">
            <label for="price">Price per item</label>
            <input id="price" type="text" name="price">
        </div>
        <div class="form-group">
            <input id="submit" type="submit" value="Send">
        </div>
        {!! Form::close() !!}
    </div>
    <div class="result">
        <table id="table" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Quantity in stock</th>
                <th>Price per item</th>
                <th>Date</th>
                <th>Total value number</th>
            </tr>
            </thead>
            <tbody id="table-body">

            @if(isset($products))
                @foreach($products as $key=>$value)
                    <?php
                    $total = $value->price * $value->quantity;
                    ?>
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->quantity }}</td>
                        <td>{{ $value->price }}</td>
                        <td>{{ $value->created_at }}</td>
                        <td>{{ $total }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    </body>
<script>
    // contact form
    $(document).on("click","#submit",function(e) {
        e.preventDefault();

        var name = $(this).parent().parent().find('#name').val();
        var quantity = $(this).parent().parent().find('#quantity').val();
        var price = $(this).parent().parent().find('#price').val();

        $.post("add-product", {
            '_token': $('meta[name=_token]').attr('content'),
            name: name,
            quantity: quantity,
            price: price
        }, function(region) {

            var total = parseInt(region.product.price) * parseInt(region.product.quantity);

            $('#table-body').append(
                    '<tr>'+
                            '<td>'+region.product.id+'</td>'+
                            '<td>'+region.product.name+'</td>'+
                            '<td>'+region.product.quantity+'</td>'+
                            '<td>'+region.product.price+'</td>'+
                            '<td>'+region.product.created_at+'</td>'+
                            '<td>'+total+'</td>'+
                    '</tr>'
            );

            $("#name").val('');
            $("#quantity").val('');
            $("#price").val('');
        });


    });
</script>
</html>
