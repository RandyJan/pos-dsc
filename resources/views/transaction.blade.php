<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>



<div class="">
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L1']) !!}</p>
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L2']) !!}</p>
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L3']) !!}</p>
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L4']) !!}</p>
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L5']) !!}</p>
     <table>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($items as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['price'] }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
            <tfoot>
                <tr>
                    {{-- <td>Total:</td>
                    <td>{{ $total }}</td> --}}

                    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Footer_L1']) !!}</p>
                    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Footer_L2']) !!}</p>
                    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Footer_L3']) !!}</p>
                    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Footer_L4']) !!}</p>
                    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Footer_L5']) !!}</p>

                </tr>
            </tfoot>
        </table>
    </div>

</body>
</html>
